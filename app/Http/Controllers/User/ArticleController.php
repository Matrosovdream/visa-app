<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Helpers\userSettingsHelper;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    
    public function index( Request $request )
    {

        $data = array(
            'title' => 'Articles',
            'menuTop' => userSettingsHelper::getTopMenu(),
            'countries' => Country::all(),
            'articles' => Article::paginate(10),
        );

        return view('web.articles.index', $data);
    }

    public function show($article_slug)
    {

        $article = Article::where('slug', $article_slug)->first();

        $data = array(
            'title' => 'Homepage',
            'menuTop' => userSettingsHelper::getTopMenu(),
            'countries' => Country::all(),
            'article' => $article,
        );

        return view('web.articles.show', $data);
    }

}
