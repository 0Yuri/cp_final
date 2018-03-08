<?php

use Illuminate\Database\Seeder;

class productsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 50; $i++){
          DB::table('products')->insert([
            'store_id' => 1,
            'category_id' => 1,
            'brand_id' => 1,
            'name' => str_random(10),
            'description' => str_random(10),
            'gender' => 'unisex',
            'quality' => 'Novo',
            'original_price' => 12,
            'price' => 10,
            'height' => 1,
            'width' => 1,
            'length' => 1,
            'weight' => 1
          ]);
        }
    }
}
