<?php

namespace Database\Seeders;

use App\Models\DuplicateSize;
use App\Models\FieldType;
use App\Models\Form;
use Illuminate\Database\Seeder;

class DuplicateSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DuplicateSize::create([
            'form_id' => Form::where('name', 'RT-LAB-041-191')->first()->id,
            'field_type_id' => FieldType::where('name', 'Efluente')->first()->id,
            'size' => 2
        ]);

        DuplicateSize::create([
            'form_id' => Form::where('name', 'RT-LAB-041-191')->first()->id,
            'field_type_id' => FieldType::where('name', 'Ar Ambiente')->first()->id,
            'size' => 2
        ]);

        DuplicateSize::create([
            'form_id' => Form::where('name', 'RT-LAB-041-191')->first()->id,
            'field_type_id' => FieldType::where('name', 'Ar do solo')->first()->id,
            'size' => 2
        ]);
    }
}
