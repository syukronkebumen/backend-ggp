<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSloc extends Model
{
    use HasFactory;
    protected $table = 'master_storage_location';
    protected $fillable = [
        's_loc',
        'description',
        'plant',
        'inbound',
        'outbound',
        'batch',
        'departement_id'
    ];
}
