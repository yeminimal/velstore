<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $languages = Language::where('active', 1)->get();

            $banners = [
                [
                    'type' => 'promotion',
                    'status' => 1,
                    'translations' => [
                        'title' => 'Ready to Shop',
                        'description' => 'Your one-stop shop for everything you need.',
                        'image' => 'https://i.postimg.cc/sxpYkSgk/shoes-ready.png',
                    ],
                ],
            ];

            foreach ($banners as $item) {

                $banner = Banner::create([
                    'type' => $item['type'],
                    'status' => $item['status'],
                ]);

                foreach ($languages as $lang) {
                    $imageUrl = $item['translations']['image'];
                    $imageName = basename($imageUrl);

                    try {
                        $imageContents = file_get_contents($imageUrl);
                        $localPath = 'banners/'.$imageName;
                        Storage::disk('public')->put($localPath, $imageContents);
                    } catch (\Exception $e) {
                        $localPath = $imageUrl;
                    }

                    $banner->translations()->create([
                        'language_code' => $lang->code,
                        'title' => $item['translations']['title'],
                        'description' => $item['translations']['description'],
                        'image_url' => $localPath,
                    ]);
                }
            }
        });
    }
}
