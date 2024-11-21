<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function indexAbsents()
    {
        return view("pages.report.absent");
    }

    public function printAbsents(Request $request)
    {

    }

    public function indexHomeVisits()
    {
        return view("pages.report.home-visit");
    }

    public function printHomeVisits(Request $request)
    {

    }
}
