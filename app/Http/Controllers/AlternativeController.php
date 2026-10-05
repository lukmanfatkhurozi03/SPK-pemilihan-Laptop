<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\AlternativeScore;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlternativeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:alternatives,code',
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:100',
            'spec_summary' => 'nullable|string',
            'price_raw' => 'nullable|numeric|min:0',
            'scores' => 'required|array',
            'scores.*' => 'required|numeric',
        ]);

        DB::transaction(function () use ($validated) {
            $alt = Alternative::create([
                'code' => strtoupper($validated['code']),
                'name' => $validated['name'],
                'brand' => $validated['brand'] ?? null,
                'spec_summary' => $validated['spec_summary'] ?? null,
                'price_raw' => $validated['price_raw'] ?? null,
                'order' => Alternative::max('order') + 1,
            ]);

            foreach ($validated['scores'] as $criteriaId => $scoreValue) {
                AlternativeScore::create([
                    'alternative_id' => $alt->id,
                    'criteria_id' => $criteriaId,
                    'score' => (float)$scoreValue,
                ]);
            }
        });

        return redirect()->route('spk.index', ['step' => 1])->with('success', "Alternatif Laptop '{$validated['name']}' ({$validated['code']}) berhasil ditambahkan!");
    }

    public function update(Request $request, Alternative $alternative)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:alternatives,code,' . $alternative->id,
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:100',
            'spec_summary' => 'nullable|string',
            'price_raw' => 'nullable|numeric|min:0',
            'scores' => 'required|array',
            'scores.*' => 'required|numeric',
        ]);

        DB::transaction(function () use ($validated, $alternative) {
            $alternative->update([
                'code' => strtoupper($validated['code']),
                'name' => $validated['name'],
                'brand' => $validated['brand'] ?? null,
                'spec_summary' => $validated['spec_summary'] ?? null,
                'price_raw' => $validated['price_raw'] ?? null,
            ]);

            foreach ($validated['scores'] as $criteriaId => $scoreValue) {
                AlternativeScore::updateOrCreate(
                    [
                        'alternative_id' => $alternative->id,
                        'criteria_id' => $criteriaId,
                    ],
                    [
                        'score' => (float)$scoreValue,
                    ]
                );
            }
        });

        return redirect()->route('spk.index', ['step' => 1])->with('success', "Data Alternatif '{$alternative->name}' berhasil diperbarui!");
    }

    public function destroy(Alternative $alternative)
    {
        $name = $alternative->name;
        $code = $alternative->code;
        $alternative->delete();

        return redirect()->route('spk.index', ['step' => 1])->with('success', "Alternatif {$code} - {$name} berhasil dihapus!");
    }

    public function quickScore(Request $request)
    {
        $validated = $request->validate([
            'alternative_id' => 'required|exists:alternatives,id',
            'criteria_id' => 'required|exists:criterias,id',
            'score' => 'required|numeric',
        ]);

        $score = AlternativeScore::updateOrCreate(
            [
                'alternative_id' => $validated['alternative_id'],
                'criteria_id' => $validated['criteria_id'],
            ],
            [
                'score' => (float)$validated['score'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil diperbarui.',
            'score' => $score->score,
        ]);
    }
}
