<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Helpers\adminSettingsHelper;

class AdminArticlesController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Articles',
            'articles' => Article::all(),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.articles.index', $data);
    }

    public function show($id)
    {
        $article = Article::find($id);

        $data = [
            'title' => 'Edit '.$article->title,
            'article' => $article,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.articles.show', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Article',
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.articles.create', $data);
    }

}
