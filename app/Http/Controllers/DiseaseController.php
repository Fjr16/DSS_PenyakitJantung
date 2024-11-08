<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{

    private function reformatCode(){
        $newCode = 'P001';
        $item = Disease::latest()->first();
        if ($item) {
            $lastCode = (int) Str::after($item->code, 'P');
            $nextNumber = $lastCode + 1;
            if (Str::length($nextNumber) === 1) {
                $newCode = 'P00' . $nextNumber;
            }elseif (Str::length($nextNumber) === 2){
                $newCode = 'P0' . $nextNumber;
            }else{
                $newCode = 'P' . $nextNumber;
            }
        }
        return $newCode;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Disease::all();
        return view('pages.penyakit.index', [
            'title' => 'Penyakit',
            'menu' => 'Penyakit',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastCode = $this->reformatCode();
        return view('pages.penyakit.create', [
            'title' => 'Penyakit',
            'menu' => 'Penyakit',
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
            'description' => 'required|string',
        ]);
        $data['code'] = $this->reformatCode();

        Disease::create($data);

        return redirect()->route('penyakit.index')->with('success', 'Berhasil Ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('admin');
        $item = Disease::find(decrypt($id));
        $lastCode = $this->reformatCode();
        return view('pages.penyakit.edit', [
            'title' => 'Penyakit',
            'menu' => 'Penyakit',
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
            'description' => 'required|string',
        ]);
        $item = Disease::find(decrypt($id));

        if (!$item->code) {
            $data['code'] = $this->reformatCode();
        }

        $item->update($data);

        return redirect()->route('penyakit.index')->with('success', 'Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('admin');
        $item = Disease::find(decrypt($id));
        $item->delete();
        return back()->with('success', 'Berhasil Dihapus');
    }
}
