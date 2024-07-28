<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Task</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                @if (Auth::user()->role == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.add') }}">User Add</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.list') }}">User List</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category.list') }}">Category</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('task.add') }}">Task Add</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('task.list') }}">Task List</a>
                    </li>
                @endif
                
                @if (Auth::user()->role == 0)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('task.users') }}">Task List</a>
                </li>
                @endif

            </ul>
            <form class="d-flex" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>
