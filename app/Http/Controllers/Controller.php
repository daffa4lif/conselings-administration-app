<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public static function redirectResponseServerError()
    {
        return back()->with('error', 'server error. coba lagi nanti!');
    }
}
