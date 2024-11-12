<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Symtom;
use Illuminate\Http\Request;

class DemsterRuleController extends Controller
{
    // Fungsi untuk menggabungkan dua keyakinan menggunakan aturan Dempster-Shafer
    private function combineEvidence($mass1, $mass2) {
        $combinedMass = [];
        $conflict = 0;

        // Iterasi dan gabungkan keyakinan dari kedua massa
        foreach ($mass1 as $hyp1 => $m1) {
            foreach ($mass2 as $hyp2 => $m2) {
                // Jika kedua hipotesis sama, gabungkan
                if ($hyp1 == $hyp2) {
                    if (!isset($combinedMass[$hyp1])) {
                        $combinedMass[$hyp1] = 0;
                    }
                    $combinedMass[$hyp1] += $m1 * $m2;
                } else {
                    // Jika ada konflik, tambahkan ke nilai konflik
                    $conflict += $m1 * $m2;
                }
            }
        }

        // Menghitung total massa setelah konflik
        $totalMass = 1 - $conflict;

        // Jika total massa <= 0, artinya ada konflik besar, kembalikan keyakinan pada "Tidak Tahu"
        if ($totalMass <= 0) {
            // Jika tidak ada konsensus yang cukup, kembalikan keyakinan penuh kepada "Tidak Tahu"
            return ['Tidak Tahu' => 1];
        }

        // Normalisasi hasil gabungan (untuk memastikan bahwa jumlah massa keyakinan = 1)
        foreach ($combinedMass as $hyp => $mass) {
            $combinedMass[$hyp] = $mass / $totalMass;
        }

        // Menambahkan massa keyakinan untuk "Tidak Tahu" jika ada konflik
        if ($conflict > 0) {
            $combinedMass['Tidak Tahu'] = $conflict / $totalMass;
        }

        return $combinedMass;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Symtom::all();
        $gejalas = Symtom::all();
        $penyakits = Disease::all();
        return view('pages.demster-rule.index', [
            'title' => 'Demster Rule',
            'menu' => 'Demster Rule',
            'data' => $data,
            'gejalas' => $gejalas,
            'penyakits' => $penyakits,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('admin');
        $request->validate([
            'disease_id' => 'required|exists:diseases,id',
            'symtom_id' => 'required|array',
        ]);

        $item = Disease::find($request->disease_id);
        $item->symtoms()->sync($request->symtom_id);

        return back()->with('success', 'Berhasil Ditambahkan');
    }
}
