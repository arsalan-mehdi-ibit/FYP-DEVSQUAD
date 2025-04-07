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
        'name',       // Updated from 'name' to 'project_name'
        'type',
        'client_id',             // You may want to map this to client_id if that's your intention
        'consultant_id',
        'client_rate',
        'status',
        'start_date',
        'end_date',
        'referral_source',    // New field added
        'notes',              // New field added
        'created_at',         // These may be auto-handled by Laravel, but included for completeness
        'updated_at',         // These may be auto-handled by Laravel, but included for completeness
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
        return $this->belongsTo(User::class, 'client_id'); // Ensure you are referencing client_id here
    }

    /**
     * Get the contractors associated with the project.
     */
    public function contractors()
    {
        return $this->belongsToMany(User::class, 'project_contractor')
            ->withPivot('contractor_rate')  // Attach additional columns
            ->where('role', 'contractor');  // Ensure only contractors are returned
    }


    // Optionally, if you want to have custom attribute names (for example, if you want `client_name` instead of `client`)
    public function getClientNameAttribute()
    {
        return $this->client->name; // If the User model has a 'name' attribute
    }

    // You can also define custom methods for other relationships if necessary
}
