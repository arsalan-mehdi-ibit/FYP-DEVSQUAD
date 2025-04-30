<?php
namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\TimesheetDetail;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Store a new task
    public function store(Request $request, $timesheetDetailId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'actual_hours' => 'required|numeric|min:0',
        ]);

        $task = DailyTask::create([
            'timesheet_detail_id' => $timesheetDetailId,
            'title' => $request->title,
            'description' => $request->description,
            'actual_hours' => $request->actual_hours,
        ]);

        // ✅ Recalculate and persist total actual_hours in TimesheetDetail
        $totalHours = DailyTask::where('timesheet_detail_id', $timesheetDetailId)
            ->sum('actual_hours');

        TimesheetDetail::where('id', $timesheetDetailId)
            ->update(['actual_hours' => $totalHours]);

        $timesheetDetail = TimesheetDetail::findOrFail($timesheetDetailId);
        $timesheet = Timesheet::find($timesheetDetail->timesheet_id);
        $timesheet->total_hours = $timesheet->total_actual_hours;
        $timesheet->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'data' => $task,
            'total_hours' => $totalHours, // Optional: return this to update frontend
        ]);
    }


    // Update an existing task
    public function update(Request $request, $timesheetDetailId, $taskId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'actual_hours' => 'required|numeric|min:0',
        ]);

        $task = DailyTask::where('id', $taskId)
            ->where('timesheet_detail_id', $timesheetDetailId)
            ->firstOrFail();

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'actual_hours' => $request->actual_hours,
        ]);

        // ✅ Recalculate and persist total actual_hours in TimesheetDetail
        $totalHours = DailyTask::where('timesheet_detail_id', $timesheetDetailId)
            ->sum('actual_hours');

        TimesheetDetail::where('id', $timesheetDetailId)
            ->update(['actual_hours' => $totalHours]);

            $timesheetDetail = TimesheetDetail::findOrFail($timesheetDetailId);
            $timesheet = Timesheet::find($timesheetDetail->timesheet_id);
            $timesheet->total_hours = $timesheet->total_actual_hours;
            $timesheet->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'data' => $task,
            'total_hours' => $totalHours, // Optional: return this to update frontend
        ]);
    }


    public function destroy($timesheetDetailId, $taskId)
    {
        $task = DailyTask::where('id', $taskId)
            ->where('timesheet_detail_id', $timesheetDetailId)
            ->first();

        if ($task) {
            $task->delete();

            // Recalculate actual_hours for the timesheet detail
            $totalHours = DailyTask::where('timesheet_detail_id', $timesheetDetailId)
                ->sum('actual_hours');

            // Update the timesheet_details table with new total hours
            TimesheetDetail::where('id', $timesheetDetailId)
                ->update(['actual_hours' => $totalHours]);

                $timesheetDetail = TimesheetDetail::findOrFail($timesheetDetailId);
                $timesheet = Timesheet::find($timesheetDetail->timesheet_id);
                $timesheet->total_hours = $timesheet->total_actual_hours;
                $timesheet->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted successfully',
                'total_hours' => $totalHours, // Optional, use on frontend if needed
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Task not found',
        ], 404);
    }



    // Fetch tasks for a timesheet detail
    public function getTasks($timesheetDetailId)
    {
        $tasks = DailyTask::where('timesheet_detail_id', $timesheetDetailId)->get();
        return response()->json([
            'status' => 'success',
            'data' => $tasks,
        ]);
    }

    // public function getTotalHours($timesheetId)
    // {
    //     $totalHours = TimesheetDetail::where('timesheet_id', $timesheetId)
    //         ->with('tasks')
    //         ->get()
    //         ->flatMap->tasks
    //         ->sum('actual_hours');

    //     return response()->json([
    //         'status' => 'success',
    //         'total_hours' => $totalHours
    //     ]);
    // }


}
