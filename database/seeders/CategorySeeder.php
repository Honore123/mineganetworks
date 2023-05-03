<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['Goods', 'Services'])->each(function ($category) {
            ProductCategory::firstOrCreate([
                'category_name' => $category,
            ]);
        });
    }
}
