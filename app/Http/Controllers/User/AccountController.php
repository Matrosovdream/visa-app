<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ArticleRepo;
use Illuminate\Http\Request;
use App\Actions\Web\AccountActions;

class AccountController extends Controller
{
    public function __construct(private ArticleRepo $articleRepo) {}

    public function index()
    {
        $data = array('title' => 'Articles');
        return view('web.account.index', $data);
    }

    public function settings()
    {
        $result = $this->articleRepo->getAll([], 10);
        $data = array('title' => 'Articles', 'articles' => $result['Model']);
        return view('web.account.settings', $data);
    }

    public function settingsUpdate(Request $request)
    {
        AccountActions::settingsUpdate($request);
        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
