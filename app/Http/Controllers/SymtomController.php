<?php

namespace App\Http\Controllers;

use App\Models\Symtom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SymtomController extends Controller
{
    private function reformatCode(){
        $newCode = 'G001';
        $item = Symtom::latest()->first();
        if ($item) {
            $lastCode = (int) Str::after($item->code, 'G');
            $nextNumber = $lastCode + 1;
            if (Str::length($nextNumber) === 1) {
                $newCode = 'G00' . $nextNumber;
            }elseif (Str::length($nextNumber) === 2){
                $newCode = 'G0' . $nextNumber;
            }else{
                $newCode = 'G' . $nextNumber;
            }
        }
        return $newCode;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Symtom::all();
        return view('pages.gejala.index', [
            'title' => 'Gejala',
            'menu' => 'Gejala',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastCode = $this->reformatCode();
        return view('pages.gejala.create', [
            'title' => 'Gejala',
            'menu' => 'Gejala',
            'lastCode' => $lastCode,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $data['code'] = $this->reformatCode();

        Symtom::create($data);

        return redirect()->route('gejala.index')->with('success', 'Berhasil Ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('admin');
        $item = Symtom::find(decrypt($id));
        $lastCode = $this->reformatCode();
        return view('pages.gejala.edit', [
            'title' => 'Gejala',
            'menu' => 'Gejala',
            'item' => $item,
            'lastCode' => $lastCode,
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
        ]);
        $item = Symtom::find(decrypt($id));

        if (!$item->code) {
            $data['code'] = $this->reformatCode();
        }

        $item->update($data);

        return redirect()->route('gejala.index')->with('success', 'Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('admin');
        $item = Symtom::find(decrypt($id));
        $item->delete();
        return back()->with('success', 'Berhasil Dihapus');
    }
}
