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
        <h2>Choices</h2>
        <h5>{{$question->question}}</h5>
        <br /><br />
        <form method="POST" action="{{ route('choice-post') }}">
            {{csrf_field()}}
            <input type="hidden" name="question_id" value="{{$question->id}}">
            <input type="hidden" name="quiz_id" value="{{$question->quiz_id}}">

            @if($choice)
            <input type="hidden" name="id" value="{{$choice->id}}">

            <div class="row mb-15">
                <div class="col-md-12">
                    <label>Choice 1</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="choice1" class="textfield" value="{{$choice->choice1}}" required/><br />
                </div>
            </div>
            <div class="row mb-15">
                <div class="col-md-12">
                    <label>Choice 2</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="choice2" class="textfield" value="{{$choice->choice2}}" required/><br />
                </div>
            </div>
            <div class="row mb-15">
                <div class="col-md-12">
                    <label>Choice 3</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="choice3" class="textfield" value="{{$choice->choice3}}" required/><br />
                </div>
            </div>
            <div class="row mb-15">
                <div class="col-md-12">
                    <label>Answer</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="answer" class="textfield" value="{{$choice->answer}}" required/><br />
                </div>
            </div>

            @else

            <div class="row mb-15">
                <div class="col-md-12">
                    <label>Choice 1</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="choice1" class="textfield" value="" required/><br />
                </div>
            </div>
            <div class="row mb-15">
                <div class="col-md-12">
                    <label>Choice 2</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="choice2" class="textfield" required/><br />
                </div>
            </div>
            <div class="row mb-15">
                <div class="col-md-12">
                    <label>Choice 3</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="choice3" class="textfield" required/><br />
                </div>
            </div>
            <div class="row mb-15">
                <div class="col-md-12">
                    <label>Answer</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="answer" class="textfield" required/><br />
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <br /><input type="submit" name="submit" class="button" value="Submit" />
                </div>
            </div>
        </form>
    </div>
@endsection