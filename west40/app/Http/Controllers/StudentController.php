<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class StudentController extends Controller {

    public function __construct(private StudentService $students) {
        
    }

    public function index(Request $request): View {
        $q            = $request->string('q')->toString();
        $onlyTrashed  = $request->boolean('only_trashed');
        $withTrashed  = $request->boolean('with_trashed');
        $sort = $request->get('sort', 'id');
        $dir  = $request->get('dir',  'desc');

        $items = $this->students->paginateWithSearch($q, $withTrashed, $onlyTrashed, 10, $sort, $dir);

        return view('students.index', compact('items', 'q', 'withTrashed', 'onlyTrashed'));
    }

    public function create(): View {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:students,email'],
            'dob'   => ['required','date'],
        ]);

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student created.');
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:255'],
            'email' => [
                'required','email','max:255',
                Rule::unique('students','email')->ignore($student->id),
                // If you want uniqueness only among *non-trashed* rows:
                // Rule::unique('students','email')->ignore($student->id)->whereNull('deleted_at'),
            ],
            'dob'   => ['required','date'],
        ]);

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated.');
    }

    public function edit(Student $student): View {
        return view('students.edit', compact('student'));
    }

    public function destroy(Student $student): RedirectResponse {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student moved to trash.');
    }

    public function restore(int $id): RedirectResponse {
        $student = Student::onlyTrashed()->findOrFail($id);
        $student->restore();
        return redirect()->route('students.index', ['with_trashed' => 1])
                        ->with('success', 'Student restored.');
    }

    public function delete(int $id): RedirectResponse {
        $student = Student::withTrashed()->findOrFail($id);
        $student->forceDelete();
        return redirect()->route('students.index')
                        ->with('success', 'Student permanently deleted.');
    }
}
