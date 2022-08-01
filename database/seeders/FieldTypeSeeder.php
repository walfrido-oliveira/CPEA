<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Field::getFieldsArray() as $value)
        {
            DB::table('field_types')->insert([
                'name' => $value,
            ]);
        }
    }
}
