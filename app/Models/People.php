<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;
    
    protected $table = 'people';
    protected $fillable = [
        'name',
        'birthday',
        'cpf',
        'sex',
        'city',
        'neighborhood',
        'street',
        'number',
        'complement',
    ];

    public function protocols()
    {
        return $this->hasMany(Protocols::class, 'contributor_id');
    }
}
