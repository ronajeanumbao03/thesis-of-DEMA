<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $isAdmin = Auth::user()->role === 'admin';

        if ($isAdmin) {
            $departments = Department::all();
            return view('departments.index', compact('departments', 'isAdmin'));
        }

        // If not admin, show one department
        $department = Department::first(); // Replace with logic to fetch user's department
        return view('departments.index', compact('department', 'isAdmin'));
    }

    // Show the form to create a department
    public function create()
    {
        return view('departments.create');  // Return the view for the create form
    }

    // Store a newly created department
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Check if department with same name already exists
        $exists = Department::where('name', $request->name)->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Department already exists.');
        }

        Department::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('departments.create')->with('success', 'Department created successfully.');
    }

    // Show the form for editing a department
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    // Update the department
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    // Delete a department
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

    // Show the budget of a specific department
    public function budget($departmentId)
    {
        $isAdmin = Auth::user()->role === 'admin';

        if ($isAdmin) {
            $departments = Department::all();
            return view('departments.index', compact('departments', 'isAdmin'));
        } else {
            $department = Department::findOrFail($departmentId);
            return view('departments.index', compact('department', 'isAdmin'));
        }
    }

    // Store a new budget for a department
    public function storeBudget(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'annual_budget' => 'required|numeric|min:0',
        ]);

        $department = Department::findOrFail($request->department_id);

        // Store the budget in the department
        $department->annual_budget = $request->annual_budget;
        $department->save();

        return redirect()->route('departments.index', $department->id)->with('success', 'Budget created successfully.');
    }

    // Show the form to create a budget for a department
    public function createBudget($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        return view('departments.create-budget', compact('department'));
    }

    // Show the form to edit budget
    public function editBudget($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        return view('departments.edit-budget', compact('department'));
    }

    // Update the budget in DB
    public function updateBudget(Request $request, $departmentId)
    {
        $request->validate([
            'annual_budget' => 'required|numeric|min:0',
        ]);

        $department = Department::findOrFail($departmentId);

        // Update the department's annual_budget field
        $department->annual_budget = $request->annual_budget;
        $department->save();

        // Check if a budget already exists
        $budget = Budget::where('department_id', $department->id)->first();

        if ($budget) {
            // Update existing budget
            $budget->total_amount = $request->annual_budget;
            $budget->remaining_amount = $budget->total_amount - $budget->spent_amount; // Keep spent amount
            $budget->save();
        } else {
            // Create a new budget record
            Budget::create([
                'department_id' => $department->id,
                'total_amount' => $request->annual_budget,
                'spent_amount' => 0,
                'remaining_amount' => $request->annual_budget,
                'amount' => $request->annual_budget, // ✅ Add this if 'amount' is required
            ]);

        }

        return redirect()->route('departments.index')->with('success', 'Budget updated successfully.');

    }

    // Show the form to assign a department head// DepartmentController.php
    public function showAssignHeadForm()
    {
        // Get IDs of users already assigned as heads
        $assignedHeadIds = Department::whereNotNull('department_head_id')
            ->pluck('department_head_id')
            ->toArray();

        // Only departments with no assigned head
        $departments = Department::whereNull('department_head_id')->get();

        // Only head users not yet assigned
        $users = User::where('role', 'head')
            ->whereNotIn('id', $assignedHeadIds)
            ->get();

        return view('departments.assign-head', compact('departments', 'users'));
    }

    // Store the assigned department head
    // DepartmentController.php
    public function storeHead(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $department = Department::find($request->department_id);
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }

        $department->department_head_id = $request->user_id;
        $department->save();

        return redirect()->back()->with('success', 'Department head assigned successfully.');
    }

    public function showAssignUserForm()
    {
        $departments = Department::all();

        // Only show users with role 'user' and no assigned department
        $users = User::where('role', 'user')
            ->whereNull('department_id')
            ->get();

        return view('departments.assign-user', compact('departments', 'users'));
    }

    public function storeUserAssignment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->department_id = $request->department_id;
        $user->save();

        return redirect()->back()->with('success', 'User assigned to department successfully.');
    }

    public function deleteBudget($id)
    {
        $department = Department::findOrFail($id);

        // Optional: manually delete related records if not using cascade
        if ($department->budget) {
            $department->budget()->delete();
        }

        $department->delete(); // Delete the department itself

        return redirect()->route('departments.index')->with('toast', [
            'type' => 'success',
            'message' => 'Department and its budget deleted successfully.',
        ]);
    }

}
