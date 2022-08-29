<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'amount_paid'
    ];

    public function project(){
        return $this->hasMany(Project::class,'id','project_id');
    }
}
