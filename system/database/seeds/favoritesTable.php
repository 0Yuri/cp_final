<?php

use Illuminate\Database\Seeder;

class favoritesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i = 2; $i < 13; $i++){
        DB::table('favorites')->insert([
          'product_id' => $i,
          'user_id' => 1,
        ]);
      }
    }
}
