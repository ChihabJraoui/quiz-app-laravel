<?php

namespace App\Http\Controllers\Admin;


use App\Category;
use App\Topic;
//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{

    /*
     *  VIEWS
     */

    public function showDashboard()
    {
        return view('admin.dashboard');
    }

    public function showQuizzes()
    {
        return view('quizzes');
    }

    public function getTopicView($slug)
    {
        $topic = Topic::where('slug', $slug)->firstOrFail();
        $author = $topic->author;

        $data = [
            'topic' => $topic,
            'author' => $author
        ];

        return view('topic', $data);
    }

}
