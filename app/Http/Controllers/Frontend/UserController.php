<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user', $user));
    }

    public function store(CreateUser $request)
    {
        User::create($request->validated());

        return redirect()->route('users.index')->with('success', 'User is created successfully!');
    }

    public function update(UpdateUser $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('users.index')->with('success', 'User is updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
    }
}
