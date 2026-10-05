<?php

namespace App\Services;

use App\Models\Alternative;
use App\Models\Criteria;
use Illuminate\Support\Collection;

class SawCalculationService
{
    /**
     * Calculate SAW ranking and return step-by-step matrices and metadata.
     *
     * @param array|null $customWeights Optional array of [criteria_id => weight] for transient simulation
     * @return array
     */
    public function calculate(?array $customWeights = null): array
    {
        $criterias = Criteria::with('scales')->orderBy('order')->orderBy('code')->get();
        $alternatives = Alternative::with('scores')->orderBy('order')->orderBy('code')->get();

        if ($criterias->isEmpty() || $alternatives->isEmpty()) {
            return [
                'has_data' => false,
                'criterias' => $criterias,
                'alternatives' => $alternatives,
                'total_weight' => 0,
                'is_weight_valid' => false,
                'matrix_x' => [],
                'extremes' => [],
                'matrix_r' => [],
                'matrix_weighted' => [],
                'results' => [],
                'winner' => null,
            ];
        }

        // Apply custom weights if provided
        $effectiveWeights = [];
        $totalWeight = 0;
        foreach ($criterias as $crit) {
            $w = ($customWeights && isset($customWeights[$crit->id]))
                ? (float)$customWeights[$crit->id]
                : (float)$crit->weight;
            $effectiveWeights[$crit->id] = $w;
            $totalWeight += $w;
        }

        // Allow tolerance for float rounding (0.999 to 1.001)
        $isWeightValid = abs($totalWeight - 1.0) < 0.005 || abs($totalWeight - 100.0) < 0.5;

        // 1. Matriks Keputusan (X)
        $matrixX = [];
        $criteriaValues = [];

        foreach ($criterias as $crit) {
            $criteriaValues[$crit->id] = [];
        }

        foreach ($alternatives as $alt) {
            $row = [
                'alternative' => $alt,
                'scores' => [],
            ];
            foreach ($criterias as $crit) {
                $scoreObj = $alt->scores->firstWhere('criteria_id', $crit->id);
                $val = $scoreObj ? (float)$scoreObj->score : 0.0;
                $row['scores'][$crit->id] = $val;
                $criteriaValues[$crit->id][] = $val;
            }
            $matrixX[$alt->id] = $row;
        }

        // 2. Nilai Ekstrem (Max / Min) per Kriteria
        $extremes = [];
        foreach ($criterias as $crit) {
            $vals = $criteriaValues[$crit->id];
            $minVal = !empty($vals) ? min($vals) : 0;
            $maxVal = !empty($vals) ? max($vals) : 0;

            $extremes[$crit->id] = [
                'min' => $minVal,
                'max' => $maxVal,
                'is_benefit' => $crit->isBenefit(),
                'target_extreme' => $crit->isBenefit() ? $maxVal : $minVal,
            ];
        }

        // 3. Matriks Ternormalisasi (R) & Matriks Terbobot
        $matrixR = [];
        $matrixWeighted = [];
        $scoresSummary = [];

        foreach ($alternatives as $alt) {
            $altId = $alt->id;
            $rowR = [
                'alternative' => $alt,
                'r' => [],
                'formulas' => [],
            ];
            $rowWeighted = [
                'alternative' => $alt,
                'w_r' => [],
            ];

            $preferenceScore = 0.0;
            $criteriaBreakdown = [];

            foreach ($criterias as $crit) {
                $critId = $crit->id;
                $x = $matrixX[$altId]['scores'][$critId] ?? 0.0;
                $w = $effectiveWeights[$critId] ?? 0.0;
                // If weights entered as 0-100%, normalize to decimal 0-1
                $wDecimal = $totalWeight > 1.5 ? ($w / 100.0) : $w;

                $target = $extremes[$critId]['target_extreme'];
                $r = 0.0;
                $formula = '';

                if ($crit->isBenefit()) {
                    if ($target > 0) {
                        $r = $x / $target;
                        $formula = "{$x} / {$target} = " . round($r, 4);
                    } else {
                        $r = 0;
                        $formula = "{$x} / 0 = 0";
                    }
                } else {
                    // Cost criteria
                    if ($x > 0) {
                        $r = $target / $x;
                        $formula = "{$target} / {$x} = " . round($r, 4);
                    } else {
                        $r = 0;
                        $formula = "{$target} / 0 = 0";
                    }
                }

                $weightedVal = $r * $wDecimal;
                $preferenceScore += $weightedVal;

                $rowR['r'][$critId] = $r;
                $rowR['formulas'][$critId] = $formula;

                $rowWeighted['w_r'][$critId] = $weightedVal;

                $criteriaBreakdown[$critId] = [
                    'criteria_code' => $crit->code,
                    'criteria_name' => $crit->name,
                    'attribute' => $crit->attribute,
                    'raw_x' => $x,
                    'r' => $r,
                    'weight' => $w,
                    'weight_decimal' => $wDecimal,
                    'weighted_score' => $weightedVal,
                    'formula' => $formula,
                ];
            }

            $matrixR[$altId] = $rowR;
            $matrixWeighted[$altId] = $rowWeighted;

            $scoresSummary[$altId] = [
                'alternative' => $alt,
                'preference_score' => $preferenceScore,
                'preference_formatted' => number_format($preferenceScore, 4),
                'percentage' => round($preferenceScore * 100, 2),
                'breakdown' => $criteriaBreakdown,
            ];
        }

        // 4. Perangkingan
        uasort($scoresSummary, function ($a, $b) {
            return $b['preference_score'] <=> $a['preference_score'];
        });

        $rankedResults = [];
        $rank = 1;
        $winner = null;

        foreach ($scoresSummary as $altId => $item) {
            $item['rank'] = $rank;
            $item['is_winner'] = ($rank === 1);
            if ($rank === 1) {
                $winner = $item;
            }
            $rankedResults[] = $item;
            $rank++;
        }

        return [
            'has_data' => true,
            'criterias' => $criterias,
            'alternatives' => $alternatives,
            'effective_weights' => $effectiveWeights,
            'total_weight' => $totalWeight,
            'is_weight_valid' => $isWeightValid,
            'matrix_x' => $matrixX,
            'extremes' => $extremes,
            'matrix_r' => $matrixR,
            'matrix_weighted' => $matrixWeighted,
            'results' => $rankedResults,
            'winner' => $winner,
        ];
    }
}
