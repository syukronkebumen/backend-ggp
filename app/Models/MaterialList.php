<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialList extends Model
{
    use HasFactory;
    protected $table = 'location_material_default';
    protected $fillable = [
        'material_code',
        'sbin_id'
    ];
}
