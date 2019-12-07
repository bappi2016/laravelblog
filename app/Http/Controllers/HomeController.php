<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User ; // import User Model

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id; // get the authenticated users id and assign it to user_id
        $user = User::find($user_id); // find user id from User and assign it to user
        return view('home')->with('posts',$user->posts);
    }
}
