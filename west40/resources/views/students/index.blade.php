@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-4 gap-2">
        <form id="search-form" method="GET" action="{{ url()->current() }}"
              x-data="{ q: @js(request('q')) }"
              class="flex items-stretch gap-2 flex-1 sm:flex-none">

          {{-- input + clear inside a relative wrapper --}}
          <div class="relative w-full sm:w-64">
            <input
              x-model="q"
              type="text"
              name="q"
              placeholder="Search name or email"
              class="border rounded px-3 py-2 w-full pr-10"  {{-- ← room for the ✕ --}}
            />

            {{-- Clear (right side, inside the box) --}}
            <button type="button"
                    x-show="q"
                    @click="q=''; $nextTick(() => document.getElementById('search-form').submit())"
                    x-cloak
                    class="absolute inset-y-0 right-0 mr-1 my-auto inline-flex items-center justify-center
                           h-5 w-5 rounded-full text-red-600 hover:text-red-700 focus:outline-none
                           focus:ring-2 focus:ring-red-300"
                    aria-label="Clear search" title="Clear search">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                   fill="currentColor" class="h-4 w-4">
                <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"/>
              </svg>
            </button>
          </div>

          {{-- your existing submit buttons --}}
          <button type="submit"
                  class="hidden sm:inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded">
            Search
          </button>
          <button type="submit"
                  class="inline-flex sm:hidden items-center justify-center p-2 bg-gray-800 text-white rounded"
                  aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m1.6-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </button>
        </form>


        <a href="{{ route('students.create') }}"
        class="hidden sm:inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded">Add Student</a>
        <a href="{{ route('students.create') }}"
        class="inline-flex sm:hidden items-center justify-center p-2 pt-[11px] pb-[11px] bg-blue-600 text-white rounded"
        aria-label="Add Student">
            {{-- Plus icon (Heroicons outline) --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
        </a>
    </div>

    @php
        // helper for next direction
        $nextDir = fn($col) => (request('sort') === $col && request('dir') === 'asc') ? 'desc' : 'asc';
        $caret = function($col) {
            if (request('sort') !== $col) return '';
            return request('dir') === 'asc' ? '▲' : '▼';
        };
    @endphp

    <div class="bg-white border rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left p-2">
                        <a class="inline-flex items-center gap-1 hover:underline"
                       href="{{ route('students.index', array_merge(request()->except('page'), ['sort'=>'id','dir'=>$nextDir('id')])) }}">
                            ID <span>{{ $caret('id') }}</span>
                        </a>
                    </th>
                    <th class="text-left p-2">
                        <a class="inline-flex items-center gap-1 hover:underline"
                       href="{{ route('students.index', array_merge(request()->except('page'), ['sort'=>'name','dir'=>$nextDir('name')])) }}">
                            Name <span>{{ $caret('name') }}</span>
                        </a>
                    </th>
                    <th class="text-left p-2 hidden sm:table-cell">
                        <a class="inline-flex items-center gap-1 hover:underline"
                       href="{{ route('students.index', array_merge(request()->except('page'), ['sort'=>'email','dir'=>$nextDir('email')])) }}">
                            Email <span>{{ $caret('email') }}</span>
                        </a>
                    </th>
                    <th class="text-left p-2 hidden sm:table-cell">
                        <a class="inline-flex items-center gap-1 hover:underline"
                       href="{{ route('students.index', array_merge(request()->except('page'), ['sort'=>'dob','dir'=>$nextDir('dob')])) }}">
                            DOB <span>{{ $caret('dob') }}</span>
                        </a>
                    </th>
                    <th class="text-left p-2 hidden sm:table-cell">
                        <a class="inline-flex items-center gap-1 hover:underline"
                       href="{{ route('students.index', array_merge(request()->except('page'), ['sort'=>'created_at','dir'=>$nextDir('created_at')])) }}">
                            Created <span>{{ $caret('created_at') }}</span>
                        </a>
                    </th>
                    <th class="text-left p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $student)
                    <tr class="border-t {{ $student->deleted_at ? 'bg-red-50' : '' }}">
                        <td class="p-2">{{ $student->id }}</td>
                        <td class="p-2">{{ $student->name }}</td>

                        {{-- Hidden on mobile --}}
                        <td class="p-2 hidden sm:table-cell">{{ $student->email }}</td>
                        <td class="p-2 hidden sm:table-cell">{{ optional($student->dob)->format('Y-m-d') }}</td>
                        <td class="p-2 hidden sm:table-cell">{{ $student->created_at->format('Y-m-d') }}</td>

                        <td class="p-2">
                            <div class="flex flex-wrap gap-2">
                                @if(!$student->deleted_at)
                                   <a href="{{ route('students.edit', $student) }}"
                                   class="inline-flex items-center justify-center p-2 rounded text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-yellow-300"
                                   aria-label="Edit" title="Edit">
                                    <!-- Pencil icon (Heroicons outline) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.5"
                                         class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16.862 4.487a2.121 2.121 0 013 3L8.25 19.1 4.5 19.5l.4-3.75L16.862 4.487z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19.5 7.5L16.5 4.5" />
                                        </svg>
                                        <span class="sr-only">Edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('students.destroy', $student) }}"
                                        onsubmit="return confirm('Move this student to Trash?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex items-center justify-center p-2 rounded hover:bg-red-100 text-red-600 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-300"
                                                aria-label="Delete" title="Delete">
                                          {{-- Trash icon (Heroicons outline) --}}
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                               fill="none" stroke="currentColor" stroke-width="1.5"
                                               class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6 7.5h12M9.75 7.5V6a1.5 1.5 0 011.5-1.5h1.5A1.5 1.5 0 0114.25 6v1.5m-7.5 0l.75 12A2.25 2.25 0 0010.74 21h2.52a2.25 2.25 0 002.24-2.25l.75-12" />
                                          </svg>
                                          <span class="sr-only">Delete</span>
                                    </button>
                                  </form>
                                @else
                                    <form method="POST" action="{{ route('students.restore', $student->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center justify-center p-2 sm:px-3 sm:py-2 rounded text-green-600 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-300"
                                                aria-label="Restore" title="Restore">
                                            {{-- Arrow U-Turn Left (Heroicons outline) --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="1.5"
                                                 class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9 15l-3-3m0 0l3-3M6 12h7.5a3.5 3.5 0 110 7H7"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('students.delete', $student->id) }}"
                                          onsubmit="return confirm('Permanently delete this student?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center p-2 sm:px-3 sm:py-2 rounded text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-300"
                                                aria-label="Delete" title="Delete">
                                            {{-- Trash (Heroicons outline) --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="1.5"
                                                 class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M6 7.5h12M9.75 7.5V6a1.5 1.5 0 011.5-1.5h1.5A1.5 1.5 0 0114.25 6v1.5m-7.5 0l.75 12A2.25 2.25 0 0010.74 21h2.52a2.25 2.25 0 002.24-2.25l.75-12" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="6">No students found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 w-fit mx-auto">{{ $items->links() }}</div>
@endsection
