@csrf
<div class="space-y-3">
    <div>
        <label class="block text-sm" for="name">Name</label>
        <input id="name" name="name" type="text"
            value="{{ old('name', $student->name ?? '') }}"
            required maxlength="255" autocomplete="name"
            class="border rounded px-3 py-2 w-full
            invalid:border-red-500 focus:invalid:ring-red-300"
            placeholder="First Last">
        @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm" for="email">Email</label>
        <input id="email" name="email" type="email"
            value="{{ old('email', $student->email ?? '') }}"
            required maxlength="255" autocomplete="email" inputmode="email"
            class="border rounded px-3 py-2 w-full
            invalid:border-red-500 focus:invalid:ring-red-300"
            placeholder="name@example.com">
        @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm" for="dob">Date of Birth</label>
        <input id="dob" name="dob" type="date"
            value="{{ old('dob', isset($student) && $student->dob ? $student->dob->format('Y-m-d') : '') }}"
            required
            class="border rounded px-3 py-2 w-full
            invalid:border-red-500 focus:invalid:ring-red-300">
            @error('dob')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mt-4 flex gap-2">
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
    <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
</div>

