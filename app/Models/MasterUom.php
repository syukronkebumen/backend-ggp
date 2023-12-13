<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterUom extends Model
{
    use HasFactory;

    protected $table = 'master_uom';
    protected $fillable = [
        'name'
    ];
}
