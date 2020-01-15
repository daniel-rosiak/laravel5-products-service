<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('products')->get()->count() !== 0) {
            echo "\e[31mTable is not empty ";
            return;
        }
        /** @var array $data */
        $data = [];

        for($i = 0; $i<100; $i++) {

            Product::create([
                'sku' => str_random(40),
                'title' => 'Product title ' . str_random(10),
                'url' => str_random(100),
                'abstract' => mt_rand(0,1),
                'description' => str_random(1000),
                'price' => round(mt_rand(10, 10000) / 10,2),
                'image_url' => 'https://picsum.photos/200/300/?random',
                'stock' => mt_rand(0,1000)
            ]);
        }

    }
}
