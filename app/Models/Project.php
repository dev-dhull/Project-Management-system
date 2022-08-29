<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'project_name',
        'project_desc',
        'payment_type',
        'total_amount',
        'monthly_amount',
        'invoice_from',
        'invoice_to' 
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
