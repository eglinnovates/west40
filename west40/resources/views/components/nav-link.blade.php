<a href="{{ route('students.index') }}"
   class="block px-3 py-2 rounded {{ request()->routeIs('students.index') && !request('only_trashed') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
  Students
</a>
<a href="{{ route('students.index', ['only_trashed' => 1]) }}"
   class="block px-3 py-2 rounded {{ request('only_trashed') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
    Trash
</a>
<a href="{{ route('users.index') }}"
   class="block px-3 py-2 rounded {{ request()->routeIs('users.index') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50' }}">
  Users
</a>
