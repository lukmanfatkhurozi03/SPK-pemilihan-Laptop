<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Services\SawCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SpkController extends Controller
{
    protected SawCalculationService $sawService;

    public function __construct(SawCalculationService $sawService)
    {
        $this->sawService = $sawService;
    }

    public function index(Request $request)
    {
        $currentStep = (int)$request->query('step', 1);
        if ($currentStep < 1 || $currentStep > 3) {
            $currentStep = 1;
        }

        $criterias = Criteria::with('scales')->orderBy('order')->orderBy('code')->get();
        $alternatives = Alternative::with('scores')->orderBy('order')->orderBy('code')->get();
        $sawData = $this->sawService->calculate();

        return view('spk.index', compact('currentStep', 'criterias', 'alternatives', 'sawData'));
    }

    public function apiCalculate(Request $request)
    {
        $customWeights = $request->input('weights', []);
        $sawData = $this->sawService->calculate(!empty($customWeights) ? $customWeights : null);

        return response()->json([
            'success' => true,
            'data' => $sawData,
        ]);
    }

    public function updateWeights(Request $request)
    {
        $weights = $request->input('weights', []);
        $totalWeight = array_sum($weights);

        // Validation for total weights
        // Accept either scale of 1.0 (approx 0.99 - 1.01) or 100% (approx 99 - 101%)
        $isValid = abs($totalWeight - 1.0) < 0.01 || abs($totalWeight - 100.0) < 1.0;

        if (!$isValid && !$request->has('force')) {
            return redirect()->back()->with('error', "Total bobot harus bernilai 1.0 (atau 100%). Total saat ini: {$totalWeight}. Gunakan fitur Normalisasi Otomatis jika ingin meratakan bobot.");
        }

        DB::transaction(function () use ($weights, $totalWeight) {
            foreach ($weights as $criteriaId => $weightVal) {
                // If entered as percentage (> 1.5), convert to decimal 0.xx
                $val = (float)$weightVal;
                if ($totalWeight > 1.5) {
                    $val = $val / 100.0;
                }
                Criteria::where('id', $criteriaId)->update(['weight' => $val]);
            }
        });

        return redirect()->route('spk.index', ['step' => 2])->with('success', 'Bobot kriteria berhasil disimpan dan diperbarui!');
    }

    public function autoNormalizeWeights()
    {
        $criterias = Criteria::all();
        $totalWeight = $criterias->sum('weight');

        if ($criterias->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada kriteria yang terdaftar.');
        }

        if ($totalWeight <= 0) {
            // Equal distribution
            $evenWeight = round(1.0 / $criterias->count(), 4);
            foreach ($criterias as $crit) {
                $crit->update(['weight' => $evenWeight]);
            }
        } else {
            foreach ($criterias as $crit) {
                $normalized = round($crit->weight / $totalWeight, 4);
                $crit->update(['weight' => $normalized]);
            }
        }

        return redirect()->route('spk.index', ['step' => 2])->with('success', 'Bobot seluruh kriteria berhasil dinormalisasi otomatis menjadi total 1.0 (100%)!');
    }

    public function resetDefault()
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);
            return redirect()->route('spk.index', ['step' => 1])->with('success', 'Data berhasil direset kembali ke Dataset Default Makalah (C1-C5 & A1-A7)!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mereset data: ' . $e->getMessage());
        }
    }

    public function printReport()
    {
        $criterias = Criteria::with('scales')->orderBy('order')->orderBy('code')->get();
        $alternatives = Alternative::with('scores')->orderBy('order')->orderBy('code')->get();
        $sawData = $this->sawService->calculate();

        return view('spk.print', compact('criterias', 'alternatives', 'sawData'));
    }
}
