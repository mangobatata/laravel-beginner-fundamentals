<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class Task
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public ?string $long_description,
        public bool $completed,
        public string $created_at,
        public string $updated_at
    ) {}
}

$tasks = [
    new Task(
        1,
        'Buy groceries',
        'Task 1 description',
        'Task 1 long description',
        false,
        '2023-03-01 12:00:00',
        '2023-03-01 12:00:00'
    ),
    new Task(
        2,
        'Sell old stuff',
        'Task 2 description',
        "Task 2 long description",
        false,
        '2023-03-02 12:00:00',
        '2023-03-02 12:00:00'
    ),
    new Task(
        3,
        'Learn programming',
        'Task 3 description',
        'Task 3 long description',
        true,
        '2023-03-03 12:00:00',
        '2023-03-03 12:00:00'
    ),
    new Task(
        4,
        'Take dogs for a walk',
        'Task 4 description',
        null,
        false,
        '2023-03-04 12:00:00',
        '2023-03-04 12:00:00'
    ),
];

Route::get('/', function () use ($tasks): View {
    return view('index', [
        'tasks' => $tasks,
    ]);
})->name('tasks.index');

Route::get('/task/{taskId}', function ($taskId) use ($tasks): View {
    $task = collect($tasks)->firstWhere('id', $taskId);

    if (!$task) {
        abort(Response::HTTP_NOT_FOUND);
    }

    return view('show', [
        'task' => $task,
    ]);
})->name('tasks.show');


// Route::get('/hello', function () {
//     return 'Hello, World!';
// });

// Route::get('/hello/{name}', function ($name) {
//     return "Hello, {$name}!";
// });

// Route::redirect('/hallo', '/hello');

// Route::get('/total', function () {
//     return redirect('/hello');
// });

// Route::fallback(function () {
//     return '404 Not Found';
// });
