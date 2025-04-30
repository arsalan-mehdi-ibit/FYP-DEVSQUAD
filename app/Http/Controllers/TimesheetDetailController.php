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
        // if ($request->has('id')) {
        //     return redirect()->route('timesheet.details.detail', ['id' => $request->id]);
        // }


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

    // public function getTotalActualHours($timesheetDetailId)
    // {
    //     $timesheetDetail = TimesheetDetail::find($timesheetDetailId);

    //     if ($timesheetDetail) {
    //         // Fetch the total actual hours by summing up related tasks
    //         $totalHours = $timesheetDetail->tasks()->sum('actual_hours');
    //         return response()->json(['status' => 'success', 'total_hours' => $totalHours]);
    //     }
    //     return response()->json(['status' => 'error', 'message' => 'Timesheetdetail not found']);
    // }


    //     public function storeDailyTask(Request $request)
// {
//     $validated = $request->validate([
//         'timesheet_detail_id' => 'required|exists:timesheet_details,id',
//         'title' => 'required|string',
//         'description' => 'nullable|string',
//         'actual_hours' => 'required|numeric',
//     ]);

    //     $task = DailyTask::create($validated);

    //     return response()->json(['status' => 'success', 'data' => $task]);
// }

    // public function updateDailyTask(Request $request, $id)
// {
//     $task = DailyTask::findOrFail($id);

    //     $validated = $request->validate([
//         'title' => 'required|string',
//         'description' => 'nullable|string',
//         'actual_hours' => 'required|numeric',
//     ]);

    //     $task->update($validated);

    //     return response()->json(['status' => 'success', 'data' => $task]);
// }


}
