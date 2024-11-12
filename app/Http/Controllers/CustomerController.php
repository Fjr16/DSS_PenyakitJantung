<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Symtom;
use Illuminate\Http\Request;

class BeliefMass {
    public $values;

    public function __construct(array $values) {
        $this->values = $values;
    }
}

class DempsterShafer {
    public function combine(BeliefMass ...$masses) {
        $combinedMass = [];
        $totalConflict = 0;

        // Iterasi melalui semua pasangan massa
        foreach ($masses as $index1 => $mass1) {
            foreach ($masses as $index2 => $mass2) {
                if ($index1 === $index2) {
                    continue; // Skip jika membandingkan massa yang sama
                }

                // Gabungkan setiap pasangan hipotesis
                foreach ($mass1->values as $hyp1 => $m1) {
                    foreach ($mass2->values as $hyp2 => $m2) {
                        if ($hyp1 === $hyp2) {
                            $combinedMass[$hyp1] = ($combinedMass[$hyp1] ?? 0) + ($m1 * $m2);
                        } else {
                            $totalConflict += $m1 * $m2;
                        }
                    }
                }
            }
        }

        // Normalisasi
        $totalBelief = 1 - $totalConflict;
        if ($totalBelief <= 0) {
            return new BeliefMass(['Tidak Tahu' => 1]);
        }

        foreach ($combinedMass as $hyp => $mass) {
            $combinedMass[$hyp] = $mass / $totalBelief;
        }

        // Tambahkan keyakinan "Tidak Tahu" jika ada konflik
        if ($totalConflict > 0) {
            $combinedMass['Tidak Tahu'] = $totalConflict / $totalBelief;
        }

        return new BeliefMass($combinedMass);
    }
}

class CustomerController extends Controller
{
    public function combineBeliefs(Request $request) {
        // Contoh penggunaan
        $belief1 = new BeliefMass(['Jantung Koroner' => 0.8, 'Gagal Jantung' => 0.1, 'Aritmia' => 0.1]);
        $belief2 = new BeliefMass(['Jantung Koroner' => 0.7, 'Gagal Jantung' => 0.2, 'Aritmia' => 0.1]);
        $belief3 = new BeliefMass(['Jantung Koroner' => 0.9, 'Gagal Jantung' => 0.05, 'Aritmia' => 0.05]);
        
        $ds = new DempsterShafer;
        $combinedBelief = $ds->combine($belief1, $belief2, $belief3);
        
        dd($combinedBelief->values);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.custumer-page.home.index', [
            'title' => 'Home',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Symtom::all();
        return view('pages.custumer-page.diagnosa.create', [
            'title' => 'Diagnosa',
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $symtomIds = $data['symtom_id'];

        $dataBeliefValues = [];
    
        foreach ($symtomIds as $index => $symtomId) {
            $item = Symtom::find($symtomId);
            $diseaseCodes = implode(',', $item->diseases->pluck('code')->toArray());
            $dataBeliefValues[$item->name] = [
                $diseaseCodes => $item->bobot,
                'theta' => 1 - $item->bobot,
            ];
        }

        $m1 = null;
        $result = [];
        foreach ($dataBeliefValues as $key => $belief) {
            if ($m1 == null) {
                $m1 = $belief;
            }else{
                $m1 = $this->combineEvidence($m1, $belief);
                $result[] = $m1;
            }
        }
        $hasilAkhir = $m1;
        $maxValue = max($hasilAkhir);
        $maxKey = array_search($maxValue, $hasilAkhir);

        $hasilDiagnosa = Disease::where('code', $maxKey)->first();

        $dataPasien = $request->except(['symtom_id', '_token']);
        $dataGejala = [];
        foreach ($data['symtom_id'] as $key => $symId) {
            $dataGejala[] = Symtom::find($symId);
        }

        $data = Symtom::all();
        return view('pages.custumer-page.diagnosa.create', [
            'title' => 'Diagnosa',
            'showModal' => true,
            'maxKey' => $maxKey,
            'maxValue' => $maxValue,
            'hasilDiagnosa' => $hasilDiagnosa,
            'dataPasien' => $dataPasien,
            'dataGejala' => $dataGejala,
            'data' => $data,
        ]);
    }

    private function intersect($hyp1, $hyp2) {
        $hyp1Array = explode(',', $hyp1);
        $hyp2Array = explode(',', $hyp2);
        $intersection = array_intersect($hyp1Array, $hyp2Array);
        return empty($intersection) ? null : implode(',', $intersection);
    }

    private function combineEvidence($mass1, $mass2) {
        $combinedMass = [];
        $conflict = 0;

        foreach ($mass1 as $hyp1 => $m1) {
            foreach ($mass2 as $hyp2 => $m2) {

                if ($hyp1 == 'theta' || $hyp2 == 'theta') {
                    $resultHypothesis = ($hyp1 == 'theta' ? $hyp2 : $hyp1);
                    if (!isset($combinedMass[$resultHypothesis])) {
                        $combinedMass[$resultHypothesis] = 0;
                    }
                    $combinedMass[$resultHypothesis] += $m1 * $m2;
                } else {
                    $intersection = $this->intersect($hyp1, $hyp2);
                    if ($intersection) {
                        if (!isset($combinedMass[$intersection])) {
                            $combinedMass[$intersection] = 0;
                        }
                        $combinedMass[$intersection] += $m1 * $m2;
                    } else {
                        $conflict += $m1 * $m2;
                    }
                }

            }
        }


        $totalMass = 1 - $conflict;
        if ($totalMass <= 0) {
            return ['Tidak Tahu' => 1];
        }

        foreach ($combinedMass as $hyp => $mass) {
            $combinedMass[$hyp] = $mass / $totalMass;
        }
        
        if ($conflict > 0) {
            $combinedMass['Tidak Tahu'] = $conflict / $totalMass;
        }

        return $combinedMass;
    }
}
