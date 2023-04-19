<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class DefaultDuplicateSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create([
            'name' => 'default_duplicate_size',
            'value' => 3,
            'type' => 'integer'
        ]);
    }
}
