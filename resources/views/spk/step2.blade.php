<div class="space-y-6" x-data="step2WeightsHandler()">

    <!-- Weight Management Section Card (AgentUI: Strict Borders & Hard Shadows) -->
    <div class="neo-box bg-white overflow-hidden mb-6">
        <div class="px-6 py-4 border-b-2 border-black bg-yellow-300 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-sm sm:text-base font-black text-black uppercase tracking-tight">Pengaturan Bobot Kriteria & Validasi Total (100% / 1.0)</h3>
                <p class="text-xs font-bold text-slate-800">Sesuaikan bobot kepentingan tiap kriteria. Total seluruh bobot wajib berjumlah 100% (1.0) untuk SAW.</p>
            </div>
            
            <!-- Live Total Weight Badge -->
            <div class="flex items-center space-x-2">
                <div class="px-3.5 py-1.5 border-2 border-black flex items-center space-x-2 transition-all shadow-[2px_2px_0px_0px_#000]"
                    :class="isTotalValid 
                        ? 'bg-lime-300 text-black' 
                        : 'bg-amber-300 text-black animate-pulse'">
                    <i :data-lucide="isTotalValid ? 'check-circle-2' : 'alert-triangle'" class="w-4 h-4 stroke-[2.5]"></i>
                    <span class="text-xs font-black uppercase">Total:</span>
                    <span class="text-sm font-black" x-text="totalWeightPercentage + '% (' + totalWeightDecimal.toFixed(2) + ')'"></span>
                </div>
            </div>
        </div>

        <form action="{{ route('spk.weights.update') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($criterias as $crit)
                    <div class="p-4 border-2 border-black bg-slate-50 shadow-[3px_3px_0px_0px_#000] space-y-3">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="neo-badge bg-black text-yellow-300 text-xs">
                                        {{ $crit->code }}
                                    </span>
                                    <h4 class="font-black text-black text-sm">{{ $crit->name }}</h4>
                                </div>
                                <div class="mt-1 flex items-center space-x-2">
                                    @if($crit->isBenefit())
                                        <span class="neo-badge bg-lime-300 text-black text-[10px]">
                                            Benefit (Maksimal)
                                        </span>
                                    @else
                                        <span class="neo-badge bg-amber-300 text-black text-[10px]">
                                            Cost (Minimal)
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Weight Percent Badge -->
                            <div class="text-right">
                                <span class="text-lg font-black text-black" x-text="weights[{{ $crit->id }}] + '%'"></span>
                                <div class="text-[11px] text-slate-600 font-mono font-bold" x-text="'W = ' + (weights[{{ $crit->id }}] / 100).toFixed(2)"></div>
                            </div>
                        </div>

                        <!-- Slider Control -->
                        <div class="space-y-1.5 pt-1">
                            <input type="range" min="0" max="100" step="1" 
                                x-model.number="weights[{{ $crit->id }}]"
                                @input="recalculateTotal()"
                                class="w-full h-2.5 bg-slate-200 border border-black appearance-none cursor-pointer">
                            <div class="flex justify-between text-[10px] text-slate-600 font-black">
                                <span>0%</span>
                                <span>50%</span>
                                <span>100%</span>
                            </div>
                        </div>

                        <!-- Hidden input to submit decimal to server -->
                        <input type="hidden" name="weights[{{ $crit->id }}]" :value="(weights[{{ $crit->id }}] / 100).toFixed(4)">
                    </div>
                @endforeach
            </div>

            <!-- Form Actions & Auto Normalize Button -->
            <div class="pt-4 border-t-2 border-black flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs font-bold text-slate-800">
                    <template x-if="!isTotalValid">
                        <span class="text-rose-700 flex items-center">
                            <i data-lucide="alert-circle" class="w-4 h-4 mr-1 flex-shrink-0 stroke-[2.5]"></i>
                            Total bobot harus tepat 100%. Tekan "Normalisasi Otomatis" untuk meratakan bobot secara proporsional.
                        </span>
                    </template>
                    <template x-if="isTotalValid">
                        <span class="text-black flex items-center">
                            <i data-lucide="check" class="w-4 h-4 mr-1 flex-shrink-0 stroke-[3] text-black"></i>
                            Total bobot valid 100% (1.0). Siap untuk kalkulasi SAW.
                        </span>
                    </template>
                </div>

                <div class="flex items-center space-x-3 w-full sm:w-auto justify-end">
                    <button type="button" @click="autoNormalizeClient()" class="neo-btn bg-cyan-300 hover:bg-cyan-400 text-black">
                        <i data-lucide="wand-2" class="w-4 h-4 mr-1.5 stroke-[2.5]"></i>
                        <span>Normalisasi Otomatis</span>
                    </button>

                    <button type="submit" :disabled="!isTotalValid"
                        class="neo-btn"
                        :class="isTotalValid ? 'bg-yellow-300 hover:bg-yellow-400 text-black cursor-pointer' : 'bg-slate-200 text-slate-400 border-slate-400 shadow-none cursor-not-allowed'">
                        <i data-lucide="save" class="w-4 h-4 mr-1.5 stroke-[2.5]"></i>
                        <span>Simpan Bobot Baru</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- ========================================== -->
    <!-- 1. MATRIKS KEPUTUSAN (X) -->
    <!-- ========================================== -->
    <div class="neo-box bg-white overflow-hidden mb-6">
        <div class="px-6 py-4 border-b-2 border-black bg-cyan-200 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black text-black uppercase tracking-tight">1. Matriks Keputusan ($X$)</h3>
                <p class="text-xs font-bold text-slate-800">Matriks data mentah skor alternatif laptop terhadap masing-masing kriteria.</p>
            </div>
            <span class="neo-badge bg-black text-white text-xs">
                Matriks X ({{ $alternatives->count() }} × {{ $criterias->count() }})
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b-2 border-black text-xs font-black text-black uppercase tracking-wider">
                        <th class="py-3 px-4 border-r-2 border-black text-center w-16">Kode</th>
                        <th class="py-3 px-4 border-r-2 border-black min-w-[200px]">Alternatif Laptop</th>
                        @foreach($criterias as $crit)
                            <th class="py-3 px-3 border-r-2 border-black text-center min-w-[100px]">
                                <div class="font-black text-black">{{ $crit->code }}</div>
                                <div class="text-[10px] font-bold text-slate-600">
                                    {{ $crit->isBenefit() ? '(Benefit)' : '(Cost)' }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-black">
                    @foreach($alternatives as $alt)
                        <tr class="hover:bg-yellow-50/60 transition-colors">
                            <td class="py-3.5 px-4 border-r-2 border-black text-center font-black text-xs">{{ $alt->code }}</td>
                            <td class="py-3.5 px-4 border-r-2 border-black font-bold text-black">{{ $alt->name }}</td>
                            @foreach($criterias as $crit)
                                @php
                                    $val = $sawData['matrix_x'][$alt->id]['scores'][$crit->id] ?? 0;
                                    $isExt = false;
                                    if ($crit->isBenefit() && isset($sawData['extremes'][$crit->id]) && $val == $sawData['extremes'][$crit->id]['max']) {
                                        $isExt = true;
                                    } elseif ($crit->isCost() && isset($sawData['extremes'][$crit->id]) && $val == $sawData['extremes'][$crit->id]['min']) {
                                        $isExt = true;
                                    }
                                @endphp
                                <td class="py-3.5 px-3 border-r-2 border-black text-center">
                                    @if($isExt)
                                        <span class="inline-block px-2.5 py-1 text-xs font-black bg-lime-300 border-2 border-black shadow-[2px_2px_0px_0px_#000]" title="Nilai Ekstrem Optimal">
                                            {{ $val }} ⭐
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 text-xs font-bold text-slate-800">
                                            {{ $val }}
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                    <!-- Extreme Values Row (Max/Min) -->
                    <tr class="bg-yellow-100 font-black text-xs border-t-4 border-black">
                        <td colspan="2" class="py-3 px-4 border-r-2 border-black uppercase text-black text-right">
                            Target Ekstrem Rujukan :
                        </td>
                        @foreach($criterias as $crit)
                            @php
                                $ext = $sawData['extremes'][$crit->id] ?? null;
                            @endphp
                            <td class="py-3 px-3 border-r-2 border-black text-center">
                                @if($crit->isBenefit())
                                    <div class="text-[10px] text-slate-700 font-bold">Max</div>
                                    <div class="text-black font-black text-sm">{{ $ext ? $ext['max'] : '-' }}</div>
                                @else
                                    <div class="text-[10px] text-slate-700 font-bold">Min</div>
                                    <div class="text-black font-black text-sm">{{ $ext ? $ext['min'] : '-' }}</div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. MATRIKS TERNORMALISASI (R) -->
    <!-- ========================================== -->
    <div class="neo-box bg-white overflow-hidden mb-6">
        <div class="px-6 py-4 border-b-2 border-black bg-lime-300 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black text-black uppercase tracking-tight">2. Matriks Ternormalisasi ($R$)</h3>
                <p class="text-xs font-bold text-slate-800">Hasil normalisasi skala setiap alternatif terhadap kriteria (Benefit: x/max, Cost: min/x).</p>
            </div>
            <span class="neo-badge bg-black text-white text-xs">
                Matriks R (Skala 0 - 1.0)
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b-2 border-black text-xs font-black text-black uppercase tracking-wider">
                        <th class="py-3 px-4 border-r-2 border-black text-center w-16">Kode</th>
                        <th class="py-3 px-4 border-r-2 border-black min-w-[200px]">Alternatif Laptop</th>
                        @foreach($criterias as $crit)
                            <th class="py-3 px-3 border-r-2 border-black text-center min-w-[100px]">
                                <div class="font-black text-black">{{ $crit->code }}</div>
                                <div class="text-[10px] font-bold text-slate-600">
                                    {{ $crit->isBenefit() ? 'Benefit' : 'Cost' }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-black">
                    @foreach($alternatives as $alt)
                        <tr class="hover:bg-yellow-50/60 transition-colors">
                            <td class="py-3.5 px-4 border-r-2 border-black text-center font-black text-xs">{{ $alt->code }}</td>
                            <td class="py-3.5 px-4 border-r-2 border-black font-bold text-black">{{ $alt->name }}</td>
                            @foreach($criterias as $crit)
                                @php
                                    $rVal = $sawData['matrix_r'][$alt->id]['r'][$crit->id] ?? 0;
                                    $isMax = (abs($rVal - 1.0) < 0.0001);
                                @endphp
                                <td class="py-3.5 px-3 border-r-2 border-black text-center font-mono">
                                    <div class="font-black {{ $isMax ? 'text-black bg-lime-200 border border-black inline-block px-2 py-0.5' : 'text-black' }}">
                                        {{ number_format($rVal, 2) }}
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Step 2 Bottom Action Bar (AgentUI Section 3.A: Symmetrical Navigation) -->
    <div class="neo-box p-5 bg-white mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <!-- Left: Back Button -->
        <button type="button" @click="goToStep(1)" class="w-full sm:w-auto neo-btn bg-white hover:bg-slate-100 text-black">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 stroke-[3]"></i>
            <span>Kembali ke Langkah 1: Input Alternatif</span>
        </button>

        <!-- Right: Forward Button -->
        <button type="button" @click="goToStep(3)" class="w-full sm:w-auto neo-btn bg-lime-300 hover:bg-lime-400 text-black">
            <span>Lanjut ke Langkah 3: Hasil Perangkingan Akhir ($V_i$)</span>
            <i data-lucide="arrow-right" class="w-4 h-4 ml-2 stroke-[3]"></i>
        </button>

    </div>

</div>

@push('scripts')
<script>
    function step2WeightsHandler() {
        return {
            weights: {
                @foreach($criterias as $crit)
                    {{ $crit->id }}: {{ round($crit->weight * 100) }},
                @endforeach
            },
            totalWeightPercentage: {{ round($criterias->sum('weight') * 100) }},
            totalWeightDecimal: {{ $criterias->sum('weight') }},
            isTotalValid: {{ abs($criterias->sum('weight') - 1.0) < 0.01 ? 'true' : 'false' }},

            recalculateTotal() {
                let sum = 0;
                for (let key in this.weights) {
                    sum += Number(this.weights[key]) || 0;
                }
                this.totalWeightPercentage = sum;
                this.totalWeightDecimal = sum / 100.0;
                this.isTotalValid = (sum === 100);
            },

            autoNormalizeClient() {
                const keys = Object.keys(this.weights);
                if (keys.length === 0) return;

                let currentSum = 0;
                keys.forEach(k => currentSum += (Number(this.weights[k]) || 0));

                if (currentSum === 0) {
                    const even = Math.floor(100 / keys.length);
                    let remainder = 100 - (even * keys.length);
                    keys.forEach((k, idx) => {
                        this.weights[k] = even + (idx === 0 ? remainder : 0);
                    });
                } else {
                    let newSum = 0;
                    const calculated = {};
                    keys.forEach(k => {
                        calculated[k] = Math.round((Number(this.weights[k]) / currentSum) * 100);
                        newSum += calculated[k];
                    });

                    // Fix any rounding discrepancy to exactly 100%
                    let diff = 100 - newSum;
                    calculated[keys[0]] += diff;

                    keys.forEach(k => {
                        this.weights[k] = Math.max(0, calculated[k]);
                    });
                }

                this.recalculateTotal();
            }
        }
    }
</script>
@endpush
