<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;
use Carbon\Carbon;
class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['code' => 'ar', 'name' => 'Arabic', 'active' => false],
            ['code' => 'de', 'name' => 'German', 'active' => true],
            ['code' => 'en', 'name' => 'English', 'active' => true],
            ['code' => 'es', 'name' => 'Spanish', 'active' => true],
            ['code' => 'fa', 'name' => 'Persian', 'active' => false],
            ['code' => 'fr', 'name' => 'French', 'active' => true],
            ['code' => 'hi', 'name' => 'Hindi', 'active' => false],
            ['code' => 'id', 'name' => 'Indonesian', 'active' => false],
            ['code' => 'it', 'name' => 'Italian', 'active' => false],
            ['code' => 'ja', 'name' => 'Japanese', 'active' => false],
            ['code' => 'ko', 'name' => 'Korean', 'active' => false],
            ['code' => 'nl', 'name' => 'Dutch', 'active' => false],
            ['code' => 'pl', 'name' => 'Polish', 'active' => false],
            ['code' => 'pt', 'name' => 'Portuguese', 'active' => false],
            ['code' => 'ru', 'name' => 'Russian', 'active' => false],
            ['code' => 'th', 'name' => 'Thai', 'active' => false],
            ['code' => 'tr', 'name' => 'Turkish', 'active' => false],
            ['code' => 'vi', 'name' => 'Vietnamese', 'active' => false],
            ['code' => 'zh', 'name' => 'Chinese', 'active' => false],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(['code' => $lang['code']], [
                'name' => $lang['name'],
                'active' => $lang['active'],
            ]);
        }
    }
}
