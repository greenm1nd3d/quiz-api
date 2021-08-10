<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

use App\Models\Quiz;
use App\Models\Answer;


class QuizController extends Controller
{
    public function index() {
        return "Nothing to see here";
    }

    public function create(Request $request)
    {
        Log::debug("Attempting to create quiz...");

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $data = [
            'title' => $request->title,
            'content' => $request->content
        ];

        $quiz = Quiz::create($data);
        if ($quiz) {
            return response()->json([
                'message' => 'Quiz successfully created'
            ], 200);
        }

        return response()->json([
            'error' => 'Bad Request',
            'status' => 400
        ]);
    }

    public function delete(Request $request)
    {
        Log::debug("Attempting to delete quiz...");

        try {
            $quiz = Quiz::findOrFail($request->id);
            $quiz->delete();

            return response()->json([
                'message' => 'Quiz successfully deleted.',
                'status' => 200
            ]);
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Could not find specified quiz.',
                'status' => 404
            ]);
        }
    }

    public function list()
    {
        return Quiz::all();
    }

    public function update(Request $request)
    {
        Log::debug("Attempting to update quiz...");

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:12'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        try {
            $quiz = Quiz::findOrFail($request->id);

            $quiz->title = $request->title;

            if ($request->has('content')) {
                $quiz->content = $request->content;
            }

            $quiz->save();

            return response()->json([
                'message' => 'Quiz successfully updated.',
                'status' => 200
            ]);
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
               'message' => 'Could not find specified quiz.',
               'status' => 404
            ]);
        }
    }

    public function submit(Request $request)
    {
        Log::debug("Attempting to submit user's answers...");

        $validator = Validator::make($request->all(), [
            'quiz_id' => 'required|exists:quizzes,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $check = Answer::where([
            ['email', '=', $request->email],
            ['quiz_id', '=', $request->quiz_id]
        ])->first();
        if ($check) {
            return response()->json([
                'error' => 'You cannot take this test more than once'
            ], 401);
        }

        try {
            $data = [];
            foreach ($request->content as $answer) {
                $data[] = [
                    'email' => $request->email,
                    'quiz_id' => $request->quiz_id,
                    'question_id' => $answer['question_id'],
                    'answer' => $answer['answer']
                ];
            }

            $answer = Answer::upsert($data, ['email', 'quiz_id', 'question_id', 'answer']);

            return response()->json([
                'data' => $answer,
                'message' => 'User answers successfully submitted.',
                'status' => 200
            ]);
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
               'message' => 'Could not find specified quiz.',
               'status' => 404
            ]);
        }
    }
}