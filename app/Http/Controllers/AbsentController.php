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
        return view("pages.absent.create");
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'studentId' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'type' => ['required', 'in:IZIN,SAKIT,ALPHA'],
            'description' => ['required', 'min:3'],
        ]);

        try {
            $absent = Absent::create([
                'student_id' => $request->input('studentId'),
                'type' => $request->input('type'),
                'violation_date' => $request->input('date'),
                'description' => $request->input('description'),
                'user_id' => auth()->user()->id
            ]);

            return redirect()->route('absent.detail', $absent->id)->with('success', 'data berhasil dibuat');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function detail($id)
    {
        $absent = Absent::with('student')->findOrFail($id);

        return view("pages.absent.detail", compact("absent"));
    }

    public function detailPost($id, Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'type' => ['required', 'in:IZIN,SAKIT,ALPHA'],
            'description' => ['required', 'min:3'],
        ]);

        $absent = Absent::with('student')->findOr($id, function () {
            return back()->withErrors('data absent tidak ditemukan');
        });

        try {
            $absent->type           = $request->input('type');
            $absent->violation_date = $request->input('date');
            $absent->description    = $request->input('description');
            $absent->save();

            return back()->with('success', 'berhasil mengubah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function upload()
    {
        // jika ada hasil reports sebelumnya
        $reports = session()->get(auth()->user()->id . "-upload-absent") ?? [];

        if (session()->exists(auth()->user()->id . "-upload-absent")) {
            session()->forget(auth()->user()->id . "-upload-absent");
        }

        return view("pages.absent.upload", compact("reports"));
    }

    public function uploadPost(Request $request, \App\Services\AbsentService $absentService)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'fileAbsent' => 'required'
        ]);


        try {
            $reports = $absentService->createNewAbsentsBySpreadsheetTemp($request->input('fileAbsent'), $request->input('date'));

            session([
                auth()->user()->id . "-upload-absent" => $reports
            ]);

            return back()->with('success', 'data berhasil diolah');
        } catch (\Throwable $th) {
            dd($th);
            return self::redirectResponseServerError();
        }
    }

    public function delete($id)
    {
        $absent = Absent::findOr($id, function () {
            return back()->withErrors('data absent tidak ditemukan');
        })->delete();

        return redirect()->route('absent.index')->with('success', 'data berhasil dihapus');
    }
}
