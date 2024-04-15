<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protocols extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'number';

    protected $fillable = [
        'description',
        'created_date',
        'deadline_days',
        'contributor_id'
    ];

    public function contributor()
    {
        return $this->belongsTo(People::class, 'contributor_id');
    }
}
