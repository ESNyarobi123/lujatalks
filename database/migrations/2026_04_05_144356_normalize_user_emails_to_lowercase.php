<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Fortify lowercases email on login; if the DB used case-sensitive collation (e.g. utf8mb4_bin) or SQLite exact match,
     * stored mixed-case emails never matched. Normalize all rows once.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('UPDATE users SET email = LOWER(TRIM(email)) WHERE email IS NOT NULL');

            return;
        }

        DB::table('users')->orderBy('id')->chunk(200, function ($rows): void {
            foreach ($rows as $row) {
                $normalized = Str::lower(trim((string) ($row->email ?? '')));
                if ($normalized === '' || $normalized === $row->email) {
                    continue;
                }

                DB::table('users')->where('id', $row->id)->update([
                    'email' => $normalized,
                    'updated_at' => now(),
                ]);
            }
        });
    }
};
