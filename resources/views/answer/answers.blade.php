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
            <div class="col-md-12">
                <h2>Results</h2>
            </div>
        </div>
        <br /><br />
        <table class="table">
            <tr>
                <th width="40%">Email</th>
                <th width="40">Quiz</th>
                <th width="20%">Score</th>
            </tr>
            @foreach($answers as $answer)
            <tr>
                <td width="40%">{{$answer->email}}</td>
                <td width="40%">{{$answer->quiz_title}}</td>
                <td width="20%">{{$answer->score}}</td>
            </tr>
            @endforeach


        </table>
    </div>
@endsection