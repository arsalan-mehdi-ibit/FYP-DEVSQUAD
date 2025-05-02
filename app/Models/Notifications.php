<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    
    protected $table = 'notifications';

    // Mass assignable fields
    protected $fillable = [
        'title',
        'parent_id',
        'created_for',
        'user_id',
        'message',
        'is_read',
    ];
    

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


}