<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Actions\Web\AccountActions;

class AccountController extends Controller
{

    public function index()
    {
        $data = array('title' => 'Articles');
        return view('web.account.index', $data);
    }
    public function settings()
    {
        $data = array('title' => 'Articles','articles' => Article::paginate(10));
        return view('web.account.settings', $data);
    }

    public function settingsUpdate( Request $request )
    {
        AccountActions::settingsUpdate($request);
        return redirect()->back()->with('success', 'Settings updated successfully');
    }

}
