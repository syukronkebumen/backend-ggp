<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $table = 'reference';
    protected $fillable = [
        'name',
        'sloc_id',
        'good_recipient_id',
        'material_id'
    ];
}
