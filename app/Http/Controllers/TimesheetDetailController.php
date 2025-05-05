<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use Carbon\Carbon;
use App\Models\TimesheetDetail;
use App\Models\DailyTask;


class TimesheetDetailController extends Controller
{
    // Show all timesheets
    public function index(Request $request)
    {
        $pageTitle = 'Timesheet Details';
        $timesheetDetailss = TimesheetDetail::all();
        return view('timesheetdetail', compact('pageTitle', $timesheetDetailss));
    }

    // Show details of a specific timesheet
    public function show($id)
    {
        \Log::info('TimesheetDetailController show() hit with ID: ' . $id);

        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            \Log::error("No Timesheet found for ID: $id");
            abort(404, 'Timesheet not found');
        }

        $pageTitle = 'Timesheet Details'; // Add this line

        $timesheetDetails = TimesheetDetail::where('timesheet_id', $id)
            // ->whereBetween('date', [$timesheet->start_date, $timesheet->end_date])
            ->orderBy('date')
            ->get();

        return view('timesheetdetail', compact('timesheet', 'timesheetDetails', 'pageTitle'));
    }

    public function updateMemo(Request $request, $id)
    {
        $request->validate([
            'memo' => 'nullable|string',
        ]);

        $detail = TimesheetDetail::findOrFail($id);
        $detail->memo = $request->input('memo');
        $detail->save();

        return response()->json(['success' => true]);
    }


}
