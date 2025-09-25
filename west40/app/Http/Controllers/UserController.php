<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $q    = $request->string('q')->toString();
        $sort = $request->get('sort', 'id');
        $dir  = strtolower($request->get('dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowed = ['id', 'name', 'email', 'created_at'];
        if (! in_array($sort, $allowed, true)) {
            $sort = 'id';
        }

        $query = User::query();

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $items = $query->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('items', 'q', 'sort', 'dir'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        // Permanent delete (users table has no SoftDeletes by default)
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
    
    public function toggleStatus(User $user): RedirectResponse
    {
        // 1 = active, 0 = inactive
        $user->status = $user->status ? 0 : 1;
        $user->save();

        return redirect()
            ->route('users.index', request()->query()) // keep query/sort/page
            ->with('success', $user->status ? 'User activated.' : 'User deactivated.');
    }
}

