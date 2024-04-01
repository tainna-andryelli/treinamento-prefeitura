<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $table = 'people';
    protected $fillable = [
        'name',
        'date_birth',
        'cpf',
        'sex',
        'city',
        'neighborhood',
        'street',
        'number',
        'complement',
    ];
}
