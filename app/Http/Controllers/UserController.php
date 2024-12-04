<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view("pages.user.index");
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'super admin')->get();
        return view("pages.user.create", compact("roles"));
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'role' => ['required', 'exists:roles,name'],
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required', 'max:255', 'min:4'],
            'password' => 'required'
        ]);

        try {
            $user = User::create([
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'password' => $request->input('password'),
            ])->assignRole($request->input('role'));

            return redirect()->route('master.user.detail', $user->id)->with('success', 'berhasil menambah data');
        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function detail($id)
    {
        $roles = Role::where('name', '!=', 'super admin')->get();
        $user  = User::findOrFail($id);

        return view("pages.user.detail", compact("user", "roles"));
    }

    public function detailPost($id, Request $request)
    {
        $request->validate([
            'role' => ['required', 'exists:roles,name'],
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

            $user->syncRoles($request->input('role'));
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
