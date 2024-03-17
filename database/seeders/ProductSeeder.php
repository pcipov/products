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
        preg_match_all('/<g:title>(.*?)<\/g:title>/', $xml, $matches);
        foreach($matches[1] as $match) {
            $products[] = [
                'name' => $match,
            ];
        }
        Product::insert($products);
    }
}
