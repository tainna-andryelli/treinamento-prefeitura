<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AttachedFile extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
