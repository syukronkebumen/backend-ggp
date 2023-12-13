<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMovementType extends Model
{
    use HasFactory;
    protected $table = 'master_movement_type';
    protected $fillable = [
        'mvt_code',
        'description'
    ];
    
}
