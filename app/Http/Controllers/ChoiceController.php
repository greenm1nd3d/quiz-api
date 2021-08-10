<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

use App\Models\Choice;


class ChoiceController extends Controller
{
    public function index() {
        return "Nothing to see here";
    }

    public function create(Request $request)
    {
        Log::debug("Attempting to create choices...");

        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:questions,id',
            'choice1' => 'required|min:2',
            'choice2' => 'required|min:2',
            'choice3' => 'required|min:2',
            'answer' => 'required|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $data = [
            'question_id' => $request->question_id,
            'choice1' => $request->choice1,
            'choice2' => $request->choice2,
            'choice3' => $request->choice3,
            'answer' => $request->answer
        ];

        $choices = Choice::create($data);
        if ($choices) {
            return response()->json([
                'message' => 'Choices successfully created'
            ], 200);
        }

        return response()->json([
            'error' => 'Bad Request',
            'status' => 400
        ]);
    }

    public function delete(Request $request)
    {
        return "Nothing to see here";
        // This function is not needed. The choices will be deleted along with the question.
    }

    public function list()
    {
        return Choice::all();
    }

    public function update(Request $request)
    {
        Log::debug("Attempting to update choices for specified question...");

        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:questions,id',
            'choice1' => 'required|min:2',
            'choice2' => 'required|min:2',
            'choice3' => 'required|min:2',
            'answer' => 'required|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        try {
            // Find choices for question_id
            $choices = Choice::where('question_id', '=', $request->id);

            $choices->question_id = $request->question_id;
            $choices->choice1 = $request->choice1;
            $choices->choice2 = $request->choice2;
            $choices->choice3 = $request->choice3;
            $choices->answer = $request->answer;

            $choices->save();

            return response()->json([
                'message' => 'Choices successfully updated.',
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