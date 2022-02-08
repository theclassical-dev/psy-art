<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank','accType','accName','accNumber','user_id'
    ];

    public function user(){
        return $this->hasOne(AccDetail::class, 'user_id', 'user_id');
    }
}
