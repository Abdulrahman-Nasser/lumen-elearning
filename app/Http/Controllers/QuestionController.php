<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'question' => 'required',
            'model_answer' => 'required',
        ]);

        $question = Question::create($request->all());
        return response()->json($question, 201);
    }

    public function show($id)
    {
        $question = Question::find($id);
        if ($question) {
            return response()->json($question);
        } else {
            return response()->json(['message' => 'Question not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required',
            'question' => 'required',
            'model_answer' => 'required',
        ]);

        $question = Question::find($id);
        if ($question) {
            $question->update($request->all());
            return response()->json($question, 200);
        } else {
            return response()->json(['message' => 'Question not found'], 404);
        }
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        if ($question) {
            $question->delete();
            return response()->json(['message' => 'Question deleted'], 204);
        } else {
            return response()->json(['message' => 'Question not found'], 404);
        }
    }
}
