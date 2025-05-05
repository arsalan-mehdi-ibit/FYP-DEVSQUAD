<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContractor extends Model
{
    use HasFactory;

    protected $table = 'project_contractor'; 

    protected $fillable = [
        'project_id',
        'contractor_id',
        'contractor_rate',
        'created_at',
        'updated_at',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }
   
}


