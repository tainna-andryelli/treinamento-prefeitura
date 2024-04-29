<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accompaniment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'description',
        'status',
        'protocol_number',
    ];

    public function protocol()
    {
        return $this->belongsTo(Protocols::class, 'protocol_number');
    }
}
