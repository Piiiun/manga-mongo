<?php

namespace App\Http\Controllers;

use App\Models\Help;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function show($slug)
    {
        $help = Help::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('help.show', compact('help'));
    }
}