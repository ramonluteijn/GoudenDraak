<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Answer;
class QuestionService
{
    public function storeAnswers(array $answers): void
    {
        foreach ($answers as $questionId => $answerText) {
            $question = Question::find($questionId);
            if ($question) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $answerText,
                ]);
            }
        }
    }
}
