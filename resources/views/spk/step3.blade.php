<div class="space-y-8" x-data="step3ResultsHandler()">

    <!-- ========================================================================= -->
    <!-- 1. HERO CARD: KONTRAST WARNA REKOMENDASI TERBAIK (PERINGKAT #1)           -->
    <!-- AgentUI Section 3.B: Hero Showcase Peringkat #1                           -->
    <!-- ========================================================================= -->
    @if(isset($sawData['winner']) && $sawData['winner'])
        @php
            $winner = $sawData['winner'];
            $winAlt = $winner['alternative'];
        @endphp
        <div class="neo-box-thick bg-lime-300 p-6 sm:p-8 mb-6 relative overflow-hidden">
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <!-- Left Details -->
                <div class="space-y-3 flex-1">
                    <div class="flex items-center space-x-2">
                        <!-- Badge "🏆 Rekomendasi Utama" berbingkai hitam tebal -->
                        <span class="inline-flex items-center px-3.5 py-1.5 border-2 border-black bg-yellow-300 text-black font-black uppercase text-xs sm:text-sm shadow-[3px_3px_0px_0px_#000]">
                            <i data-lucide="crown" class="w-4 h-4 mr-1.5 stroke-[2.5]"></i>
                            🏆 Rekomendasi Utama #1
                        </span>
                        <span class="neo-badge bg-black text-white text-xs">
                            {{ $winAlt->code }}
                        </span>
                        @if($winAlt->brand)
                            <span class="neo-badge bg-white text-black text-xs">
                                {{ $winAlt->brand }}
                            </span>
                        @endif
                    </div>

                    <div>
                        <h2 class="text-2xl sm:text-4xl font-black text-black tracking-tight uppercase">
                            {{ $winAlt->name }}
                        </h2>
                        <p class="text-xs sm:text-sm font-bold text-slate-800 mt-1 max-w-2xl leading-relaxed">
                            {{ $winAlt->spec_summary ?? 'Pilihan laptop paling ideal untuk kebutuhan komputasi dan mobilitas mahasiswa IT berdasarkan kriteria dan bobot yang telah ditetapkan.' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                        @if($winAlt->price_raw)
                            <div class="px-3 py-1 bg-white border-2 border-black font-black text-black shadow-[2px_2px_0px_0px_#000]">
                                💰 Est. Rp {{ number_format($winAlt->price_raw, 0, ',', '.') }}
                            </div>
                        @endif
                        <div class="px-3 py-1 bg-black text-lime-300 border-2 border-black font-black uppercase tracking-wide shadow-[2px_2px_0px_0px_#000]">
                            ✨ Keseimbangan Performa & Harga Terbaik (Metode SAW)
                        </div>
                    </div>
                </div>

                <!-- Right Score Metric Card -->
                <div class="w-full md:w-auto flex-shrink-0 bg-white border-4 border-black p-5 sm:p-6 shadow-[6px_6px_0px_0px_#000] text-center md:text-right min-w-[240px]">
                    <p class="text-[11px] font-black uppercase tracking-widest text-slate-700">Nilai Preferensi ($V_i$)</p>
                    <div class="text-4xl sm:text-5xl font-black text-black my-1 font-mono tracking-tight">
                        {{ $winner['preference_formatted'] }}
                    </div>
                    <div class="inline-flex items-center px-2.5 py-1 bg-yellow-300 border border-black text-xs font-black text-black mt-1">
                        <i data-lucide="check" class="w-3.5 h-3.5 mr-1 stroke-[3]"></i>
                        Peringkat 1 dari {{ count($sawData['results']) }} Laptop
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 2. LEADERBOARD RANKING TABLE                                              -->
    <!-- AgentUI Section 3.B: Full-row Contrast Background for Rank #1             -->
    <!-- ========================================================================= -->
    <div class="neo-box bg-white overflow-hidden mb-6">
        <div class="px-6 py-4 border-b-2 border-black bg-yellow-300 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-sm sm:text-base font-black text-black uppercase tracking-tight">Tabel Perangkingan Lengkap (Metode SAW)</h3>
                <p class="text-xs font-bold text-slate-800">Daftar alternatif laptop diurutkan secara otomatis dari nilai preferensi ($V_i$) tertinggi ke terendah.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                <a href="{{ route('spk.print') }}" target="_blank" class="neo-btn-sm bg-white hover:bg-slate-100 text-black">
                    <i data-lucide="printer" class="w-3.5 h-3.5 mr-1.5 stroke-[2.5]"></i>
                    Cetak Laporan
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b-2 border-black text-xs font-black text-black uppercase tracking-wider">
                        <th class="py-3.5 px-4 border-r-2 border-black text-center w-24">Peringkat</th>
                        <th class="py-3.5 px-4 border-r-2 border-black w-20 text-center">Kode</th>
                        <th class="py-3.5 px-4 border-r-2 border-black min-w-[220px]">Nama Laptop Alternatif</th>
                        <th class="py-3.5 px-4 border-r-2 border-black min-w-[200px]">Bar Visual Nilai ($V_i$)</th>
                        <th class="py-3.5 px-4 border-r-2 border-black text-center w-36">Nilai Preferensi ($V_i$)</th>
                        <th class="py-3.5 px-4 text-center min-w-[170px]">Status Rekomendasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-black">
                    @foreach($sawData['results'] as $res)
                        @php
                            $isTop1 = ($res['rank'] === 1);
                            $isTop2 = ($res['rank'] === 2);
                            $isTop3 = ($res['rank'] === 3);
                            $alt = $res['alternative'];
                            $percentVal = min(100, round(($res['preference_score'] / ($sawData['winner']['preference_score'] ?: 1)) * 100));
                        @endphp
                        
                        <!-- 
                            AgentUI Section 3.B: 
                            "Baris tabel untuk Peringkat #1 (Rekomendasi Utama) wajib memiliki warna latar belakang 
                            kontras yang penuh satu baris (misalnya hijau neon terang atau kuning pastel) dengan 
                            ketebalan border yang sama persis dengan baris lainnya, namun dilengkapi badge '🏆 Rekomendasi Utama' 
                            berbingkai hitam tebal"
                        -->
                        <tr class="transition-colors {{ $isTop1 ? 'bg-lime-300 font-bold' : ($isTop2 ? 'bg-yellow-50 hover:bg-yellow-100' : 'hover:bg-slate-50') }}">
                            
                            <!-- Rank Badge -->
                            <td class="py-4 px-4 border-r-2 border-black text-center">
                                @if($isTop1)
                                    <div class="w-10 h-10 mx-auto bg-black text-lime-300 border-2 border-black flex items-center justify-center font-black text-sm shadow-[2px_2px_0px_0px_#000]">
                                        #1
                                    </div>
                                @elseif($isTop2)
                                    <div class="w-9 h-9 mx-auto bg-yellow-300 text-black border-2 border-black flex items-center justify-center font-black text-xs shadow-[2px_2px_0px_0px_#000]">
                                        #2
                                    </div>
                                @elseif($isTop3)
                                    <div class="w-9 h-9 mx-auto bg-cyan-300 text-black border-2 border-black flex items-center justify-center font-black text-xs shadow-[2px_2px_0px_0px_#000]">
                                        #3
                                    </div>
                                @else
                                    <div class="w-8 h-8 mx-auto bg-white text-slate-700 border-2 border-black flex items-center justify-center font-black text-xs">
                                        #{{ $res['rank'] }}
                                    </div>
                                @endif
                            </td>

                            <!-- Code -->
                            <td class="py-4 px-4 border-r-2 border-black text-center">
                                <span class="neo-badge {{ $isTop1 ? 'bg-black text-lime-300' : 'bg-white text-black' }} text-xs">
                                    {{ $alt->code }}
                                </span>
                            </td>

                            <!-- Name & Specs -->
                            <td class="py-4 px-4 border-r-2 border-black">
                                <div class="font-black text-base {{ $isTop1 ? 'text-black' : 'text-black' }}">
                                    {{ $alt->name }}
                                </div>
                                <div class="text-xs font-semibold {{ $isTop1 ? 'text-slate-800' : 'text-slate-600' }} mt-0.5">
                                    {{ $alt->spec_summary ?? '-' }}
                                </div>
                            </td>

                            <!-- Bar Visual -->
                            <td class="py-4 px-4 border-r-2 border-black">
                                <div class="w-full bg-white border-2 border-black h-4 overflow-hidden shadow-[2px_2px_0px_0px_#000]">
                                    <div class="h-full border-r border-black transition-all duration-500 {{ $isTop1 ? 'bg-black' : ($isTop2 ? 'bg-yellow-400' : ($isTop3 ? 'bg-cyan-400' : 'bg-slate-300')) }}" 
                                        style="width: {{ $percentVal }}%"></div>
                                </div>
                                <div class="text-[10px] font-black uppercase text-slate-700 mt-1 flex justify-between">
                                    <span>Skor Relatif: {{ $percentVal }}%</span>
                                    <span>V = {{ $res['preference_formatted'] }}</span>
                                </div>
                            </td>

                            <!-- Preference Score Vi -->
                            <td class="py-4 px-4 border-r-2 border-black text-center">
                                <div class="font-mono font-black text-xl text-black">
                                    {{ $res['preference_formatted'] }}
                                </div>
                                <div class="text-[10px] font-bold text-slate-700">
                                    ({{ $res['percentage'] }}%)
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-4 text-center">
                                @if($isTop1)
                                    <!-- Badge "🏆 Rekomendasi Utama" berbingkai hitam tebal -->
                                    <span class="inline-flex items-center px-3 py-1 bg-yellow-300 border-2 border-black text-black font-black uppercase text-xs shadow-[3px_3px_0px_0px_#000]">
                                        🏆 Rekomendasi Utama
                                    </span>
                                @elseif($isTop2)
                                    <span class="neo-badge bg-white text-black text-[11px]">
                                        🥈 Alternatif Terbaik 2
                                    </span>
                                @elseif($isTop3)
                                    <span class="neo-badge bg-white text-black text-[11px]">
                                        🥉 Alternatif Terbaik 3
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 border border-black bg-white font-bold text-slate-700 text-xs">
                                        Peringkat {{ $res['rank'] }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. MATRIKS TERBOBOT (W * R) & DETAIL KONTRIBUSI KRITERIA                  -->
    <!-- ========================================================================= -->
    <div class="neo-box bg-white overflow-hidden mb-6">
        <div class="px-6 py-4 border-b-2 border-black bg-cyan-200 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black text-black uppercase tracking-tight">3. Matriks Terbobot ($W \times R$) & Akumulasi Skor ($V_i$)</h3>
                <p class="text-xs font-bold text-slate-800">Perhitungan preferensi akhir: $V_i = \sum_{j=1}^n w_j \cdot r_{ij}$.</p>
            </div>
            <span class="neo-badge bg-black text-white text-xs">
                Formula SAW
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b-2 border-black text-xs font-black text-black uppercase tracking-wider">
                        <th class="py-3 px-4 border-r-2 border-black text-center w-16">Rank</th>
                        <th class="py-3 px-4 border-r-2 border-black text-center w-16">Kode</th>
                        <th class="py-3 px-4 border-r-2 border-black min-w-[200px]">Nama Laptop</th>
                        @foreach($criterias as $crit)
                            <th class="py-3 px-3 border-r-2 border-black text-center min-w-[100px]">
                                <div class="font-black text-black">{{ $crit->code }}</div>
                                <div class="text-[10px] font-bold text-slate-600">(W = {{ number_format($crit->weight, 2) }})</div>
                            </th>
                        @endforeach
                        <th class="py-3 px-4 text-center font-black w-32 bg-yellow-100 border-l-2 border-black">Total $V_i$</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-black">
                    @foreach($sawData['results'] as $res)
                        @php
                            $alt = $res['alternative'];
                            $isTop1 = ($res['rank'] === 1);
                        @endphp
                        <tr class="hover:bg-yellow-50/60 transition-colors {{ $isTop1 ? 'bg-lime-100/60 font-bold' : '' }}">
                            <td class="py-3.5 px-4 border-r-2 border-black text-center font-black text-xs">#{{ $res['rank'] }}</td>
                            <td class="py-3.5 px-4 border-r-2 border-black text-center font-black text-xs">{{ $alt->code }}</td>
                            <td class="py-3.5 px-4 border-r-2 border-black font-bold text-black">{{ $alt->name }}</td>
                            @foreach($criterias as $crit)
                                @php
                                    $wVal = $sawData['matrix_weighted'][$alt->id]['w_r'][$crit->id] ?? 0;
                                @endphp
                                <td class="py-3.5 px-3 border-r-2 border-black text-center font-mono text-xs text-slate-800">
                                    {{ number_format($wVal, 4) }}
                                </td>
                            @endforeach
                            <td class="py-3.5 px-4 text-center font-mono font-black text-base text-black bg-yellow-50 border-l-2 border-black">
                                {{ $res['preference_formatted'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 4. VISUAL CHART BREAKDOWN (NEO-BRUTALISM)                                 -->
    <!-- ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- Bar Chart: Ranking Comparison -->
        <div class="neo-box p-6 bg-white">
            <div class="flex items-center justify-between mb-4 border-b-2 border-black pb-3">
                <div class="flex items-center space-x-2">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 text-black stroke-[2.5]"></i>
                    <h4 class="font-black text-black uppercase text-sm">Grafik Perbandingan Nilai Preferensi ($V_i$)</h4>
                </div>
                <span class="neo-badge bg-yellow-300 text-black text-[10px]">Bar Chart</span>
            </div>
            <div class="h-64 sm:h-72">
                <canvas id="rankingBarChart"></canvas>
            </div>
        </div>

        <!-- Radar Chart: Top 3 Performance Multi-Criteria -->
        <div class="neo-box p-6 bg-white">
            <div class="flex items-center justify-between mb-4 border-b-2 border-black pb-3">
                <div class="flex items-center space-x-2">
                    <i data-lucide="radar" class="w-5 h-5 text-black stroke-[2.5]"></i>
                    <h4 class="font-black text-black uppercase text-sm">Radar Profil Kinerja Top 3 Alternatif</h4>
                </div>
                <span class="neo-badge bg-lime-300 text-black text-[10px]">Radar Multi-Axis</span>
            </div>
            <div class="h-64 sm:h-72">
                <canvas id="radarTopChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Step 3 Bottom Action Bar (AgentUI Section 3.A: Symmetrical Navigation) -->
    <div class="neo-box p-5 bg-white mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <!-- Left: Back to Step 2 -->
        <button type="button" @click="goToStep(2)" class="w-full sm:w-auto neo-btn bg-white hover:bg-slate-100 text-black">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 stroke-[3]"></i>
            <span>Kembali ke Langkah 2: Matriks Normalisasi</span>
        </button>

        <!-- Right: Print Report -->
        <a href="{{ route('spk.print') }}" target="_blank" class="w-full sm:w-auto neo-btn bg-yellow-300 hover:bg-yellow-400 text-black">
            <i data-lucide="printer" class="w-4 h-4 mr-2 stroke-[2.5]"></i>
            <span>Cetak / Download Laporan Hasil SPK</span>
        </a>

    </div>

</div>

@push('scripts')
<script>
    function step3ResultsHandler() {
        return {
            init() {
                this.$nextTick(() => {
                    renderCharts();
                });
            }
        }
    }

    let barChartInstance = null;
    let radarChartInstance = null;

    function renderCharts() {
        const barCtx = document.getElementById('rankingBarChart');
        const radarCtx = document.getElementById('radarTopChart');

        if (!barCtx || !radarCtx) return;

        // 1. Render Bar Chart Neo-Brutalist
        const altLabels = [
            @foreach($sawData['results'] as $res)
                "{{ $res['alternative']->code }} - {{ Str::limit($res['alternative']->name, 16) }}",
            @endforeach
        ];

        const altScores = [
            @foreach($sawData['results'] as $res)
                {{ $res['preference_score'] }},
            @endforeach
        ];

        const barColors = [
            @foreach($sawData['results'] as $res)
                "{{ $res['rank'] === 1 ? '#bef264' : ($res['rank'] === 2 ? '#fde047' : ($res['rank'] === 3 ? '#67e8f9' : '#cbd5e1')) }}",
            @endforeach
        ];

        if (barChartInstance) barChartInstance.destroy();
        barChartInstance = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: altLabels,
                datasets: [{
                    label: 'Nilai Preferensi (V)',
                    data: altScores,
                    backgroundColor: barColors,
                    borderColor: '#000000',
                    borderWidth: 2,
                    borderRadius: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#000000',
                        titleFont: { family: 'Plus Jakarta Sans', weight: 'bold' },
                        bodyFont: { family: 'Plus Jakarta Sans' },
                        padding: 10,
                        borderColor: '#000000',
                        borderWidth: 2,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1.0,
                        grid: { color: '#00000020' },
                        ticks: { font: { family: 'Plus Jakarta Sans', weight: 'bold' } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 10, weight: 'bold' },
                            callback: function(val, idx) {
                                const full = this.getLabelForValue(val);
                                return full.split(' - ')[0]; // Show code e.g. A7
                            }
                        }
                    }
                }
            }
        });

        // 2. Render Radar Chart (Top 3 Alternatives)
        const criteriaLabels = [
            @foreach($criterias as $crit)
                "{{ $crit->code }} ({{ $crit->name }})",
            @endforeach
        ];

        const top3Datasets = [
            @foreach(array_slice($sawData['results'], 0, 3) as $idx => $topRes)
                {
                    label: "{{ $topRes['alternative']->code }} - {{ $topRes['alternative']->name }}",
                    data: [
                        @foreach($criterias as $crit)
                            {{ $sawData['matrix_r'][$topRes['alternative']->id]['r'][$crit->id] ?? 0 }},
                        @endforeach
                    ],
                    borderColor: "{{ $idx === 0 ? '#000000' : ($idx === 1 ? '#000000' : '#000000') }}",
                    backgroundColor: "{{ $idx === 0 ? 'rgba(190, 242, 100, 0.5)' : ($idx === 1 ? 'rgba(253, 224, 71, 0.4)' : 'rgba(103, 232, 249, 0.4)') }}",
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: "{{ $idx === 0 ? '#bef264' : ($idx === 1 ? '#fde047' : '#67e8f9') }}",
                    pointBorderColor: '#000000',
                    pointBorderWidth: 2,
                },
            @endforeach
        ];

        if (radarChartInstance) radarChartInstance.destroy();
        radarChartInstance = new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: criteriaLabels,
                datasets: top3Datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { family: 'Plus Jakarta Sans', size: 11, weight: 'bold' }, boxWidth: 14 }
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 1.0,
                        ticks: { stepSize: 0.25, display: false },
                        grid: { color: '#00000020' },
                        angleLines: { color: '#00000030' },
                        pointLabels: {
                            font: { family: 'Plus Jakarta Sans', size: 10, weight: 'bold' }
                        }
                    }
                }
            }
        });
    }

    window.renderCharts = renderCharts;
    document.addEventListener('DOMContentLoaded', () => {
        renderCharts();
    });
</script>
@endpush
