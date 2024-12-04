<?php

namespace App\Http\Controllers;

use App\Models\StudenCase;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index()
    {
        return view("pages.case.index");
    }

    public function create()
    {
        return view("pages.case.create");
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'studentId' => ['required', 'exists:students,id'],
            'type' => ['required', 'in:RINGAN,SEDANG,BERAT'],
            'point' => ['required', 'numeric', 'min:0', 'max:110'],
            'case' => ['required', 'string', 'max:255', 'min:2'],
        ]);

        try {
            $case = StudenCase::create([
                'student_id' => $request->input('studentId'),
                'type' => $request->input('type'),
                'point' => $request->input('point'),
                'case' => $request->input('case'),
                'status' => 'PROCESS',
            ]);

            return redirect()->route('case.detail', $case->id)->with('success', 'berhasil menambah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function detail($id)
    {
        $case = StudenCase::with('student')->findOrFail($id);

        return view("pages.case.detail", compact("case"));
    }

    public function detailPost($id, Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:RINGAN,SEDANG,BERAT'],
            'point' => ['required', 'numeric', 'min:0', 'max:110'],
            'case' => ['required', 'string', 'max:255', 'min:2'],
            'status' => ['required', 'in:PROCESS,FINISH,DIALIHKAN'],
            'solution' => ['required_if:status,FINISH']
        ]);

        $case = StudenCase::findOr($id, function () {
            return back()->withErrors('data kasus tidak ditemukan');
        });

        try {
            $case->type     = $request->input('type');
            $case->point    = $request->input('point');
            $case->case     = $request->input('case');
            $case->status   = $request->input('status');
            $case->solution = $request->input('solution') ?? null;
            $case->save();

            return back()->with('success', 'berhasil menyimpan data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function delete($id)
    {
        StudenCase::findOr($id, function () {
            return back()->withErrors('data kasus tidak ditemukan');
        })->delete();

        return redirect()->route('case.index')->with('success', 'berhasil menghapus data');
    }
}
