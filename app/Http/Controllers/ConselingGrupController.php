<?php

namespace App\Http\Controllers;

use App\Models\Conseling\ConselingGroup;
use Illuminate\Http\Request;

class ConselingGrupController extends Controller
{
    public function index()
    {
        return view("pages.conseling-group.index");
    }

    public function create()
    {
        return view("pages.conseling-group.create");
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'studentIds.*' => ['required', 'exists:students,id'],
            'category' => 'required',
            'case' => ['required', 'min:3', 'max:255'],
        ]);

        try {
            $conseling = ConselingGroup::create([
                'category' => $request->input('category'),
                'case' => $request->input('case'),
                'status' => 'PROCESS',
                'user_id' => auth()->user()->id
            ]);

            $conseling->students()->attach($request->input('studentIds'));

            return redirect()->route('conseling-group.detail', $conseling->id)->with('success', 'berhasil menambah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function detail($id)
    {
        $conseling = ConselingGroup::with('students')->findOrFail($id);

        return view("pages.conseling-group.detail", compact("conseling"));
    }

    public function detailPost($id, Request $request)
    {
        $request->validate([
            'studentIds.*' => ['required', 'exists:students,id'],
            'case' => ['required', 'min:3', 'max:255'],
            'category' => 'required',
            'status' => ['required', 'in:PROCESS,FINISH,DIALIHKAN']
        ]);

        $conseling = ConselingGroup::with('students')->findOr($id, function () {
            return back()->withErrors('data conseling grup tidak ditemukan');
        });

        try {
            $conseling->category = $request->input('category');
            $conseling->case     = $request->input('case');
            $conseling->status   = $request->input('status');
            $conseling->solution = $request->input('solution');
            $conseling->save();

            $conseling->students()->sync($request->input('studentIds'));

            return back()->with('success', 'berhasil mengubah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function delete($id)
    {
        ConselingGroup::with('students')->findOr($id, function () {
            return back()->withErrors('data conseling grup tidak ditemukan');
        })->delete();

        return redirect()->route('conseling-group.index')->with('success', 'berhasil menghapus data');
    }
}
