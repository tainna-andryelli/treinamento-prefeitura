<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachedFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'protocol_number',
        'filename',
        'filepath',
        'mime_type',
    ];

    public function protocols()
    {
        return $this->belongsTo(Protocols::class, 'protocol_number', 'number');
    }
}
