<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Redirect to the posts page.
     */
    public function dashboard()
    {
        return redirect()->route('posts.index');
    }
}
