<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SkillsTableSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'HTML', 'url' => 'https://developer.mozilla.org/docs/Web/HTML', 'icon' => '/assets/icons/html.svg'],
            ['name' => 'CSS', 'url' => 'https://developer.mozilla.org/docs/Web/CSS', 'icon' => '/assets/icons/css.svg'],
            ['name' => 'JavaScript', 'url' => 'https://developer.mozilla.org/docs/Web/JavaScript', 'icon' => '/assets/icons/javascript.svg'],
            ['name' => 'PHP', 'url' => 'https://www.php.net/', 'icon' => '/assets/icons/php.svg'],
            ['name' => 'Laravel', 'url' => 'https://laravel.com/', 'icon' => '/assets/icons/laravel.svg'],
            ['name' => 'Vue.js', 'url' => 'https://vuejs.org/', 'icon' => '/assets/icons/vue.svg'],
            ['name' => 'Docker', 'url' => 'https://www.docker.com/', 'icon' => '/assets/icons/docker.svg'],
            ['name' => 'MySQL', 'url' => 'https://www.mysql.com/', 'icon' => '/assets/icons/mysql.svg'],
            ['name' => 'PostgreSQL', 'url' => 'https://www.postgresql.org/', 'icon' => '/assets/icons/postgresql.svg'],
            ['name' => 'Redis', 'url' => 'https://redis.io/', 'icon' => '/assets/icons/redis.svg'],
            ['name' => 'Git', 'url' => 'https://git-scm.com/', 'icon' => '/assets/icons/git.svg'],
            ['name' => 'GitHub', 'url' => 'https://github.com/', 'icon' => '/assets/icons/github.svg'],
            ['name' => 'Nginx', 'url' => 'https://nginx.org/', 'icon' => '/assets/icons/nginx.svg'],
            ['name' => 'Tailwind CSS', 'url' => 'https://tailwindcss.com/', 'icon' => '/assets/icons/tailwind.svg'],
            ['name' => 'Bootstrap', 'url' => 'https://getbootstrap.com/', 'icon' => '/assets/icons/bootstrap.svg'],
        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'name' => $skill['name'],
                'url' => $skill['url'],
                'icon' => $skill['icon'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
