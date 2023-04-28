<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {

        $task = new Task();

        $task->text = $request->text;
        $task->start_date = $request->start_date;
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        $task->sortorder = Task::max("sortorder") + 1;

        $task->save();

        return response()->json([
            "action" => "inserted",
            "tid" => $task->id
        ]);
    }

    public function update($id, Request $request)
    {
        $task = Task::find($id);

        $task->text = $request->text;
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        
        $group = true;

        if ($parent = $task->parentTask()->first()) {
            if ($parent->start_date < $request->start_date) {

                $newDate = $request->start_date;

                $interval = date_create($task->start_date)->diff(date_create($request->start_date))->days;
                $task->start_date = $request->start_date;
                $task->save();
                if ($subtasks = $task->subTasks() & $group) {
                    
                }              
            }

        }

        if ($request->has("target")) {
            $this->updateOrder($id, $request->target);
        }

        return response()->json([
            "action" => "updated"
        ]);
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return response()->json([
            "action" => "deleted"
        ]);
    }

    private function updateOrder($taskId, $target)
    {
        $nextTask = false;
        $targetId = $target;

        if (strpos($target, "next:") === 0) {
            $targetId = substr($target, strlen("next:"));
            $nextTask = true;
        }

        if ($targetId == "null")
            return;

        $targetOrder = Task::find($targetId)->sortorder;
        if ($nextTask)
            $targetOrder++;

        Task::where("sortorder", ">=", $targetOrder)->increment("sortorder");

        $updatedTask = Task::find($taskId);
        $updatedTask->sortorder = $targetOrder;
        $updatedTask->save();
    }

    public function updateSubtasksDates(Task $task, $group = true)
    {
        $subtasks = $task->subTasks();
        foreach ($subtasks as $ $subtask) {
            
        }
        
            
    }

    public function updateDurations(Task $task)
    {
        if($parent = $task->parentTask()->first()){
            
            $parentEndDate = date_create($parent->start_date)->modify("+ {$parent->duration} day");
            $taskEndDate = date_create($task->start_date)->modify("+ {$task->duration} day");
            
            if ($taskEndDate > $parentEndDate) {
                $interval = $parentEndDate->diff($taskEndDate)->days;
                $parent->duration = $parent->duration + $interval;
                $parent->save();
                $this->updateDurations($parent);
            }
        }

    }
}
