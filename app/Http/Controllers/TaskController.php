<?php
namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\TimesheetDetail;
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

        // Create the task
        $task = DailyTask::create([
            'timesheet_detail_id' => $timesheetDetailId,
            'title' => $request->title,
            'description' => $request->description,
            'actual_hours' => $request->actual_hours,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'data' => $task,
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

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'data' => $task,
        ]);
    }
    public function destroy($timesheetDetailId, $taskId)
    {
        $task = DailyTask::where('id', $taskId)->where('timesheet_detail_id', $timesheetDetailId)->first();

        if ($task) {
            $task->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted successfully',
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

}
