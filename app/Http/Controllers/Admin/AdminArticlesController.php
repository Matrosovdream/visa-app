<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ArticleRepo;
use App\Helpers\adminSettingsHelper;

class AdminArticlesController extends Controller
{
    public function __construct(private ArticleRepo $articleRepo) {}

    public function index()
    {
        $result = $this->articleRepo->getAll([], 20);

        $data = [
            'title' => 'Articles',
            'articles' => $result['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.articles.index', $data);
    }

    public function show($id)
    {
        $article = $this->articleRepo->getByID($id);

        $data = [
            'title' => 'Edit '.$article['Model']->title,
            'article' => $article['Model'],
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

    public function store()
    {
        $this->articleRepo->create([
            'title' => request('title'),
            'content' => request('content'),
        ]);

        return redirect()->route('admin.articles.index');
    }

    public function edit($id)
    {
        $article = $this->articleRepo->getByID($id);

        $data = [
            'title' => 'Edit '.$article['Model']->title,
            'article' => $article['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.articles.edit', $data);
    }

    public function update($id)
    {
        $this->articleRepo->update($id, [
            'title' => request('title'),
            'content' => request('content'),
        ]);

        return redirect()->route('admin.articles.index');
    }

    public function destroy($id)
    {
        $this->articleRepo->delete($id);
        return redirect()->route('admin.articles.index');
    }
}
