<?php

namespace Database\Seeders;

use App\Models\MeasurementUnit;
use Illuminate\Database\Seeder;

class MeasurementUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            ['name' => 'Meter', 'abbr' => 'm'],
            ['name' => 'Each', 'abbr' => 'Each'],
            ['name' => 'Site', 'abbr' => 'Site'],
            ['name' => 'Can', 'abbr' => 'Can'],
            ['name' => 'Kilogram', 'abbr' => 'Kg'],
            ['name' => 'Liter', 'abbr' => 'l'],
            ['name' => 'Meter Cubic', 'abbr' => 'm3'],
            ['name' => 'Meter Square', 'abbr' => 'm2'],
            ['name' => 'Trip', 'abbr' => 'Trip'],
            ['name' => 'Lumpsum', 'abbr' => 'Lumpsum'],
            ['name' => 'Roll', 'abbr' => 'Rl'],
            ['name' => 'Piece', 'abbr' => 'Pce'],
        ])->each(function ($unit) {
            MeasurementUnit::firstOrCreate([
                'unit_name' => $unit['name'],
                'unit_abbr' => $unit['abbr'],
            ]);
        });
    }
}
