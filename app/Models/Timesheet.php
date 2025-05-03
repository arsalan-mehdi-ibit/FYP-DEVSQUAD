<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\User;
use App\Models\TimesheetDetail;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'contractor_id',
        'week_start_date',
        'week_end_date',
        'status',
        'total_hours',
        'total_amount',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id'); // or the correct FK
    }

    public function details()
{
    return $this->hasMany(TimesheetDetail::class);
}

public function getTotalActualHoursAttribute()
{
    return $this->details()->sum('actual_hours');
}

}

