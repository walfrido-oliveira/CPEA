<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forms')->insert([
            'field_type_id' => 3,
            'name' => 'RT-LAB-020',
            'infos' => '<div class="flex flex-wrap mx-4 px-3 py-2 mt-4"> <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"> <p><b>Identificação:</b></p> <p><b>Referência:</b></p> <p><b>Versão:</b></p> <p><b>Publicação:</b></p> </div> <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"> <p>RT-GPA-047</p> <p>POP-GPA-006</p> <p>13.0</p> <p>30/08/2021</p> </div> </div> <div class="flex flex-wrap mx-4 px-3 py-2 mt-4"> <div class="w-full px-3 mb-6 md:mb-0"> <p><b>Intervalo entre leituras dos parâmetros FQ após estabilização (vazão 100mL/min)</b></p> </div> </div> <div class="flex flex-wrap mx-4 px-3 py-2 mt-4"> <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"> <p><b>Profundidade da bomba</b></p> <p>até 2m</p> <p>3 a 11m</p> <p>12 a 19m</p> <p>20 a 27m</p> <p>22 a 36m</p> </div> <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"> <p><b>Tempo (min)</b></p> <p>3</p> <p>4</p> <p>5</p> <p>6</p> <p>7</p> </div> </div>'
        ]);
    }
}
