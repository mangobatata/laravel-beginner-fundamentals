{{-- Permite saber si la variable está definida --}}
{{--@isset($name)
<div>The name is: {{ $name }}</div>


<div>The age is: {{ $age }}</div>
@endisset--}}

<style>
    .tasks-container {
        max-width: 600px;
        margin: 40px auto;
        font-family: Arial, sans-serif;
    }

    .tasks-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .tasks-list {
        list-style: none;
        padding: 0;
    }

    .task-item {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 12px;
        margin-bottom: 10px;
    }

    .task-title {
        font-weight: bold;
        color: #333;
    }

    .task-description {
        display: block;
        color: #666;
        margin: 5px 0;
    }

    .task-link {
        text-decoration: none;
        color: #007bff;
        font-size: 14px;
    }

    .task-link:hover {
        text-decoration: underline;
    }

    .no-tasks {
        color: #999;
        font-style: italic;
    }
</style>

<div class="tasks-container">
    <div class="tasks-title">
        The list of tasks:
    </div>

    @if(count($tasks))
        <ul class="tasks-list">
            @foreach($tasks as $task)
                <li class="task-item">
                    <span class="task-title">{{ $task->title }}</span>
                    <span class="task-description">{{ $task->description }}</span>
                    <a class="task-link" href="{{ route('tasks.show', ['taskId' => $task->id]) }}">
                        View Details
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="no-tasks">No tasks!</p>
    @endif
</div>