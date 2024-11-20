<?php

namespace App\Http\Controllers;

use App\Models\Conseling\Conseling;
use Illuminate\Http\Request;

class ConselingController extends Controller
{
    public function index()
    {
        return view("pages.conseling.index");
    }

    public function create()
    {
        return view("pages.conseling.create");
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'studentId' => ['required', 'exists:students,id'],
            'case' => ['required', 'max:255', 'min:3']
        ]);

        try {
            $conseling = Conseling::create([
                'student_id' => $request->input('studentId'),
                'case' => $request->input('case'),
                'status' => 'PROCESS',
                'user_id' => auth()->user()->id
            ]);

            return redirect()->route('conseling.detail', $conseling->id)->with('success', 'berhasil membuat data baru');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function detail($id)
    {
        $conseling = Conseling::with('student')->findOrFail($id);

        return view("pages.conseling.detail", compact("conseling"));
    }

    public function detailPost($id, Request $request)
    {
        $request->validate([
            'case' => ['required', 'max:255', 'min:3'],
            'status' => ['required', 'in:PROCESS,FINISH']
        ]);

        $conseling = Conseling::findOr($id, function () {
            return back()->withErrors('data conseling tidak ditemukan');
        });

        try {
            $conseling->case     = $request->input('case');
            $conseling->status   = $request->input('status');
            $conseling->solution = $request->input('solution');
            $conseling->save();

            return back()->with('success', 'berhasil mengubah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function delete($id)
    {
        Conseling::findOr($id, function () {
            return back()->withErrors('data conseling tidak ditemukan');
        })->delete();

        return redirect()->route('conseling.index')->with('success', 'berhasil menghapus data');
    }
}
