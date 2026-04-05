<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->timestamp('last_opened_at');
            $table->timestamps();

            $table->unique(['user_id', 'post_id']);
            $table->index(['user_id', 'last_opened_at']);
        });

        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'sort_order']);
        });

        Schema::table('saved_posts', function (Blueprint $table) {
            $table->foreignId('collection_id')->nullable()->after('post_id')->constrained()->nullOnDelete();
        });

        Schema::create('learning_paths', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('learning_path_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_path_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->string('step_type', 32);
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->foreignId('post_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['learning_path_id', 'sort_order']);
        });

        Schema::create('learning_path_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learning_path_step_id')->constrained()->cascadeOnDelete();
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->unique(['user_id', 'learning_path_step_id']);
        });

        Schema::create('daily_check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('checked_on');
            $table->boolean('took_action')->default(false);
            $table->boolean('read_something')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'checked_on']);
            $table->index(['user_id', 'checked_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_check_ins');
        Schema::dropIfExists('learning_path_progress');
        Schema::dropIfExists('learning_path_steps');
        Schema::dropIfExists('learning_paths');

        Schema::table('saved_posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('collection_id');
        });

        Schema::dropIfExists('collections');
        Schema::dropIfExists('post_reads');
    }
};
