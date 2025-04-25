<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'timesheet_detail_id',
        'title',
        'description',
        'actual_hours',
    ];
    public function timesheetDetail()
    {
        return $this->belongsTo(TimesheetDetail::class);
    }
}

