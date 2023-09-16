<?php

namespace Database\Seeders;

use App\Models\InvoiceTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['P.O based', 'Contract based'])->each(function ($name) {
            InvoiceTypes::firstOrCreate([
                'type_name' => $name,
            ]);
        });
    }
}
