<?php

namespace App\Models;

use App\Models\AnalysisOrder;
use App\Models\ProjectPointMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'analysis_order_id',
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sampdate' => 'date',
    ];

    /**
     * The Project Point Matrix.
    */
    public function projectPointMatrix()
    {
        return $this->belongsTo(ProjectPointMatrix::class);
    }

    /**
     * The AnalysisOrder
    */
    public function analysisOrder()
    {
        return $this->belongsTo(AnalysisOrder::class);
    }

}
