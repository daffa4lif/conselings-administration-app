<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view("pages.user.index");
    }

    public function create()
    {
        return view("pages.user.create");
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required', 'max:255', 'min:4'],
            'password' => 'required'
        ]);

        try {
            $user = User::create([
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'password' => $request->input('password'),
            ]);

            return redirect()->route('master.user.detail', $user->id)->with('success', 'berhasil menambah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function detail($id)
    {
        $user = User::findOrFail($id);

        return view("pages.user.detail", compact("user"));
    }

    public function detailPost($id, Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', "unique:users,id,$id"],
            'name' => ['required', 'max:255', 'min:4'],
        ]);

        $user = User::findOr($id, function () {
            return back()->withErrors('data user tidak ditemukan');
        });

        try {
            $user->email = $request->input('email');
            $user->name  = $request->input('name');

            if ($request->input('password') != null || $request->input('password') != '') {
                $user->password = $request->input('password');
            }

            $user->save();

            return back()->with('success', 'berhasil menyimpan data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function delete($id)
    {
        User::findOr($id, function () {
            return back()->withErrors('data user tidak ditemukan');
        })->delete();

        return redirect()->route('master.user.index')->with('success', 'berhasil menghapus data');
    }
}
