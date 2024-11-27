<?php

namespace App\Http\Controllers;

use App\Models\Master\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::get();

        return view('pages.major.index', compact("majors"));
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:majors,name']
        ]);

        try {
            $major = Major::create(['name' => $request->input('name')]);

            return back()->with('success', 'berhasil menambah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function detail($id)
    {
        $major = Major::findOrFail($id);

        return view('pages.major.detail', compact("major"));
    }

    public function detailPost(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', "unique:majors,name,$id"]
        ]);

        $major = Major::findOrFail($id);

        try {
            $major->name = $request->input('name');
            $major->save();

            return back()->with('success', 'berhasil mengubah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function delete($id)
    {
        Major::findOrFail($id)->delete();

        return redirect()->route('major.index')->with('success', 'berhasil menghapus data');
    }
}
