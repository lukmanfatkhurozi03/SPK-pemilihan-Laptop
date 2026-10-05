<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\AlternativeScore;
use App\Models\Criteria;
use App\Models\CriteriaScale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriteriaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:criterias,code',
            'name' => 'required|string|max:255',
            'attribute' => 'required|in:benefit,cost',
            'weight' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $criteria = Criteria::create([
                'code' => strtoupper($validated['code']),
                'name' => $validated['name'],
                'attribute' => $validated['attribute'],
                'weight' => (float)$validated['weight'],
                'unit' => $validated['unit'] ?? null,
                'description' => $validated['description'] ?? null,
                'order' => Criteria::max('order') + 1,
            ]);

            // Initialize default score for all existing alternatives
            $alternatives = Alternative::all();
            foreach ($alternatives as $alt) {
                AlternativeScore::firstOrCreate(
                    [
                        'alternative_id' => $alt->id,
                        'criteria_id' => $criteria->id,
                    ],
                    [
                        'score' => 1.0,
                    ]
                );
            }

            // If scales passed
            if ($request->has('scales') && is_array($request->input('scales'))) {
                foreach ($request->input('scales') as $scaleData) {
                    if (!empty($scaleData['label']) && isset($scaleData['value'])) {
                        CriteriaScale::create([
                            'criteria_id' => $criteria->id,
                            'label' => $scaleData['label'],
                            'value' => (float)$scaleData['value'],
                            'description' => $scaleData['description'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('spk.index', ['step' => 1])->with('success', "Kriteria '{$validated['name']}' ({$validated['code']}) berhasil ditambahkan!");
    }

    public function update(Request $request, Criteria $criteria)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:criterias,code,' . $criteria->id,
            'name' => 'required|string|max:255',
            'attribute' => 'required|in:benefit,cost',
            'weight' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $criteria->update([
            'code' => strtoupper($validated['code']),
            'name' => $validated['name'],
            'attribute' => $validated['attribute'],
            'weight' => (float)$validated['weight'],
            'unit' => $validated['unit'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        if ($request->has('scales') && is_array($request->input('scales'))) {
            $criteria->scales()->delete();
            foreach ($request->input('scales') as $scaleData) {
                if (!empty($scaleData['label']) && isset($scaleData['value']) && $scaleData['value'] !== '') {
                    $criteria->scales()->create([
                        'label' => trim($scaleData['label']),
                        'value' => (float)$scaleData['value'],
                        'description' => !empty($scaleData['description']) ? trim($scaleData['description']) : null,
                    ]);
                }
            }
        }

        $step = $request->input('redirect_step', 1);
        return redirect()->route('spk.index', ['step' => $step])->with('success', "Kriteria '{$criteria->name}' ({$criteria->code}) berhasil diperbarui!");
    }

    public function destroy(Criteria $criteria)
    {
        $name = $criteria->name;
        $code = $criteria->code;
        $criteria->delete();

        return redirect()->route('spk.index', ['step' => 1])->with('success', "Kriteria {$code} - {$name} berhasil dihapus!");
    }

    public function addScale(Request $request, Criteria $criteria)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $criteria->scales()->create($validated);

        return redirect()->route('spk.index', ['step' => 1])->with('success', "Tingkat sub-kriteria baru untuk {$criteria->code} berhasil ditambahkan!");
    }

    public function updateScale(Request $request, CriteriaScale $scale)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $scale->update($validated);

        return redirect()->route('spk.index', ['step' => 1])->with('success', 'Tingkat sub-kriteria berhasil diperbarui!');
    }

    public function batchUpdateScales(Request $request, Criteria $criteria)
    {
        $scalesData = $request->input('scales', []);

        DB::transaction(function () use ($criteria, $scalesData) {
            // Delete all existing scales for this criteria and re-create from form input
            $criteria->scales()->delete();

            foreach ($scalesData as $item) {
                if (!empty($item['label']) && isset($item['value']) && $item['value'] !== '') {
                    $criteria->scales()->create([
                        'label' => trim($item['label']),
                        'value' => (float)$item['value'],
                        'description' => !empty($item['description']) ? trim($item['description']) : null,
                    ]);
                }
            }
        });

        $step = $request->input('redirect_step', 1);
        return redirect()->route('spk.index', ['step' => $step])->with('success', "Seluruh skala penilaian untuk kriteria {$criteria->code} ({$criteria->name}) berhasil diperbarui!");
    }

    public function resetCriteriaScales(Criteria $criteria)
    {
        DB::transaction(function () use ($criteria) {
            $criteria->scales()->delete();
            if ($criteria->isCost()) {
                $defaults = [
                    ['value' => 1, 'label' => 'Sangat Murah / Sangat Ringan (Paling Menguntungkan)', 'description' => 'Tingkat paling ideal untuk kriteria Cost'],
                    ['value' => 2, 'label' => 'Murah / Ringan', 'description' => 'Tingkat baik'],
                    ['value' => 3, 'label' => 'Sedang / Menengah', 'description' => 'Tingkat standar'],
                    ['value' => 4, 'label' => 'Mahal / Berat', 'description' => 'Tingkat kurang ideal'],
                    ['value' => 5, 'label' => 'Sangat Mahal / Sangat Berat', 'description' => 'Tingkat paling memberatkan'],
                ];
            } else {
                $defaults = [
                    ['value' => 5, 'label' => 'Sangat Tinggi / Maksimal (Paling Menguntungkan)', 'description' => 'Performa atau spesifikasi tertinggi'],
                    ['value' => 4, 'label' => 'Tinggi / Unggul', 'description' => 'Performa di atas standar'],
                    ['value' => 3, 'label' => 'Sedang / Cukup', 'description' => 'Performa memadai standar harian'],
                    ['value' => 2, 'label' => 'Rendah / Minimal', 'description' => 'Performa dasar'],
                    ['value' => 1, 'label' => 'Sangat Rendah', 'description' => 'Performa entry level / terbatas'],
                ];
            }
            foreach ($defaults as $d) {
                $criteria->scales()->create($d);
            }
        });

        return redirect()->route('spk.index', ['step' => 1])->with('success', "Skala penilaian kriteria {$criteria->code} ({$criteria->name}) berhasil direset ke standar 5 tingkat!");
    }

    public function deleteScale(CriteriaScale $scale)
    {
        $critCode = $scale->criteria->code ?? '';
        $scale->delete();
        return redirect()->route('spk.index', ['step' => 1])->with('success', "Sub-kriteria untuk {$critCode} berhasil dihapus!");
    }
}
