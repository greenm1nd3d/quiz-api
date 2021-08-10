<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use Validator;

use App\Models\Answer;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {
        return view('dashboard');
    }

    public function quizzes() {
        $quizzes = Quiz::all();

        return view('quiz.quizzes', compact('quizzes'));
    }

    public function addQuiz() {
        return view('quiz.add-quiz');
    }

    public function addQuizPost(Request $request) {
        $quiz = new Quiz;
        $input = $request->all();
        $quiz->fill($input)->save();
        return redirect()->intended('admin/quizzes')->withSuccess('Added a quiz');
    }

    public function deleteQuiz($id) {
        try {
            $quiz = Quiz::findOrFail($id);
            $quiz->delete();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

        return redirect()->intended('admin/quizzes')->withSuccess("Deleted quiz {$id}");
    }

    public function updateQuiz($id) {
        $quiz = Quiz::findOrFail($id);
        return view('quiz.update-quiz', compact('quiz'));
    }

    public function updateQuizPost(Request $request, $id) {
        $quiz = Quiz::findOrFail($id);
        $input = $request->all();
        $quiz->update($input);
    
        return redirect()->intended('admin/quizzes')->withSuccess('Updated a quiz');
    }

    public function questions($id) {
        $questions = Question::where('quiz_id', '=', $id)->get();
        return view('question.questions', compact('questions', 'id'));
    }

    public function addQuestion($id) {
        return view('question.add-question', compact('id'));
    }

    public function addQuestionPost(Request $request) {
        $quizId = $request->quiz_id;
        $question = new Question;
        $input = $request->all();
        $question->fill($input)->save();

        return redirect()->route('questions', $quizId)->withSuccess('Added a question');
    }

    public function deleteQuestion($quizId, $id) {
        try {
            $question = Question::findOrFail($id);
            $question->delete();
        } catch (Exception  $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
        return redirect()->route('questions', $quizId)->withSuccess('Question successfully deleted');
    }

    public function updateQuestion($id) {
        $question = Question::findOrFail($id);

        return view('question.update-question', compact('question'));
    }

    public function updateQuestionPost(Request $request) {
        $quizId = $request->quiz_id;
        $question = Question::findOrFail($request->id);
        $input = $request->all();
        $question->update($input);

        return redirect()->route('questions', $quizId)->withSuccess('Question successfully added');
    }

    public function choice($id) {
        $question = Question::findOrFail($id);
        $choice = Choice::where('question_id', '=', $id)->get()->first();

        return view('choice.choice', compact('choice', 'question'));
    }

    public function choicePost(Request $request) {
        $quizId = $request->quiz_id;
        $question_id = $request->question_id;
        $choice = new Choice;

        if ($request->id) {
            $choice = Choice::findOrFail($request->id);
        }
        $input = $request->all();

        $choice->fill($input)->save();

        return redirect()->route('questions', $quizId)->withSuccess('Added a question');
    }

    public function results() {
        /*$answers = DB::table('answers')
                 ->select('email', 'quiz_id', 'title as quiz_title')
                 ->join('quizzes', 'quizzes.id', '=', 'answers.quiz_id')
                 ->groupBy('email', 'quiz_id')
                 ->get();*/


        $sql = "SELECT email, quiz_id, title AS quiz_title, (
            SELECT COUNT(*) FROM `answers` a
  	        WHERE answer = (
    	        SELECT answer FROM choices c
    	        WHERE question_id = a.question_id
                AND email = x.email
                AND quiz_id = x.quiz_id
  	        )) AS score
            FROM answers x
            INNER JOIN quizzes q ON x.quiz_id = q.id
            GROUP BY email, quiz_id";

        $answers = DB::select($sql);

        return view('answer.answers', compact('answers'));
    }
}