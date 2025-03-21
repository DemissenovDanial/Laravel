<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Jobs\StoreUserJob;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = User::getRoles();
        return view('admin.user.create', compact('roles'));
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();
            StoreUserJob::dispatch($data);
        } catch (\Exception $exception) {
            abort(500);
        }
        return redirect()->route('admin.user.index');
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        try {
            $roles = User::getRoles();
            return view('admin.user.edit', compact('user', 'roles'));
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->validated();
        if (isset($data['user'])) {
            $user->update($data);
        }
        return view('admin.user.show', compact('user'));
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index');
    }
}
