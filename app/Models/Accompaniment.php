<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Accompaniment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
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
