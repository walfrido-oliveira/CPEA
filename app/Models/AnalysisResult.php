<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_point_matrix_id',
        'client',
        'project',
        'projectnum',
        'labname',
        'samplename',
        'labsampid',
        'matrix',
        'rptmatrix',
        'solidmatrix',
        'sampdate',
        'prepdate',
        'anadate',
        'batch',
        'analysis',
        'anacode',
        'methodcode',
        'methodname',
        'description',
        'prepname',
        'analyte',
        'analyteorder',
        'casnumber',
        'surrogate',
        'tic',
        'result',
        'dl',
        'rl',
        'units',
        'rptomdl',
        'mrlsolids',
        'basis',
        'dilution',
        'spikelevel',
        'recovery',
        'uppercl',
        'lowercl',
        'analyst',
        'psolids',
        'lnote',
        'anote',
        'latitude',
        'longitude',
        'scomment',
        'snote1',
        'snote2',
        'snote3',
        'snote4',
        'snote5',
        'snote6',
        'snote7',
        'snote8',
        'snote9',
        'snote10',
    ];

}
