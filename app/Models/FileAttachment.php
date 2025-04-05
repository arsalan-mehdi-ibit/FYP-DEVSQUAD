<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_size',
        'file_for',
        'parent_id',
        'file_type',
        'file_path',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'parent_id');  // 'parent_id' as foreign key
    }
}
