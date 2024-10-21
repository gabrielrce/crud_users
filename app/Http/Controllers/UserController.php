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
            'success' => 'Usuario creado con éxito.',
            'users' => $users->items(),
            'links' => $users->links()->toHtml(),
        ]);
  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'lastname2' => 'required',
            'business_name' => 'nullable',
            'person_type' => 'required|in:fisica,moral',
            'curp' => 'nullable|required_if:person_type,fisica',
        ]);
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'lastname2' => 'required',
            'person_type' => 'required|in:fisica,moral',
        ]);
    
        $user->update($validatedData);
    
        $users = User::paginate(5);

        return response()->json([
            'success' => 'Usuario actualizado con éxito',
            'users' => $users->items(),
            'links' => $users->links()->toHtml(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }
    
        try {
            $user->delete();
    
            $users = User::paginate(5);

            return response()->json([
                'success' => 'Usuario eliminado con éxito.',
                'users' => $users->items(),
                'links' => $users->links()->toHtml(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al eliminar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }  
}
