<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::when($request->search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                         ->orWhere('lastname', 'like', '%' . $search . '%');
        })->paginate(5);
    
        if ($request->ajax()) {
            return response()->json([
                'users' => view('partials.user-list', compact('users'))->render(),
                'links' => (string) $users->links(),
            ]);
        }
    
        return view('users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'lastname2' => 'required',
            'person_type' => 'required|in:fisica,moral',
        ]);
    
        User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'lastname2' => $request->lastname2,
            'business_name' => $request->business_name,
            'person_type' => $request->person_type,
            'curp' => $request->curp,
        ]);
    
        $users = User::paginate(5);

        return response()->json([
            'success' => 'User created successfully.',
            'users' => $users->items(),
            'links' => $users->links()->toHtml(),
        ]);
  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
