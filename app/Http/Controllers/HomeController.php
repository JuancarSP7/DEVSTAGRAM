<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function __invoke()
{
    $ids = auth()->user()->followings->pluck('id')->toArray();

    $posts = Post::whereIn('user_id', $ids)
                 ->with('user') // ❗️ Muy importante
                 ->latest()
                 ->paginate(21);

    return view('home', [
        'posts' => $posts
    ]);
}

}
