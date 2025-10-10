<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treasurer;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\get;


class TreasurerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $treasurers = Treasurer::with('section', 'user')->get();
        return view('treasurers.index', compact('treasurers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        $users = DB::table('users')
           ->whereNotIn('id', function($query) {
               $query->select('user_id')->from('treasurers');
           })->where('role', '!=', 'admin')
           ->get();

        return view('treasurers.create', compact('sections', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'section_assigned' => 'required|exists:sections,section_id',
        ]);

        Treasurer::create($request->all());
        return redirect()->route('treasurers.index')->with('success', 'Treasurer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treasurer $treasurer, User $user)
    {
        $sections = Section::all();
        return view('treasurers.edit', compact('treasurer', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'section_assigned' => 'required|exists:sections,section_id',
        ]);

        $treasurer = Treasurer::findOrFail($id);
        $treasurer->update($request->all());
        return redirect()->route('treasurers.index')->with('success', 'Treasurer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treasurer $treasurer)
    {
        $treasurer->delete();
        return redirect()->route('treasurers.index')->with('success', 'Treasurer deleted successfully');
    }
}
