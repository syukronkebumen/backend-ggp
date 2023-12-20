<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{
    use HasFactory;
    protected $table = 'outbound';
    protected $fillable = [
        'code',
        'reference_doc',
        'type',
        'mvt_id',
        'receiving_sloc',
        'status'
    ];
}
