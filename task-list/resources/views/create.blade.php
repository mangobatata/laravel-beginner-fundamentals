@extends("layouts.app")

@section("title", "Add New Task")

@section("content")
    <div class="container">
        <h1 class="mb-4">Add New Task</h1>
        <form action="{{ route('tasks.store') }}" method="POST">
            <!-- @csrf en Laravel sirve para proteger tu formulario contra ataques CSRF (Cross-Site Request Forgery). -->
            @csrf 
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Task</button>
        </form>
    </div>
@endsection