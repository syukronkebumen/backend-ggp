<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCostCenter extends Model
{
    use HasFactory;
    protected $table = 'master_cost_center';
    protected $fillable = [
        'cost_center',
        'description',
        'departement'
    ];
}
