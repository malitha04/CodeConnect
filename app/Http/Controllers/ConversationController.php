<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = Auth::user()->conversations()->with('messages')->get();

        return view('inbox.index', ['conversations' => $conversations]);
    }
}
