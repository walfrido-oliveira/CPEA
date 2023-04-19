<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuplicateSize extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_id', 'field_type_id', 'size'
    ];

    /**
     * The Form
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * The Field Type
     */
    public function fieldType()
    {
        return $this->belongsTo(FieldType::class);
    }
}
