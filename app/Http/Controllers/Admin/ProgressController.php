<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Question;

class ProgressController extends Controller
{
    public function index()
    {
        $ordersToday = Order::whereDate('created_at', now()->toDateString())->count();
        $revenueToday = Order::whereDate('created_at', now()->toDateString())->sum('price');


        $questions = Question::leftJoin('answers', 'questions.id', '=', 'answers.question_id')
            ->select('questions.id', 'questions.question')
            ->selectRaw('COUNT(answers.id) as answer_count')
            ->groupBy('questions.id', 'questions.question')
            ->get();

        return view('vendor.backpack.ui.dashboard', [
            'ordersToday' => $ordersToday,
            'revenueToday' => $revenueToday,
            'questions' => $questions,
        ]);
    }
}
