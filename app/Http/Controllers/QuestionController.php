<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

use App\Models\Question;
use App\Models\Choice;


class QuestionController extends Controller
{
    public function index() {
        return "Nothing to see here";
    }

    public function create(Request $request)
    {
        Log::debug("Attempting to create question...");

        $validator = Validator::make($request->all(), [
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|min:12'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $data = [
            'quiz_id' => $request->quiz_id,
            'question' => $request->question
        ];

        $question = Question::create($data);
        if ($question) {
            return response()->json([
                'message' => 'Question successfully created'
            ], 200);
        }

        return response()->json([
            'error' => 'Bad Request',
            'status' => 400
        ]);
    }

    public function delete(Request $request)
    {
        Log::debug("Attempting to delete question...");

        try {
            $question = Question::findOrFail($request->id);
            $question->delete();

            return response()->json([
                'message' => 'Question successfully deleted.',
                'status' => 200
            ]);
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Could not find specified question.',
                'status' => 404
            ]);
        }
    }

    public function list($id)
    {
        $arr = [];
        $questions = Question::where('quiz_id', '=', $id)->get();
        foreach ($questions as $question) {
            $q = new Question;
            $choices = $q->getChoices($question->id);

            $arr[] = [
                'id' => $question->id,
                'question' => $question->question,
                'choices' => [
                    'choice1' => $choices->choice1,
                    'choice2' => $choices->choice2,
                    'choice3' => $choices->choice3,
                    'answer' => $choices->answer
                ]
            ];
        }

        return $arr;
    }

    public function show($id)
    {
        $question = Question::find($id);
        $choices = Choice::where('question_id', '=', $id)->get();
        
        if ($question) {
            return response()->json([
                'content' => [
                    'question' => $question,
                    'choices' => $choices
                ],
                'status' => 200
            ]);
        }

        return response()->json([
            'error' => 'Question not found'
        ], 404);
    }

    public function update(Request $request)
    {
        Log::debug("Attempting to update question...");

        $validator = Validator::make($request->all(), [
            'question' => 'required|min:12'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        try {
            $question = Question::findOrFail($request->id);

            $question->title = $request->title;

            if ($request->has('content')) {
                $question->content = $request->content;
            }

            $question->save();

            return response()->json([
                'message' => 'Question successfully updated.',
                'status' => 200
            ]);
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
               'message' => 'Could not find specified question.',
               'status' => 404
            ]);
        }
    }
}