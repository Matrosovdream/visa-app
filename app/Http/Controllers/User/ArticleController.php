<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ArticleRepo;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(private ArticleRepo $articleRepo) {}

    public function index(Request $request)
    {
        $result = $this->articleRepo->getAll([], 10);
        $data = array('title' => 'Articles', 'articles' => $result['Model']);
        return view('web.articles.index', $data);
    }

    public function show($article_slug)
    {
        $article = $this->articleRepo->getBySlug($article_slug);
        $data = array('title' => 'Homepage', 'article' => $article['Model']);
        return view('web.articles.show', $data);
    }
}
