<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mail;

class SiteController extends Controller
{
    // Home

    public function home()
    {
        try {
            return view('home.home');
        } catch (\Exception $e) {
            \Log::error('HomeController Error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            return response('Internal Server Error', 500);
        }
    }
}
