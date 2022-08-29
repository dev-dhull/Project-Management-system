<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'project_name',
        'project_desc',
        'payment_type',
        'total_amount',
        'monthly_amount',
        'invoice_from',
        'invoice_to' 
    ];

    public function client(){
        return $this->hasMany(User::class,'id','client_id');
    }
    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
}
