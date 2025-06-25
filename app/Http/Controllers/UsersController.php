<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query()->with('role');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('created_at', 'like', '%' . $search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'asc')->paginate(6);

        if ($request->ajax()) {
            return view('partials.user_tbody', compact('users'))->render();
        }

        $roles = Role::all();
        $clients = \App\Models\Client::all(); // ✅ Fetch all clients

        return view('users', compact('roles', 'users', 'clients')); // ✅ Pass to view
    }



    public function create(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|integer',
            'client_id' => 'nullable|exists:clients,id', // Validate client_id
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
            'client_id' => $request->client_id, // Save client
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully!',
            'user' => $user,
        ], 201);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully!',
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|integer',
            'client_id' => 'nullable|exists:clients,id',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'client_id' => $request->client_id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'User updated successfully']);
    }




}
