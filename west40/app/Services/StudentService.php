<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentService
{
    public function paginateWithSearch(
        ?string $q = null,
        bool $withTrashed = false,
        bool $onlyTrashed = false,    
        int $perPage = 10,
        string $sort = 'id',
        string $dir = 'desc',
    ): LengthAwarePaginator {
        $query = Student::query();

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($onlyTrashed) {
            $query->onlyTrashed();      // ← just deleted rows
        } elseif ($withTrashed) {
            $query->withTrashed();      // ← include deleted + non-deleted
        }

        // Whitelist sortable columns
        $allowed = ['id', 'name', 'email', 'dob', 'created_at'];
        $sort = in_array($sort, $allowed, true) ? $sort : 'id';
        $dir  = strtolower($dir) === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sort, $dir)
            ->paginate($perPage)
            ->withQueryString(); // keep current query params on pagination links
    }
}
