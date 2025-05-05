<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',       // Updated from 'name' to 'project_name'
        'type',
        'client_id',             // You may want to map this to client_id if that's your intention
        'consultant_id',
        'client_rate',
        'status',
        'start_date',
        'end_date',
        'referral_source',
        'notes',
        'created_at',
        'updated_at',
    ];

    public function fileAttachments()
    {
        return $this->hasMany(\App\Models\FileAttachment::class, 'parent_id');
    }

    /**
     * Get the client associated with the project.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    /**
     * Get the consutant associated with the project.
     */
    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    /**
     * Get the contractors associated with the project.
     */
    public function contractors()
    {
        return $this->belongsToMany(User::class, 'project_contractor', 'project_id', 'contractor_id')
            ->withPivot('contractor_rate');
    }

}
