<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        Visitor::incrementPageViews('/', 'home', $request->ip());
        return view('home');
    }
}
