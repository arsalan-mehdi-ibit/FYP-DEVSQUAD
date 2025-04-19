<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'email',
        'email_verified_at',
        'password',
        'role',
        'source',
        'phone',
        'address',
        'is_active',
        'send_emails',
        'remember_token',
    ];

    public function fileAttachments()
    {
        return $this->hasMany(\App\Models\FileAttachment::class, 'parent_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_contractor', 'contractor_id', 'project_id')
            ->withPivot('contractor_rate');
    }

// public function clientProjects()
// {
//     return $this->hasMany(Project::class, 'client_id');
// }
public function isLinkedToAnyProject(): bool
{
    $isContractor = $this->projects()->exists();
    $isClient = \App\Models\Project::where('client_id', $this->id)->exists();
    $isConsultant = \App\Models\Project::where('consultant_id', $this->id)->exists();

    return $isContractor || $isClient || $isConsultant;
}




    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
