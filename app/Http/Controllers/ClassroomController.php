<?php

namespace App\Http\Controllers;

use App\Models\Master\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        return view("pages.classroom.index");
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'major' => ['required', 'in:IPA,IPS'],
            'name' => ['required', 'string', 'max:255', new \App\Rules\UniqueClassroomName]
        ]);

        try {
            Classroom::create([
                'name' => $request->input("name"),
                'major' => $request->input("major")
            ]);

            return back()->with("success", "berhasil menambah data kelas");
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function detail($id)
    {
        $classroom = Classroom::findOrFail($id);

        return view("pages.classroom.detail", compact("classroom"));
    }

    public function detailPost($id, Request $request)
    {
        $request->validate([
            'major' => ['required', 'in:IPA,IPS'],
            'name' => ['required', 'string', 'max:255', new \App\Rules\UniqueClassroomName]
        ]);

        $classroom = Classroom::findOrFail($id);

        try {
            $classroom->name  = $request->input('name');
            $classroom->major = $request->input('major');
            $classroom->save();

            return back()->with('success', 'berhasil mengubah data kelas');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function registerStudentByUpload($id)
    {

    }

    public function registerStudentByUploadPost($id, Request $request)
    {
        $request->validate([

        ]);
    }
}
