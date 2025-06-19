<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private QuestionService $questionService;
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        return view('survey.index', [
            'questions' => Question::all(),
        ]);
    }

    /*
     * Store the answers to the questions.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string|max:255',
        ]);

        $this->questionService->storeAnswers($validatedData['answers']);

        return to_route('survey.confirmation');
    }

    /*
     * Show the confirmation page after survey submission.
     */
    public function confirmation()
    {
        return view('survey.confirmation');
    }
}
