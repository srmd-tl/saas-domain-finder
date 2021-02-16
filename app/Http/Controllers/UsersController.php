<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
  public function index(UsersDataTable $dataTable)
  {
    return $dataTable->render('users.index');
  }

  public function create()
  {
    return view("users.create");
  }

  public function store(Request $request)
  {
    $request->validate(
      [
        "name" => "required",
        "email" => "required|unique:users",
        "password" => "required"
      ]
    );
    $data = [
      "name" => $request->name,
      "email" => $request->email,
      "password" => Hash::make($request->password)
    ];
    User::create($data);
    return redirect()->route("users.index")->withSuccess("User added");
  }

  public function edit(User $user)
  {
    return view("users.edit", ["user" => $user]);
  }

  public function update(User $user, Request $request)
  {
    $request->validate(
      [
        "name" => "required",
        "email" => "required|unique:users,email," . $user->id,
        "password" => "required"
      ]
    );
    $data = [
      "name" => $request->name,
      "email" => $request->email,
      "password" => Hash::make($request->password)
    ];
    $user->update($data);
    return redirect()->route("users.index")->withSuccess("User Updated");
  }

  public function destroy(User $user)
  {
    $user->delete();
    return redirect()->route("users.index")->withSuccess("User Deleted");

  }
}
