<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil SPK Pemilihan Laptop (Metode SAW - Neo-Brutalism)</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #000000;
            background-color: #ffffff;
        }
        @media print {
            .no-print { display: none !important; }
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            @page { margin: 12mm; size: A4 portrait; }
        }
    </style>
</head>
<body class="p-6 sm:p-10 max-w-4xl mx-auto text-black">

    <!-- Top Action Bar for Printing -->
    <div class="no-print mb-8 p-4 bg-yellow-300 border-4 border-black shadow-[6px_6px_0px_0px_#000] flex items-center justify-between">
        <div>
            <h3 class="font-black text-sm uppercase text-black">Pratinjau Cetak Laporan SPK Pemilihan Laptop</h3>
            <p class="text-xs font-bold text-slate-800">Metode Simple Additive Weighting (SAW) • Format Dokumen Resmi</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="window.close()" class="px-4 py-2 text-xs font-black uppercase border-2 border-black bg-white hover:bg-slate-100 text-black shadow-[2px_2px_0px_0px_#000]">
                Tutup
            </button>
            <button onclick="window.print()" class="px-5 py-2 text-xs font-black uppercase border-2 border-black bg-black text-white hover:bg-slate-800 shadow-[3px_3px_0px_0px_#000] flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- Official Report Header -->
    <header class="border-b-4 border-black pb-5 mb-8 flex items-start justify-between">
        <div>
            <div class="inline-block px-2.5 py-0.5 bg-yellow-300 border-2 border-black font-black text-xs uppercase mb-1 shadow-[2px_2px_0px_0px_#000]">
                Laporan Hasil Analisis Komputasi
            </div>
            <h1 class="text-2xl font-black text-black tracking-tight uppercase">Sistem Pendukung Keputusan Pemilihan Laptop</h1>
            <h2 class="text-base font-black text-slate-800 uppercase">Bagi Mahasiswa IT Menggunakan Algoritma SAW</h2>
        </div>
        <div class="text-right text-xs font-bold text-slate-700">
            <div class="font-black text-black">Tanggal Cetak:</div>
            <div>{{ date('d F Y, H:i') }} WIB</div>
            <div class="mt-1 text-[11px] text-slate-600">Makalah Acuan SAW SPK</div>
        </div>
    </header>

    <!-- 1. Winner Showcase Summary -->
    @if(isset($sawData['winner']) && $sawData['winner'])
        @php
            $w = $sawData['winner'];
        @endphp
        <div class="mb-8 p-5 bg-lime-200 border-4 border-black text-black shadow-[4px_4px_0px_0px_#000] flex items-center justify-between">
            <div>
                <span class="inline-block px-3 py-1 bg-yellow-300 border-2 border-black font-black uppercase text-xs tracking-wider mb-1.5 shadow-[2px_2px_0px_0px_#000]">
                    🏆 Hasil Rekomendasi Utama (Peringkat #1)
                </span>
                <h3 class="text-2xl font-black text-black uppercase">{{ $w['alternative']->code }} - {{ $w['alternative']->name }}</h3>
                <p class="text-xs font-bold text-slate-800 mt-1 max-w-xl">{{ $w['alternative']->spec_summary }}</p>
            </div>
            <div class="text-right bg-white p-4 border-2 border-black shadow-[3px_3px_0px_0px_#000]">
                <div class="text-[11px] font-black uppercase text-slate-600">Nilai Preferensi ($V_i$)</div>
                <div class="text-3xl font-black text-black font-mono">{{ $w['preference_formatted'] }}</div>
                <div class="text-[10px] font-bold text-slate-600">({{ $w['percentage'] }}%)</div>
            </div>
        </div>
    @endif

    <!-- 2. Criteria Summary -->
    <section class="mb-8">
        <h3 class="text-xs font-black uppercase tracking-wider text-black border-b-2 border-black pb-1.5 mb-3 flex items-center space-x-2">
            <span class="w-3 h-3 bg-black inline-block"></span>
            <span>I. Kriteria Penilaian & Bobot Kepentingan ($W$)</span>
        </h3>
        <table class="w-full text-left text-xs border-2 border-black border-collapse">
            <thead class="bg-yellow-300 font-black text-black border-b-2 border-black">
                <tr>
                    <th class="p-2.5 border-r-2 border-black text-center w-16">Kode</th>
                    <th class="p-2.5 border-r-2 border-black">Nama Kriteria</th>
                    <th class="p-2.5 border-r-2 border-black text-center w-24">Atribut</th>
                    <th class="p-2.5 border-r-2 border-black text-center w-32">Bobot ($w_j$)</th>
                    <th class="p-2.5">Satuan / Skala Ukur</th>
                </tr>
            </thead>
            <tbody class="divide-y border-black font-semibold">
                @foreach($criterias as $crit)
                    <tr>
                        <td class="p-2.5 border-r-2 border-black font-black text-center bg-slate-50">{{ $crit->code }}</td>
                        <td class="p-2.5 border-r-2 border-black font-bold">{{ $crit->name }}</td>
                        <td class="p-2.5 border-r-2 border-black text-center uppercase font-black {{ $crit->isBenefit() ? 'text-emerald-800 bg-lime-50' : 'text-amber-800 bg-amber-50' }}">
                            {{ $crit->attribute }}
                        </td>
                        <td class="p-2.5 border-r-2 border-black text-center font-bold">{{ number_format($crit->weight, 2) }} ({{ round($crit->weight * 100) }}%)</td>
                        <td class="p-2.5 text-slate-700">{{ $crit->unit ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-100 font-black border-t-2 border-black">
                <tr>
                    <td colspan="3" class="p-2.5 border-r-2 border-black text-right uppercase">TOTAL BOBOT KESELURUHAN:</td>
                    <td class="p-2.5 border-r-2 border-black text-center font-black text-sm">{{ number_format($criterias->sum('weight'), 2) }} (100%)</td>
                    <td class="p-2.5"></td>
                </tr>
            </tfoot>
        </table>
    </section>

    <!-- 3. Final Ranking Table -->
    <section class="mb-8">
        <h3 class="text-xs font-black uppercase tracking-wider text-black border-b-2 border-black pb-1.5 mb-3 flex items-center space-x-2">
            <span class="w-3 h-3 bg-black inline-block"></span>
            <span>II. Hasil Perangkingan Akhir Alternatif Laptop (Metode SAW)</span>
        </h3>
        <table class="w-full text-left text-xs border-2 border-black border-collapse">
            <thead class="bg-yellow-300 font-black text-black border-b-2 border-black">
                <tr>
                    <th class="p-2.5 border-r-2 border-black text-center w-16">Rank</th>
                    <th class="p-2.5 border-r-2 border-black text-center w-16">Kode</th>
                    <th class="p-2.5 border-r-2 border-black">Nama Alternatif Laptop</th>
                    <th class="p-2.5 border-r-2 border-black text-center w-32">Nilai Preferensi ($V_i$)</th>
                    <th class="p-2.5 text-center w-40">Status Kelayakan</th>
                </tr>
            </thead>
            <tbody class="divide-y border-black font-semibold">
                @foreach($sawData['results'] as $res)
                    <tr class="{{ $res['rank'] === 1 ? 'bg-lime-200 font-black border-y-2 border-black' : '' }}">
                        <td class="p-2.5 border-r-2 border-black text-center font-black text-sm">#{{ $res['rank'] }}</td>
                        <td class="p-2.5 border-r-2 border-black text-center font-black">{{ $res['alternative']->code }}</td>
                        <td class="p-2.5 border-r-2 border-black">
                            <div class="font-black text-black">{{ $res['alternative']->name }}</div>
                            <div class="text-[10px] text-slate-700 font-normal">{{ $res['alternative']->spec_summary }}</div>
                        </td>
                        <td class="p-2.5 border-r-2 border-black text-center font-mono text-sm font-black">
                            {{ $res['preference_formatted'] }}
                        </td>
                        <td class="p-2.5 text-center">
                            @if($res['rank'] === 1)
                                <span class="px-2 py-0.5 bg-yellow-300 border border-black font-black uppercase">🏆 Rekomendasi Utama</span>
                            @elseif($res['rank'] <= 3)
                                <span class="font-bold text-black">Alternatif Unggulan</span>
                            @else
                                <span class="text-slate-600 font-medium">Alternatif Pilihan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <!-- 4. Mathematical Matrices Review -->
    <section class="mb-8">
        <h3 class="text-xs font-black uppercase tracking-wider text-black border-b-2 border-black pb-1.5 mb-3 flex items-center space-x-2">
            <span class="w-3 h-3 bg-black inline-block"></span>
            <span>III. Matriks Ternormalisasi ($R$)</span>
        </h3>
        <table class="w-full text-left text-xs border-2 border-black border-collapse font-mono">
            <thead class="bg-yellow-300 font-black text-black border-b-2 border-black font-sans">
                <tr>
                    <th class="p-2 border-r-2 border-black text-center w-16">Kode</th>
                    <th class="p-2 border-r-2 border-black">Alternatif Laptop</th>
                    @foreach($criterias as $crit)
                        <th class="p-2 border-r-2 border-black text-center">{{ $crit->code }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y border-black font-bold">
                @foreach($alternatives as $alt)
                    <tr>
                        <td class="p-2 border-r-2 border-black text-center font-black bg-slate-50">{{ $alt->code }}</td>
                        <td class="p-2 border-r-2 border-black font-sans">{{ $alt->name }}</td>
                        @foreach($criterias as $crit)
                            <td class="p-2 border-r-2 border-black text-center">
                                {{ number_format($sawData['matrix_r'][$alt->id]['r'][$crit->id] ?? 0, 4) }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <!-- Report Sign-off Footer -->
    <footer class="mt-12 pt-6 border-t-2 border-black text-xs font-bold text-slate-700 flex justify-between items-end">
        <div>
            <p class="font-black text-black uppercase">Sistem Pendukung Keputusan Pemilihan Laptop Mahasiswa IT</p>
            <p>Dihitung secara otomatis menggunakan algoritma Simple Additive Weighting (SAW) dinamis.</p>
        </div>
        <div class="text-center w-48">
            <p class="mb-14">Mengetahui,</p>
            <p class="font-black text-black border-t-2 border-black pt-1 uppercase">Pengambil Keputusan</p>
        </div>
    </footer>

</body>
</html>
