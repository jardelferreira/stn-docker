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
        $group = true; // atributo para arastar várias tasks
        $autoSchedulle = true;
        $task = Task::find($id);

        $task->text = $request->text;
        // $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        $taskEndDate = date_create($request->start_date)->modify("+ {$request->duration} day");
        $displaciment = $task->start_date > $request->start_date ? "past" : "future";
        $interval = date_create($task->start_date)->diff(date_create($request->start_date))->days;

        if ($task->parentTask()->exists()) {
            $parent = $task->parentTask()->first();
            $parentEndDate = date_create($parent->start_date)->modify("+ {$parent->duration} day");
            if ($parentEndDate < $taskEndDate) {
                if (!$autoSchedulle) {
                    if (date_create($request->start_date)->diff($parentEndDate)->days < 1) {
                        // se a task ficar futuramente fora do parent reduz a duração para o mínimo 
                        $task->duration = 1;
                        $limitFinalDate = $parentEndDate->modify("- 1 day");
                    } else {
                        // data final da task maior que final parent task, reduz a duração para terminar igual
                        $task->duration = $request->duration - $parentEndDate->diff($taskEndDate)->days;
                    }
                } else {
                    $schedule = $parentEndDate->diff($taskEndDate)->days;
                    $task->duration = $request->duration;

                    $this->updateParentDuration($parent, $schedule);
                }
            } else {
                $task->duration = $request->duration;
            } // fim da modificação da duração e/ou data final

            if ($parent->start_date < $request->start_date) {

                $task->start_date = $limitFinalDate ?? $request->start_date;
                $task->save();
                $this->updateSubtasksDates($task, $group, $interval, $displaciment);
            } else {
                if (!$autoSchedulle) {

                    $task->start_date = $parent->start_date;
                    $task->save();
                    $this->updateSubtasksDates($task, $group, $interval, $displaciment);
                } else {
                    $task->start_date = $request->start_date;
                    $task->save();
                    $this->updateParentDates($task);
                    $this->updateSubtasksDates($task, $group, $interval, $displaciment);
                }
            }
        } else {
            $task->start_date = $request->start_date;
            $task->duration = $request->duration;
            $task->save();
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

    public function updateSubtasksDates(Task $task, $group, $interval, $displaciment)
    {
        $subtasks = $task->subTasks();
        if ($subtasks->exists() & $group) {
            foreach ($subtasks->get() as  $subtask) {
                if ($displaciment == "past") {
                    $subtask->start_date = date_create($subtask->start_date)->modify("- {$interval} day");
                } else {
                    $subtask->start_date = date_create($subtask->start_date)->modify("+ {$interval} day");
                }
                $subtask->save();
                $this->updateSubtasksDates($subtask, $group, $interval, $displaciment);
            }
        }
    }

    public function updateParentDates(Task $task)
    {
        if ($task->parentTask()->exists()) {
            $parent = $task->parentTask()->first();
            $taskDate = $task->start_date;
            $parentDate = $parent->start_date;
            if ($parent->start_date > $task->start_date) {
                $parent->start_date = $task->start_date;
                $parent->duration+= date_create($taskDate)->diff(date_create($parentDate))->days; 
                $parent->save();
                $this->updateParentDates($parent);
            }
        }
    }

    public function updateParentDuration(Task $task, int $schedule)
    {
        $task->duration += $schedule;
        $task->save();
        if ($task->parentTask()->exists()) {
            $parent = $task->parentTask()->first();
            $parentEndDate = date_create($parent->start_date)->modify("+ {$parent->duration} day");
            $taskEndDate = date_create($task->start_date)->modify("+ {$task->duration} day");
            if ($parentEndDate < $taskEndDate) {
                $schedule = $parentEndDate->diff($taskEndDate)->days;
                $this->updateParentDuration($parent, $schedule);
            }
        }
    }
}
