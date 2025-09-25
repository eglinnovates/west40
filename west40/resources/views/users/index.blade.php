{{-- resources/views/users/index.blade.php --}}
@extends('layouts.app')

@section('content')
    @php
    $nextDir = fn($col) => (request('sort') === $col && request('dir') === 'asc') ? 'desc' : 'asc';
    $caret   = function($col) {
        if (request('sort') !== $col) return '';
        return request('dir') === 'asc' ? '▲' : '▼';
    };
@endphp

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

        <a href="{{ route('users.create') }}"
        class="hidden sm:inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded">Add User</a>
        <a href="{{ route('users.create') }}"
        class="inline-flex sm:hidden items-center justify-center p-2 pt-[11px] pb-[11px] bg-blue-600 text-white rounded"
        aria-label="Add User" title="Add User">
            {{-- plus icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
        </a>
    </div>

    <div class="bg-white border rounded">
        <table class="min-w-full text-sm table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left p-2">
                        <a class="inline-flex items-center gap-1 hover:underline"
                       href="{{ route('users.index', array_merge(request()->except('page'), ['sort'=>'id','dir'=>$nextDir('id')])) }}">
                            ID <span>{{ $caret('id') }}</span>
                        </a>
                    </th>
                    <th class="text-left p-2">
                        <a class="inline-flex items-center gap-1 hover:underline"
                       href="{{ route('users.index', array_merge(request()->except('page'), ['sort'=>'name','dir'=>$nextDir('name')])) }}">
                            Name <span>{{ $caret('name') }}</span>
                        </a>
                    </th>
                    <th class="text-left p-2 hidden sm:table-cell">
                        <a class="inline-flex items-center gap-1 hover:underline"
                       href="{{ route('users.index', array_merge(request()->except('page'), ['sort'=>'email','dir'=>$nextDir('email')])) }}">
                            Email <span>{{ $caret('email') }}</span>
                        </a>
                    </th>
                    <th class="text-left p-2 hidden sm:table-cell">
                        <a class="inline-flex items-center gap-1 hover:underline"
                       href="{{ route('users.index', array_merge(request()->except('page'), ['sort'=>'created_at','dir'=>$nextDir('created_at')])) }}">
                            Created <span>{{ $caret('created_at') }}</span>
                        </a>
                    </th>
                    <th class="text-left p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $user)
                    <tr class="border-t">
                        <td class="p-2">{{ $user->id }}</td>
                        <td class="p-2">{{ $user->name }}</td>

                        {{-- Hidden on mobile --}}
                        <td class="p-2 hidden sm:table-cell">{{ $user->email }}</td>
                        <td class="p-2 hidden sm:table-cell">{{ $user->created_at->format('Y-m-d') }}</td>

                        <td class="p-2">
                            <div class="flex flex-wrap gap-2">
                                {{-- Edit link: icon-only on mobile, icon+text on sm+ --}}
                                <a href="{{ route('users.edit', $user) }}"
                           class="inline-flex items-center justify-center p-2 sm:px-3 sm:py-2 rounded text-green-600 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-yellow-300"
                           aria-label="Edit" title="Edit">
                                    {{-- pencil icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5"
                                 class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.862 4.487a2.121 2.121 0 013 3L8.25 19.1 4.5 19.5l.4-3.75L16.862 4.487z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19.5 7.5L16.5 4.5" />
                                    </svg>
                                </a>

                                <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                    class="inline-flex items-center justify-center p-2 sm:px-3 sm:py-2 rounded @if($user->status) text-red-600 hover:bg-red-100 @else text-green-700 hover:bg-green-100 @endif focus:outline-none focus:ring-2 focus:ring-gray-300"
                                    aria-label="{{ $user->status ? 'Deactivate user' : 'Activate user' }}"
                                    title="{{ $user->status ? 'Deactivate user' : 'Activate user' }}">

                                        @if($user->status)
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.5 7a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM3.75 20.25a7.75 7.75 0 0112.5-6.2" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 18h6" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.5 19.5a7.5 7.5 0 0115 0" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 8.25v3m-1.5-1.5h3" />
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="5">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
@endsection

