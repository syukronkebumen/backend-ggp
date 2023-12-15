<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAdjustmentCategory extends Model
{
    use HasFactory;
    protected $table = 'master_adjusment_category';
    protected $fillable = [
        'name'
    ];
}
