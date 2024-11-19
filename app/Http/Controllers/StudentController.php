<?php

namespace App\Http\Controllers;

use App\Models\Master\Student;
use App\Models\StudentsClassroom;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private static function redirectResponseServerError()
    {
        return back()->with('error', 'server error. coba lagi nanti!');
    }

    private static function redirectResponseStudentNotFond()
    {
        return back()->withErrors('data siswa tidak ditemukan');
    }

    public function index()
    {
        return view("pages.student.index");
    }

    public function detail($nis)
    {
        $student    = Student::where('nis', $nis)->firstOrFail();
        $classrooms = \App\Models\Master\Classroom::get();

        return view("pages.student.detail", compact("student", "classrooms"));
    }

    public function detailPost($nis, Request $request)
    {
        $request->validate([
            'nis' => ['required', 'numeric', "unique:siswas,nis,$nis"],
            'name' => ['required', 'max:255', 'min:2'],
            'gender' => ['required', 'in:PRIA,WANITA'],
            'address' => ['required', 'string']
        ], [
            'nis.unique' => 'NIS sudah digunakan'
        ]);

        $student = Student::where('nis', $nis)->firstOr(function () {
            self::redirectResponseStudentNotFond();
        });

        try {
            $student->nis     = $request->input('nis');
            $student->name    = $request->input('name');
            $student->gender  = $request->input('gender');
            $student->address = $request->input('address');
            $student->save();

            return back()->with('success', 'berhasil mengubah data siswa');
        } catch (\Throwable $th) {
            return back()->with('error', "server error. coba lagi nanti!");
        }
    }

    public function createNewClassroomPost($nis, Request $request)
    {
        $request->validate([
            'classroomId' => ['required', 'exists:classrooms,id'],
            'year' => ['required', 'numeric']
        ]);

        $student = Student::where('nis', $nis)->firstOr(function () {
            self::redirectResponseStudentNotFond();
        });

        try {
            StudentsClassroom::create([
                'student_id' => $student->id,
                'classroom_id' => $request->input('classroomId'),
                'year' => $request->input('year')
            ]);

            return back()->with('success', 'berhasil menambahkan data siswa ke kelas');
        } catch (\Throwable $th) {
            self::redirectResponseServerError();
        }
    }

    public function deleteClassroom($nis, $idClassroom, $year)
    {

        if (!is_numeric($year)) {
            return back()->withErrors('tahun hanya boleh angka');
        }

        $student = Student::where('nis', $nis)->firstOr(function () {
            self::redirectResponseStudentNotFond();
        });

        try {
            $classroom = StudentsClassroom::where([
                'student_id' => $student->id,
                'classroom_id' => $idClassroom,
                'year' => $year
            ])->firstOr(function () {
                return back()->withErrors('kelas siswa tidak ditemukan');
            });

            $classroom->delete();

            return back()->with('success', 'berhasil menghapus kelas dari siswa');
        } catch (\Throwable $th) {
            self::redirectResponseServerError();
        }
    }
}
