@extends('layout/app')

@section('content')
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('quizzes') }}">Quizzes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('results') }}">Results</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Quizzes</h2>
            </div>
            <div class="col-md-6 align-right">
                <a href="/admin/add-quiz"><input type="button" class="button" value="Add Quiz" /></a>
            </div>
        </div>
        <br /><br />
        <table class="table">
            <tr>
                <th width="30%">Title</th>
                <th width="50%">Description</th>
                <th width="20%">Actions</th>
            </tr>

            <tr>
                <th width="30%"><a href="{{ route('questions') }}/1">Geography Test Sample</a></th>
                <th width="50%">Sample Description</th>
                <th width="20%"><a>Delete</a> | </a>Update</a></th>
            </tr>

        </table>
    </div>
@endsection