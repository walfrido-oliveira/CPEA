<?php

namespace App\Models;

use App\Models\AnalysisResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnalysisResultFile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'analysis_order_id',
        'file',
        'name'
    ];

    /**
     * The AnalysisOrder
    */
    public function analysisOrder()
    {
        return $this->belongsTo(AnalysisOrder::class);
    }
}
