<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'client_id',
        'start_date',
        'end_date',
        'status',
        'client_rate',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the client associated with the project.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the contractors associated with the project.
     */
    public function contractors()
    {
        return $this->belongsToMany(User::class, 'project_contractor', 'project_id', 'contractor_id')
                    ->withPivot('contractor_rate')
                    ->withTimestamps();
    }
}
