@csrf
<div class="space-y-3">
    <div>
        <label class="block text-sm" for="u_name">Name</label>
        <input id="u_name" name="name" type="text"
            value="{{ old('name', $user->name ?? '') }}"
            required maxlength="255" autocomplete="name"
            class="border rounded px-3 py-2 w-full invalid:border-red-500"
            placeholder="Full name">
        @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm" for="u_email">Email</label>
        <input id="u_email" name="email" type="email"
            value="{{ old('email', $user->email ?? '') }}"
            required maxlength="255" autocomplete="email" inputmode="email"
            class="border rounded px-3 py-2 w-full invalid:border-red-500"
            placeholder="name@example.com">
        @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

      {{-- Create: required password; Edit: optional --}}
    <div>
        <label class="block text-sm" for="u_password">
                Password @isset($user)<span class="text-xs text-gray-500">(leave blank to keep)</span>@endisset
        </label>
        <input id="u_password" name="password" type="password"
            @empty($user) required minlength="8" @endempty
            autocomplete="new-password"
            class="border rounded px-3 py-2 w-full invalid:border-red-500"
            placeholder="Min 8 characters">
        @error('password')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm" for="u_password_confirmation">Confirm Password</label>
        <input id="u_password_confirmation" name="password_confirmation" type="password"
        @empty($user) required minlength="8" @endempty
            autocomplete="new-password"
            class="border rounded px-3 py-2 w-full invalid:border-red-500"
            placeholder="Repeat password">
    </div>
</div>

<div class="mt-4 flex gap-2">
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
</div>

