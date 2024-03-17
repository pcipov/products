<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();
        $products = [];
        $xml = Storage::get('import/feed.xml');
        $xml = strtr($xml, ["\n" => '']);
        preg_match_all('/<item>(.*?)<\/item>/', $xml, $matches);
        foreach($matches[1] as $match) {
            preg_match('/<g:title>(.*?)<\/g:title>/', $match, $matchTitle);
            preg_match('/<url>(.*?)<\/url>/', $match, $matchUrl);
            if($matchTitle && $matchUrl) {
                $products[] = [
                    'name' => $matchTitle[1],
                    'url' => $matchUrl[1],
                ];
            }
        }
        Product::insert($products);
    }
}
