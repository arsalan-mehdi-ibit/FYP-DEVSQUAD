<?php  

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'timesheet_id',
        'client_id',
        'contractor_id',
        'admin_received',
        'contractor_paid',
        'payment_date',
        'created_at',
        'updated_at',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function timesheet()
    {
        return $this->belongsTo(Timesheet::class, 'timesheet_id');
    }
}
