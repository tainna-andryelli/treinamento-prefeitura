<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Protocols extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $primaryKey = 'number';

    protected $fillable = [
        'description',
        'created_date',
        'deadline_days',
        'contributor_id',
        'department_id',
        'status',
    ];

    public function contributor()
    {
        return $this->belongsTo(People::class, 'contributor_id');
    }

    public function attachedFiles()
    {
        return $this->hasMany(AttachedFile::class,'protocol_number', 'number');
    }

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function accompaniments()
    {
        return $this->hasMany(Accompaniment::class, 'protocol_number', 'number');
    }


}
