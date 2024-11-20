<?php

namespace App\Http\Controllers;

use App\Models\HomeVisit;
use Illuminate\Http\Request;

class HomeVisitController extends Controller
{
    public function index()
    {
        return view("pages.home-visit.index");
    }

    public function create()
    {
        return view("pages.home-visit.create");
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'studentId' => ['required', 'exists:students,id'],
            'parent' => ['required', 'string', 'max:255', 'min:2'],
            'case' => ['required', 'string', 'max:255', 'min:2'],
        ]);

        try {
            $homeVisit = HomeVisit::create([
                'student_id' => $request->input('studentId'),
                'parent_name' => $request->input('parent'),
                'case' => $request->input('case'),
                'status' => 'PROCESS',
            ]);

            return redirect()->route('home-visit.detail', $homeVisit->id)->with('success', 'berhasil menambah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function detail($id)
    {
        $visits = HomeVisit::with('student')->findOrFail($id);

        return view("pages.home-visit.detail", compact("visits"));
    }

    public function detailPost($id, Request $request)
    {
        $request->validate([
            'parent' => ['required', 'string', 'max:255', 'min:2'],
            'case' => ['required', 'string', 'max:255', 'min:2'],
            'status' => ['required', 'in:PROCESS,FINISH'],
            'solution' => ['required_if:status,FINISH']
        ]);

        $homeVisit = HomeVisit::findOr($id, function () {
            return back()->withErrors('data home visit tidak ditemukan');
        });

        try {
            $homeVisit->parent_name = $request->input('parent');
            $homeVisit->case        = $request->input('case');
            $homeVisit->status      = $request->input('status');
            $homeVisit->solution    = $request->input('solution') ?? null;
            $homeVisit->save();

            return back()->with('success', 'berhasil menyimpan data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function delete($id)
    {
        HomeVisit::findOr($id, function () {
            return back()->withErrors('data home visit tidak ditemukan');
        })->delete();

        return redirect()->route('home-visit.index')->with('success', 'berhasil menghapus data');
    }
}
