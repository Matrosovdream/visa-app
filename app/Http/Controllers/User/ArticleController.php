<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    
    public function index()
    {
        return view('user.articles.index');
    }

    public function show($article)
    {
        return view('user.articles.show', compact('article'));
    }

}
