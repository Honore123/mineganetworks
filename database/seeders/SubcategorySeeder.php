<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['InBuilding Solution', 'Tower Building Materials', 'Site Installation', 'Site dismantoling', 'Transportation', 'Zones'])->each(function ($subCat) {
            Subcategory::firstOrCreate([
                'sub_name' => $subCat,
            ]);
        });
    }
}
