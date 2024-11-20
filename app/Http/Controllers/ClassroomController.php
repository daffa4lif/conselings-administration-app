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
        // jika ada hasil reports sebelumnya
        $reports = session(auth()->user()->id . "-upload-siswa-kelas") ?? null;

        session()->forget(auth()->user()->id . "-upload-siswa-kelas");

        return view("pages.classroom.upload", compact("id", "reports"));
    }

    public function registerStudentByUploadPost($id, Request $request, \App\Services\StudentService $studentService)
    {
        $request->validate([
            'fileSiswa' => 'required',
            "year" => ["required", "string", "max:4", "min:4"]
        ]);

        $classroom = Classroom::findOr($id, function () {
            return back()->withErrors('data kelas tidak ditemukan');
        });

        try {
            $reports = $studentService->registerStudentsClassroom($request->input("fileSiswa"), $classroom, $request->input("year"));

            session([
                auth()->user()->id . "-upload-siswa-kelas" => $reports
            ]);

            return back()->with('success', 'data berhasil diolah');
        } catch (\App\Exceptions\SpreadsheetException $spx) {
            return back()->withErrors('file upload tidak sesuai tamplate');
        } catch (\Throwable $th) {
            dd($th);
            return self::redirectResponseServerError();
        }
    }

    public function delete($id)
    {
        Classroom::findOr($id, function () {
            return back()->withErrors('data kelas tidak ditemukan');
        })->delete();

        return redirect()->route('classroom.index')->with('success', 'berhasil menghapus data kelas');
    }
}
