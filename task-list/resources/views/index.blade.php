@extends('layouts.app')

@section('title', 'Lista de Tareas')

@section('content')

    <style>
        .tasks-wrapper {
            max-width: 720px;
            margin: 3rem auto;
            padding: 0 1.5rem;
            font-family: system-ui, -apple-system, BlinkMacOSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .tasks-header {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 2rem;
            text-align: center;
        }

        .tasks-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .task-card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.25s ease;
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e1;
        }

        .task-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 0.5rem 0;
        }

        .task-title.completed {
            text-decoration: line-through;
            color: #6b7280;
            opacity: 0.85;
        }

        .task-description {
            font-size: 1rem;
            color: #4b5563;
            line-height: 1.5;
            margin: 0 0 1rem 0;
        }

        .task-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .task-status {
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-weight: 500;
        }

        .task-status.completed {
            background: #dcfce7;
            color: #166534;
        }

        .task-status.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .task-link {
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .task-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .no-tasks-message {
            text-align: center;
            padding: 4rem 1rem;
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            color: #64748b;
            font-size: 1.125rem;
            font-style: italic;
        }
    </style>

    <div class="tasks-wrapper">
        <h1 class="tasks-header">Mis Tareas</h1>

        @if ($tasks->isNotEmpty())
            <ul class="tasks-list">
                @foreach ($tasks as $task)
                    <li class="task-card">
                        <h2 class="task-title {{ $task->completed ? 'completed' : '' }}">
                            {{ $task->title }}
                        </h2>

                        <p class="task-description">
                            {{ $task->description }}
                        </p>

                        <div class="task-footer">
                            <span class="task-status {{ $task->completed ? 'completed' : 'pending' }}">
                                {{ $task->completed ? 'Completada' : 'Pendiente' }}
                            </span>

                            <a href="{{ route('tasks.show', $task->id) }}" class="task-link">
                                Ver detalles →
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="no-tasks-message">
                No hay tareas registradas aún.
            </div>
        @endif
    </div>

@endsection