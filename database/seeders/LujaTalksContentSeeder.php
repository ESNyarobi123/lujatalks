<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Motivation;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;

/**
 * Seeds realistic Luja Talks content so every public page reads from the database (not hardcoded UI samples).
 */
class LujaTalksContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@lujatalks.com'],
            [
                'name' => 'Lucy Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );

        $memberA = User::query()->updateOrCreate(
            ['email' => 'member@lujatalks.com'],
            [
                'name' => 'Amina Juma',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
        );

        $memberB = User::query()->updateOrCreate(
            ['email' => 'james@lujatalks.com'],
            [
                'name' => 'James Mwalimu',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
        );

        Motivation::query()->updateOrCreate(
            ['display_date' => today()->toDateString()],
            [
                'quote' => 'Dira ya mafanikio haina njia moja tu inayoenda sawa; mara nyingi unapaswa kutengeneza njia yako mwenyewe.',
                'author' => 'Luja Talks',
                'message' => 'Hii ni sehemu yako ya kujifunza, kukuwa na kuwa bora kila siku. Usichoke kutafuta maarifa.',
            ],
        );

        Motivation::query()->updateOrCreate(
            ['display_date' => today()->subDays(7)->toDateString()],
            [
                'quote' => 'Hatua ndogo za kila siku ndizo zinazounda maisha makubwa.',
                'author' => 'Luja Talks',
                'message' => 'Endelea kusoma, kuweka malengo, na kuzitekeleza.',
            ],
        );

        $categories = [
            [
                'name' => 'Success & Growth',
                'slug' => 'success-growth',
                'description' => 'Makala kuhusu maendeleo ya kibinafsi, biashara, na kujitambua.',
            ],
            [
                'name' => 'Faith & Purpose',
                'slug' => 'faith-purpose',
                'description' => 'Kusudi, imani, na maadili katika safari ya maisha.',
            ],
            [
                'name' => 'Money & Work',
                'slug' => 'money-work',
                'description' => 'Fedha, kazi, na ustawi wa kiuchumi kwa vijana.',
            ],
            [
                'name' => 'Relationships',
                'slug' => 'relationships',
                'description' => 'Mahusiano ya afya: familia, marafiki, na jamii.',
            ],
        ];

        $categoryIds = [];
        foreach ($categories as $c) {
            $cat = Category::query()->updateOrCreate(
                ['slug' => $c['slug']],
                ['name' => $c['name'], 'description' => $c['description']],
            );
            $categoryIds[$c['slug']] = $cat->id;
        }

        $tagDefs = [
            ['name' => 'Vijana', 'slug' => 'vijana'],
            ['name' => 'Biashara', 'slug' => 'biashara'],
            ['name' => 'Malengo', 'slug' => 'malengo'],
            ['name' => 'Imani', 'slug' => 'imani'],
            ['name' => 'Fedha', 'slug' => 'fedha'],
            ['name' => 'Tabia', 'slug' => 'tabia'],
            ['name' => 'Afya ya akili', 'slug' => 'afya-ya-akili'],
            ['name' => 'Uongozi', 'slug' => 'uongozi'],
        ];

        $tagIds = [];
        foreach ($tagDefs as $t) {
            $tag = Tag::query()->updateOrCreate(
                ['slug' => $t['slug']],
                ['name' => $t['name']],
            );
            $tagIds[$t['slug']] = $tag->id;
        }

        $articles = [
            [
                'slug' => 'jinsi-ya-kuanza-safari-ya-mafanikio',
                'category' => 'success-growth',
                'title' => 'Jinsi ya Kuanza Safari ya Mafanikio Bila Kuchoka',
                'is_trending' => true,
                'tags' => ['vijana', 'malengo', 'tabia'],
                'feature_image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200&q=80',
                'content' => <<<'HTML'
<h2>Anza kwa ukweli mdogo</h2>
<p>Mafanikio hayaja undwa kwa siku moja. Wengi huanguka kwa sababu wanataka mabadiliko makubwa mara moja. Anza na <strong>tabia moja</strong> unayoweza kudumisha kwa wiki mbili.</p>
<h2>Andika dira fupi</h2>
<p>Andika kwa sentensi tatu: unataka kuwa nani mwaka ujao, na ni hatua gani ya kwanza leo. Hii si kwa mtu mwingine — ni kwa ajili yako.</p>
<h2>Punguza kelele za nje</h2>
<p>Punguza muda wa mitandao kama unahisi inakuchanganya. Badala yake, soma makala moja au ongea na mtu anayekuunga mkono.</p>
HTML,
            ],
            [
                'slug' => 'biashara-ndogo-kuanzia-wapi',
                'category' => 'success-growth',
                'title' => 'Biashara Ndogo: Kuanzia Wapi Ukiwa na Bajeti Ndogo',
                'is_trending' => true,
                'tags' => ['biashara', 'vijana', 'fedha'],
                'feature_image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&q=80',
                'content' => <<<'HTML'
<h2>Tatizo kwanza, sio bidhaa</h2>
<p>Wafanyabiashara wengi huanza kwa bidhaa badala ya <em>tatizo</em>. Uliza: ni nani ana maumivu gani na anaweza kulipa suluhisho dogo?</p>
<h2>Jaribio la wiki 2</h2>
<p>Badala ya kuweka pesa nyingi, fanya jaribio: uza kwa marafiki, ujumbe mfupi WhatsApp, au foleni moja ya soko. Jifunze kutoka majibu halisi.</p>
<h2>Rekodi mapato na matumizi</h2>
<p>Hata daftari ndogo ya simu inatosha. Huwezi kujua biashara inaendeleaje bila nambari.</p>
HTML,
            ],
            [
                'slug' => 'malengo-yanavyofanya-akili-irekebishe-mwenendo',
                'category' => 'success-growth',
                'title' => 'Malengo Yanavyofanya Akili Irekebishe Mwenendo Wako',
                'is_trending' => false,
                'tags' => ['malengo', 'afya-ya-akili', 'tabia'],
                'feature_image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=1200&q=80',
                'content' => <<<'HTML'
<h2>Mengo ya wazi</h2>
<p>Akili inapenda uwazi. “Nisome zaidi” ni gumu. “Nisome dakika 20 kila usiku” ni kitendo kinachoweza kupimwa.</p>
<h2>Rudia badala ya kukosoa</h2>
<p>Ukikosa siku moja, usiache kabisa. Rudia siku inayofuata. Mstari wa mafanikio si mstari kamili — ni mfululizo unaendelea.</p>
HTML,
            ],
            [
                'slug' => 'kusudi-katika-kazi-ya-kila-siku',
                'category' => 'faith-purpose',
                'title' => 'Kusudi Katika Kazi ya Kila Siku',
                'is_trending' => false,
                'tags' => ['imani', 'malengo', 'uongozi'],
                'feature_image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=1200&q=80',
                'content' => <<<'HTML'
<h2>Kazi ni ibada ya mpangilio</h2>
<p>Haihitaji kuwa kanisani ili kuishi kwa kusudi. Ukiwa unafanya kazi kwa uaminifu na huruma, unaleta nuru katika nafasi yako.</p>
<h2>Uliza: nina saidia nani leo?</h2>
<p>Hata kazi ya ofisi inaweza kuwa huduma kwa mtu mwingine. Badilisha mtazamo kutoka “ninapaswa” hadi “ninaweza kusaidia”.</p>
HTML,
            ],
            [
                'slug' => 'fedha-binafsi-hatua-tano',
                'category' => 'money-work',
                'title' => 'Fedha Binafsi: Hatua Tano za Kuanzia Leo',
                'is_trending' => false,
                'tags' => ['fedha', 'vijana', 'malengo'],
                'feature_image' => 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=1200&q=80',
                'content' => <<<'HTML'
<h2>1. Jua unapokwenda pesa</h2>
<p>Andika matumizi ya wiki moja bila hukumu. Hii ndiyo ramani yako ya kweli.</p>
<h2>2. Akiba ndogo ni bora kuliko hakuna</h2>
<p>Hata kiasi kidogo kila wiki kinajenga utulivu wa akili.</p>
<h2>3. Epuka madeni ya starehe</h2>
<p>Simu mpya kwa mkopo wa riba kali inaweza kukufunga miaka mingi.</p>
HTML,
            ],
            [
                'slug' => 'mawasiliano-ya-afya-na-familia',
                'category' => 'relationships',
                'title' => 'Mawasiliano ya Afya na Familia Yako',
                'is_trending' => false,
                'tags' => ['tabia', 'vijana'],
                'feature_image' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?w=1200&q=80',
                'content' => <<<'HTML'
<h2>Sikiliza kabla ya kujibu</h2>
<p>Watu wengi wanaskiliza ili wajibu, si ili waelewe. Pumzika sekunde mbili kabla ya kusema.</p>
<h2>Weka mipaka kwa heshima</h2>
<p>Mipaka si uadui — ni ulinzi wa mahusiano. Eleza kwa utulivu unachohitaji.</p>
HTML,
            ],
            [
                'slug' => 'uongozi-kuanzia-nyumbani',
                'category' => 'success-growth',
                'title' => 'Uongozi Unaanzia Nyumbani na Kwako Mwenyewe',
                'is_trending' => false,
                'tags' => ['uongozi', 'tabia', 'malengo'],
                'feature_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&q=80',
                'content' => <<<'HTML'
<h2>Onyo na mfano</h2>
<p>Huwezi kuwashauri wengine kudhibiti hasira ukijiacha wewe mwenyewe. Anza kuongoza maisha yako ya ndani.</p>
<h2>Shukrani ya kila siku</h2>
<p>Andika kitu kimoja ulichofanya vizuri leo. Huu ni mzizi wa uongozi wa fadhila.</p>
HTML,
            ],
            [
                'slug' => 'kujitambua-bila-kulinganishwa-na-mitandao',
                'category' => 'faith-purpose',
                'title' => 'Kujitambua Bila Kulinganishwa na Mitandao',
                'is_trending' => false,
                'tags' => ['afya-ya-akili', 'vijana', 'imani'],
                'feature_image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&q=80',
                'content' => <<<'HTML'
<h2>Picha za wengine si kipimo chako</h2>
<p>Mitandao inaonyesha matukio, si maisha kamili. Linganisha na <strong>wewe wa jana</strong>, si na mtu wa Instagram.</p>
<h2>Badilisha mfululizo</h2>
<p>Chagua siku moja bila kulinganisha: soma, tembea, au omba kwa utulivu.</p>
HTML,
            ],
        ];

        $postsBySlug = [];
        $publishedAt = now()->subDays(14);

        foreach ($articles as $index => $row) {
            $publishedAt = $publishedAt->copy()->addHours(6 + $index * 3);

            $post = Post::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'user_id' => $admin->id,
                    'category_id' => $categoryIds[$row['category']],
                    'title' => $row['title'],
                    'content' => $row['content'],
                    'feature_image' => $row['feature_image'],
                    'is_trending' => $row['is_trending'],
                    'status' => 'published',
                    'published_at' => $publishedAt,
                    'views_count' => 40 + ($index * 37),
                ],
            );

            $sync = [];
            foreach ($row['tags'] as $slug) {
                if (isset($tagIds[$slug])) {
                    $sync[$tagIds[$slug]] = ['created_at' => now(), 'updated_at' => now()];
                }
            }
            $post->tags()->sync($sync);
            $postsBySlug[$row['slug']] = $post;
        }

        // Standalone videos still tied to posts for consistent schema (optional post)
        $videoRows = [
            [
                'post_slug' => 'jinsi-ya-kuanza-safari-ya-mafanikio',
                'youtube_url' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
                'title' => 'Utangulizi: safari ya mabadiliko',
                'duration' => '9:56',
            ],
            [
                'post_slug' => 'biashara-ndogo-kuanzia-wapi',
                'youtube_url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
                'title' => 'Mawazo ya biashara ndogo',
                'duration' => '0:19',
            ],
            [
                'post_slug' => 'fedha-binafsi-hatua-tano',
                'youtube_url' => 'https://www.youtube.com/watch?v=ZbZSe6N_BXs',
                'title' => 'Fedha binafsi kwa anavyoanza',
                'duration' => '4:22',
            ],
        ];

        foreach ($videoRows as $vr) {
            if (! isset($postsBySlug[$vr['post_slug']])) {
                continue;
            }
            Video::query()->updateOrCreate(
                [
                    'post_id' => $postsBySlug[$vr['post_slug']]->id,
                    'youtube_url' => $vr['youtube_url'],
                ],
                [
                    'title' => $vr['title'],
                    'duration' => $vr['duration'],
                ],
            );
        }

        $commentBodies = [
            ['user_id' => $memberA->id, 'post_slug' => 'jinsi-ya-kuanza-safari-ya-mafanikio', 'content' => 'Nimeanza kuandika malengo ya kila wiki baada ya makala hii. Asante!'],
            ['user_id' => $memberB->id, 'post_slug' => 'jinsi-ya-kuanza-safari-ya-mafanikio', 'content' => 'Sehemu ya “punguza kelele” imeniuma sana. Nitajaribu usiku huu.'],
            ['user_id' => $memberA->id, 'post_slug' => 'biashara-ndogo-kuanzia-wapi', 'content' => 'Nimejaribu kuuza kwa marafiki kwanza — kuna wateja halisi kuliko nilivyofikiria.'],
            ['user_id' => $memberB->id, 'post_slug' => 'fedha-binafsi-hatua-tano', 'content' => 'Rekodi ya matumizi ya wiki imenifanya naona wazi ninakosea wapi.'],
            ['user_id' => $memberA->id, 'post_slug' => 'kusudi-katika-kazi-ya-kila-siku', 'content' => 'Nimebadilisha mtazamo wangu kazini tangu nisome hii.'],
            ['user_id' => $admin->id, 'post_slug' => 'mawasiliano-ya-afya-na-familia', 'content' => 'Karibu zaidi kwenye mada hii kwenye podcast ijayo ya Luja Talks.'],
        ];

        foreach ($commentBodies as $cb) {
            $post = $postsBySlug[$cb['post_slug']] ?? null;
            if (! $post) {
                continue;
            }
            Comment::query()->firstOrCreate(
                [
                    'user_id' => $cb['user_id'],
                    'post_id' => $post->id,
                    'content' => $cb['content'],
                    'parent_id' => null,
                ],
            );
        }
    }
}
