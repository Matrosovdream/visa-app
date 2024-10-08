<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

class indexController extends Controller {
    
    public function index()
    {
        return view('user.index');
    }

}
