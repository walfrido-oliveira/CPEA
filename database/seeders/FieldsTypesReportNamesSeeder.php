<?php

namespace Database\Seeders;

use App\Models\FieldType;
use Illuminate\Database\Seeder;

class FieldsTypesReportNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $second = FieldType::find(2);
        $third = FieldType::find(3);

        $second->update([
            'report_name' => 'Água Subterrânea'
        ]);

        $third->update([
            'report_name' => 'Água Subterrânea'
        ]);
    }
}
