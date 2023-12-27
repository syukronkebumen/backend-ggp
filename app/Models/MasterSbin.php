<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSbin extends Model
{
    use HasFactory;
    protected $table = 'master_storage_bin';
    protected $fillable = [
        's_bin',
        's_loc',
        's_loc_description',
        'plant',
        'departement_id'
    ];
}
