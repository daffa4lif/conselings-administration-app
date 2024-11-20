<?php

namespace App\Http\Controllers;

use App\Models\Absent;
use Illuminate\Http\Request;

class AbsentController extends Controller
{
    public function index()
    {
        return view("pages.absent.index");
    }

    public function create()
    {
        return view("pages.absent.index");
    }

    public function createPost(Request $request)
    {

    }

    public function detail($id)
    {
        $absent = Absent::with('student')->findOrFail($id);

        return view("pages.absent.detail");
    }

    public function detailPost()
    {

    }

    public function upload()
    {
        return view("pages.absent.upload");
    }

    public function uploadPost(Request $request)
    {

    }

    public function delete($id)
    {

    }
}
