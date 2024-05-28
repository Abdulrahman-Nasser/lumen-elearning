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
        $question = Question::findOrFail($id);
        return response()->json($question);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required',
            'question' => 'required',
            'correct_answer' => 'required',
        ]);

        $question = Question::findOrFail($id);
        $question->update($request->all());
        return response()->json($question, 200);
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return response()->json(null, 204);
    }
}
