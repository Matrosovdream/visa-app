<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ArticleRepo;
use App\Helpers\adminSettingsHelper;

class DashboardArticlesController extends Controller
{
    public $perPage = 10;

    public function __construct(private ArticleRepo $articleRepo) {}

    public function index()
    {
        if (request('s')) {
            $result = $this->articleRepo->search(request('s'), $this->perPage);
        } else {
            $result = $this->articleRepo->getAll([], $this->perPage);
        }

        $data = [
            'title' => 'Articles',
            'articles' => $result['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.articles.index', $data);
    }

    public function show($id)
    {
        $article = $this->articleRepo->getByID($id);

        $data = [
            'title' => 'Edit '.$article['Model']->title,
            'article' => $article['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.articles.show', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Article',
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.articles.create', $data);
    }

    public function store()
    {
        $this->articleRepo->create([
            'title' => request('title'),
            'content' => request('content'),
        ]);

        return redirect()->route('dashboard.articles.index');
    }

    public function edit($id)
    {
        $article = $this->articleRepo->getByID($id);

        $data = [
            'title' => 'Edit '.$article['Model']->title,
            'article' => $article['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.articles.edit', $data);
    }

    public function update($id)
    {
        $this->articleRepo->update($id, [
            'title' => request('title'),
            'content' => request('content'),
        ]);

        return redirect()->route('dashboard.articles.index');
    }

    public function destroy($id)
    {
        $this->articleRepo->delete($id);
        return redirect()->route('dashboard.articles.index');
    }
}
