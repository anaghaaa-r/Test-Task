<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Notifications\SendMailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // task list
    public function list(Request $request)
    {
        $tasks = Task::with('assignedTo', 'category')->latest()->get();


        return view('task.task-list', [
            'tasks' => $tasks
        ]);
    }

    // accepted tasks
    public function userTasks()
    {
        $tasks = Task::where('assigned_to', Auth::id())->latest()->get();


        return view('task.task-users', [
            'tasks' => $tasks
        ]);
    }

    // create
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'assigned_to' => 'required|array',
            'assigned_to.*' => 'exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'deadline' => 'required|date',
            'uploaded_file' => 'nullable|mimes:png,jpg,jpeg'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        dd($request->assigned_to);

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->assigned_to = json_encode($request->assigned_to);
        $task->category_id = $request->category_id;
        $task->deadline = Carbon::parse($request->deadline);

        if ($request->hasFile('uploaded_file')) {
            $filename = $request->file('uploaded_file')->hashName();
            $filePath = 'uploads/task/' . $filename;
            $request->file('uploaded_file')->storeAs('public/' . $filePath);
            $task->file = $filePath;
        }
        $task->save();

        $assignedUsers = User::whereIn('id', $request->assigned_to)->get();
        foreach ($assignedUsers as $user) {
            Notification::route('mail', $user->email)
                ->notify(new SendMailNotification($task));
        }



        return redirect()->back()->with(['message' => 'Task Created']);
    }


    // task inner page
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        return view('task.task-edit', compact('task'));
    }

    // update task
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'assigned_to' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'deadline' => 'required|date',
            'uploaded_file' => 'nullable|mimes:png,jpg,jpeg',
            'status' => 'nullable|in:0,1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $task = Task::findOrFail($id);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'category_id' => $request->category_id,
            'deadline' => Carbon::parse($request->deadline),
            'status' => $request->status
        ];

        if ($request->hasFile('uploaded_file')) {
            if ($task->file) {
                Storage::delete('public/' . $task->file);
            }
            $filename = $request->file('uploaded_file')->hashName();
            $filePath = 'uploads/task/' . $filename;
            $request->file('uploaded_file')->storeAs('public/' . $filePath);
            $data['file'] = $filePath;
        } else {
            $data['file'] = $task->file;
        }
        $task->update($data);

        return redirect()->route('task.list')->with(['message' => 'Task updated']);
    }

    // delete
    public function delete($id)
    {
        Task::findOrFail($id)->delete();

        return redirect()->back()->with(['message' => 'Task Deleted']);
    }

    // update task status
    public function status(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->status = $request->status;

        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Task status updated',
            'status' =>  $task->status,
        ], 200);
    }
}
