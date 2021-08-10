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
        <h2>Add Quiz</h2>
        <br /><br />
        <form method="POST" action="{{ route('add-quiz-post') }}">
            {{csrf_field()}}
            <div class="row mb-15">
                <div class="col-md-12">
                    <label>Title</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="title" class="textfield" required/><br />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Description</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="content" class="textfield" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br /><input type="submit" name="submit" class="button" value="Submit" />
                </div>
            </div>
        </form>
    </div>
@endsection