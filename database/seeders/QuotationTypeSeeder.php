<?php

namespace Database\Seeders;

use App\Models\QuotationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuotationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['Customer with FC', 'Normal Customer'])->each(function ($type) {
            QuotationType::firstOrCreate([
                'quotation_type' => $type,
            ]);
        });
    }
}
