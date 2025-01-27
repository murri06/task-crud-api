<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Index
     *
     * Display a listing of the tasks for logged-in user.
     * You can use status as filter and set different sorting
     *
     * @authenticated
     * @group Task
     */
    public function index(Request $request)
    {
        $query = Task::query()->where('user_id', auth()->id());

        $request->validate([
            'status' => 'nullable|string|in:complete,pending',
            'search' => 'nullable|string',
            'sort' => 'nullable|string|in:id,created_at,updated_at,status',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ]);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search by title or description
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // Sort by created date
        $sort = $request->input('sort', 'desc');
        $query->orderBy('created_at', $sort);

        // Paginate results
        $perPage = $request->input('per_page', 10);
        $tasks = $query->paginate($perPage);

        return response()->json($tasks);
    }

    /**
     * Creation
     *
     * Store a newly created task in storage.
     * You can specify its status or leave it blank for default one.
     *
     * @authenticated
     * @group Task
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $task = auth()->user()->tasks()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'] ?? 'pending'
        ]);
        return response()->json($task, 201);
    }


    /**
     * Single Receive
     *
     * You can receive a specific task
     *
     * @authenticated
     * @group Task
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return json_encode($task);
    }

    /**
     * Update
     *
     * Update the specified task in storage.
     * You can update task status, name or description.
     *
     * @authenticated
     * @group Task
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validated();

        $task->update($validated);
        return response()->json($task);
    }

    /**
     * Deletion
     *
     * Remove the specified task from storage.
     *
     * @authenticated
     * @group Task
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->json(null, 204);
    }
}
