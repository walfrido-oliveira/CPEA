<?php

namespace Database\Seeders;

use App\Models\To;
use Illuminate\Database\Seeder;

class ToNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            '1,1,2-Tricloroeteno (Tricloroeteno)',
            'Alumínio dissolvido (Al)',
            'Alumínio total (Al)',
            'anacode',
            'anadate',
            'analysis',
            'analyst',
            'analyte',
            'analyteorder',
            'anote',
            'Antimônio dissolvido (Sb)',
            'Antimônio total (Sb)',
            'Arsênio total (As)',
            'basis',
            'batch',
            'Berílio total (Be)',
            'Cádmio total (Cd)',
            'casnumber',
            'Chumbo total (Pb)',
            'client',
            'Cobre dissolvido (Cu)',
            'Cobre total (Cu)',
            'Cromo III',
            'Cromo total (Cr)',
            'd/m/Y',
            'description',
            'dilution',
            'dl',
            'Fenóis totais',
            'Ferro dissolvido (Fe)',
            'Fósforo Total',
            'labname',
            'labsampid',
            'latitude',
            'lnote',
            'longitude',
            'lowercl',
            'Manganês dissolvido (Mn)',
            'Manganês total (Mn)',
            'matrix',
            'Mercúrio total (Hg)',
            'methodcode',
            'methodname',
            'mrlsolids',
            'Níquel total (Ni)',
            'Nitrato com N',
            'Nitrito com o N',
            'Óleo mineral',
            'Óleos e graxas',
            'Óleos vegetais e gorduras animais',
            'Ortofosfato',
            'Prata total (Ag)',
            'prepdate',
            'prepname',
            'project',
            'projectnum',
            'psolids',
            'recovery',
            'result',
            'rl',
            'rptmatrix',
            'rptomdl',
            'sampdate',
            'samplename',
            'scomment',
            'Selênio total (Se)',
            'snote1',
            'snote2',
            'snote3',
            'solidmatrix',
            'Sólidos sedimentáveis',
            'spikelevel',
            'surrogate',
            'Tálio total (Tl)',
            'Tetracloroeteno (PCE)',
            'tic',
            'units',
            'uppercl',
            'Vanádio total (V)',
            'Zinco total (Zn)',
        ];

        foreach ($names as $key => $value)
        {
            To::create([
                'name' => $value
            ]);
        }
    }
}
