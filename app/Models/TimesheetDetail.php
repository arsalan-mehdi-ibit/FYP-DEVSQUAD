<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimesheetDetail extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'timesheet_id',
        'actual_hours',
        'ot_hours',
        'date',
        // 'type',
        // 'billable',
        'memo'
    ];

    // Define the relationship with the Timesheet
    public function timesheet()
    {
        return $this->belongsTo(Timesheet::class);
    }
    public function dailyTasks()
    {
        return $this->hasMany(DailyTask::class);
    }
    

}
