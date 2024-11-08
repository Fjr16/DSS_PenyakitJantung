<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('admin');
        $data = User::all();
        return view('pages.user.index', [
            'title' => 'User',
            'menu' => 'User',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('admin');
        return view('pages.user.create', [
            'title' => 'User',
            'menu' => 'User',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('admin');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => ['required', Password::defaults()],
            'level' => 'required|in:admin,dokter',
        ]);

        User::create($data);

        return redirect()->route('user.index')->with('success', 'Berhasil ditambahkan');
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
    public function edit(string $id)
    {
        $this->authorize('admin');
        $item = User::find(decrypt($id));
        return view('pages.user.edit', [
            'title' => 'User',
            'menu' => 'User',
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('admin');
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'level' => 'required|in:admin,dokter',
        ]);
        
        if ($request->password != null) {
            $request->validate([
                'password' => 'required|min:8'
            ]);
            $data['password'] = Hash::make($request->password);
        }
        $item = User::find(decrypt($id));
        $item->update($data);
        
        return redirect()->route('user.index')->with('success', 'Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('admin');
        $item = User::find(decrypt($id));
        $item->delete();

        return back()->with('success', 'Berhasil Dihapus');
    }
}
