<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

// class Task
// {
//     public function __construct(
//         public int $id,
//         public string $title,
//         public string $description,
//         public ?string $long_description,
//         public bool $completed,
//         public string $created_at,
//         public string $updated_at
//     ) {}
// }

// $tasks = [
//     new Task(
//         1,
//         'Buy groceries',
//         'Task 1 description',
//         'Task 1 long description',
//         false,
//         '2023-03-01 12:00:00',
//         '2023-03-01 12:00:00'
//     ),
//     new Task(
//         2,
//         'Sell old stuff',
//         'Task 2 description',
//         "Task 2 long description",
//         false,
//         '2023-03-02 12:00:00',
//         '2023-03-02 12:00:00'
//     ),
//     new Task(
//         3,
//         'Learn programming',
//         'Task 3 description',
//         'Task 3 long description',
//         true,
//         '2023-03-03 12:00:00',
//         '2023-03-03 12:00:00'
//     ),
//     new Task(
//         4,
//         'Take dogs for a walk',
//         'Task 4 description',
//         null,
//         false,
//         '2023-03-04 12:00:00',
//         '2023-03-04 12:00:00'
//     ),
// ];

Route::get('/', function (): View {
    $tasks = Task::query()->where('completed', true)->get();

    return view('index', [
        'tasks' => $tasks,
    ]);
})->name('tasks.index');

Route::get('/task/{taskId}', function ($taskId): View {
    $task = Task::findOrFail($taskId);

    return view('show', [
        'task' => $task,
    ]);
})->name('tasks.show');

Route::view(('/tasks/create'), 'create')->name('tasks.create');
// Route::view('/tasks/created', 'created')->name('tasks.created');

Route::get('/task/{taskId}/edit', function ($taskId): View {
    $task = Task::findOrFail($taskId);

    return view('edit', [
        'task' => $task,
    ]);
})->name('tasks.edit');

Route::post('/tasks', function (TaskRequest $request) {
    $data = $request->validated();

    $task = new Task;
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->save();

    return redirect()->route('tasks.show', ['taskId' => $task->id])
        ->with('success', '¡Tarea creada exitosamente!');
})->name('tasks.store');

Route::put('/tasks/{taskId}', function (TaskRequest $request, $taskId) {
    $data = $request->validated();

    $task = Task::findOrFail($taskId);
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->save();

    return redirect()->route('tasks.show', ['taskId' => $task->id])
        ->with('success', '¡Tarea actualizada exitosamente!');
})->name('tasks.update');
