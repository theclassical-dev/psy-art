<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'size', 'description','price', 'discount','artType','image','status','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
