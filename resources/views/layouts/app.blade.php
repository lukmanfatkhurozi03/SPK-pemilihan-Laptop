<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPK Pemilihan Laptop - Metode SAW (Neo-Brutalism UI)')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.14.8/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            yellow: '#fde047',
                            lime: '#bef264',
                            cyan: '#67e8f9',
                            rose: '#fda4af',
                            purple: '#d8b4fe',
                            orange: '#fdba74',
                        }
                    },
                    boxShadow: {
                        'neo-sm': '2px 2px 0px 0px #000000',
                        'neo': '4px 4px 0px 0px #000000',
                        'neo-btn': '3px 3px 0px 0px #000000',
                        'neo-lg': '6px 6px 0px 0px #000000',
                        'neo-hero': '8px 8px 0px 0px #000000',
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #faf9f5;
            color: #000000;
            -webkit-font-smoothing: antialiased;
        }
        [x-cloak] { display: none !important; }
        
        /* Custom Neo-Brutalist scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-left: 2px solid #000000;
        }
        ::-webkit-scrollbar-thumb {
            background: #fde047;
            border: 2px solid #000000;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #facc15;
        }

        /* Range slider styling Neo-Brutalist */
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 22px;
            height: 22px;
            background: #fde047;
            cursor: pointer;
            border: 2px solid #000000;
            box-shadow: 2px 2px 0px 0px #000000;
            transition: all 0.1s ease-in-out;
        }
        input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
            background: #facc15;
        }

        /* Neo-Brutalism Classes */
        .neo-box {
            border: 2px solid #000000;
            box-shadow: 4px 4px 0px 0px #000000;
            background-color: #ffffff;
        }
        .neo-box-thick {
            border: 4px solid #000000;
            box-shadow: 6px 6px 0px 0px #000000;
            background-color: #ffffff;
        }
        .neo-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #000000;
            box-shadow: 3px 3px 0px 0px #000000;
            font-weight: 800;
            padding: 0.625rem 1rem;
            transition: all 0.1s ease;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        .neo-btn:hover {
            transform: translate(-1px, -1px);
            box-shadow: 4px 4px 0px 0px #000000;
        }
        .neo-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0px 0px #000000;
        }
        .neo-btn-sm {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #000000;
            box-shadow: 2px 2px 0px 0px #000000;
            font-weight: 700;
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            transition: all 0.1s ease;
            cursor: pointer;
        }
        .neo-btn-sm:hover {
            transform: translate(-1px, -1px);
            box-shadow: 3px 3px 0px 0px #000000;
        }
        .neo-btn-sm:active {
            transform: translate(1px, 1px);
            box-shadow: 1px 1px 0px 0px #000000;
        }
        .neo-input {
            width: 100%;
            border: 2px solid #000000;
            box-shadow: 2px 2px 0px 0px #000000;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 700;
            background-color: #ffffff;
            outline: none;
            transition: all 0.15s ease-in-out;
        }
        .neo-input:focus {
            background-color: #fefce8;
            box-shadow: 3px 3px 0px 0px #000000;
        }
        .neo-badge {
            display: inline-flex;
            align-items: center;
            border: 2px solid #000000;
            box-shadow: 2px 2px 0px 0px #000000;
            font-weight: 800;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            text-transform: uppercase;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full flex flex-col text-black antialiased selection:bg-black selection:text-yellow-300" x-data="spkWizardApp()">
    
    <!-- Top Neo-Brutalism Navbar (AgentUI Section 2.A: Balanced Header) -->
    <header class="sticky top-0 z-40 bg-white border-b-4 border-black transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Kiri: Logo/Nama Aplikasi dengan kotak bingkai tebal simetris -->
                <a href="{{ route('spk.index', ['step' => 1]) }}" class="flex items-center space-x-3 group flex-shrink-0">
                    <div class="w-10 h-10 bg-yellow-300 border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center group-hover:bg-yellow-400 group-hover:translate-x-[-1px] group-hover:translate-y-[-1px] transition-all">
                        <i data-lucide="laptop" class="w-5 h-5 text-black stroke-[2.5]"></i>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="font-black text-black text-base sm:text-lg tracking-tight uppercase leading-none">SPK LAPTOP</span>
                            <span class="px-1.5 py-0.5 text-[9px] font-black uppercase tracking-wider bg-lime-300 text-black border-2 border-black shadow-[1px_1px_0px_0px_#000] leading-none">SAW</span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500 hidden sm:block leading-tight mt-0.5">Sistem Pendukung Keputusan — Mahasiswa IT</p>
                    </div>
                </a>

                <!-- Kanan: Tombol Aksi Utama (CTA) dengan ukuran dan bayangan yang konsisten -->
                <div class="flex items-center space-x-2">
                    <!-- Reset Form Trigger -->
                    <form id="resetDefaultForm" action="{{ route('spk.reset') }}" method="POST" class="inline">
                        @csrf
                        <button type="button" @click="confirmReset()" class="neo-btn-sm bg-white hover:bg-rose-100 text-black text-[11px]">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 sm:mr-1 text-black stroke-[2.5]"></i>
                            <span class="hidden sm:inline">Reset Data</span>
                        </button>
                    </form>

                    <!-- Cetak Laporan -->
                    <a href="{{ route('spk.print') }}" target="_blank" class="neo-btn-sm bg-yellow-300 hover:bg-yellow-400 text-black text-[11px]">
                        <i data-lucide="printer" class="w-3.5 h-3.5 sm:mr-1 stroke-[2.5]"></i>
                        <span class="hidden sm:inline">Cetak</span>
                    </a>

                    <!-- Source Paper Info Modal Trigger -->
                    <button type="button" @click="showPaperInfo = true" class="neo-btn-sm bg-cyan-200 hover:bg-cyan-300 text-black text-[11px]">
                        <i data-lucide="book-open" class="w-3.5 h-3.5 sm:mr-1 stroke-[2.5]"></i>
                        <span class="hidden sm:inline">Makalah</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        
        <!-- Flash Notifications Neo-Brutalism -->
        @if (session('success'))
            <div class="mb-6 p-4 border-2 border-black bg-lime-300 text-black shadow-[4px_4px_0px_0px_#000] flex items-start justify-between space-x-3 animate-fade-in" role="alert">
                <div class="flex items-center space-x-2">
                    <i data-lucide="check-circle-2" class="w-6 h-6 text-black stroke-[2.5] flex-shrink-0"></i>
                    <div class="text-sm font-black">
                        {{ session('success') }}
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="p-1 border border-black bg-white hover:bg-black hover:text-white transition-colors">
                    <i data-lucide="x" class="w-4 h-4 stroke-[3]"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 border-2 border-black bg-rose-300 text-black shadow-[4px_4px_0px_0px_#000] flex items-start justify-between space-x-3 animate-fade-in" role="alert">
                <div class="flex items-center space-x-2">
                    <i data-lucide="alert-octagon" class="w-6 h-6 text-black stroke-[2.5] flex-shrink-0"></i>
                    <div class="text-sm font-black">
                        {{ session('error') }}
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="p-1 border border-black bg-white hover:bg-black hover:text-white transition-colors">
                    <i data-lucide="x" class="w-4 h-4 stroke-[3]"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Neo-Brutalism Footer -->
    <footer class="bg-white border-t-4 border-black py-6 mt-12 text-center text-xs font-bold text-slate-800">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center space-x-2">
                <span class="font-black text-black">SPK LAPTOP MAHASISWA IT</span>
                <span>•</span>
                <span class="px-2 py-0.5 bg-yellow-300 border-2 border-black shadow-[2px_2px_0px_0px_#000] text-[10px] font-black uppercase">Metode SAW</span>
            </div>
            <p class="font-semibold text-slate-600">Dukungan Skala Dinamis (Nilai & Isi) • Neo-Brutalism Precision Guidelines</p>
        </div>
    </footer>

    <!-- Paper Citation Info Modal -->
    <div x-show="showPaperInfo" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showPaperInfo" x-transition class="fixed inset-0 bg-black/60 backdrop-blur-xs" @click="showPaperInfo = false" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showPaperInfo" x-transition 
                class="inline-block align-bottom bg-white border-4 border-black shadow-[8px_8px_0px_0px_#000] text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                
                <div class="bg-yellow-300 border-b-2 border-black px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="book-open" class="w-6 h-6 text-black stroke-[2.5]"></i>
                        <h3 class="text-base font-black text-black uppercase tracking-tight" id="modal-title">Referensi & Landasan Makalah SAW</h3>
                    </div>
                    <button type="button" @click="showPaperInfo = false" class="p-1 border-2 border-black bg-white hover:bg-black hover:text-white transition-colors">
                        <i data-lucide="x" class="w-4 h-4 stroke-[3]"></i>
                    </button>
                </div>
                
                <div class="p-6 space-y-4 text-sm text-black">
                    <div>
                        <h4 class="font-black uppercase text-xs tracking-wider text-slate-700 mb-1">Judul Riset Acuan:</h4>
                        <div class="bg-slate-100 p-3.5 border-2 border-black shadow-[2px_2px_0px_0px_#000] font-bold text-black text-xs leading-relaxed">
                            "Sistem Pendukung Keputusan Pemilihan Laptop Terbaik Bagi Mahasiswa IT Menggunakan Metode Simple Additive Weighting (SAW)"
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-3.5 bg-yellow-50 border-2 border-black shadow-[2px_2px_0px_0px_#000]">
                            <h5 class="font-black text-black text-xs uppercase tracking-wide mb-2 flex items-center">
                                <span class="w-2 h-2 bg-black mr-1.5"></span> Kriteria Default (5)
                            </h5>
                            <ul class="text-xs font-semibold text-slate-800 space-y-1">
                                <li>• <strong>C1:</strong> Harga (Cost - 35%)</li>
                                <li>• <strong>C2:</strong> Berat (Cost - 5%)</li>
                                <li>• <strong>C3:</strong> CPU (Benefit - 25%)</li>
                                <li>• <strong>C4:</strong> Storage (Benefit - 15%)</li>
                                <li>• <strong>C5:</strong> RAM (Benefit - 20%)</li>
                            </ul>
                        </div>
                        <div class="p-3.5 bg-lime-50 border-2 border-black shadow-[2px_2px_0px_0px_#000]">
                            <h5 class="font-black text-black text-xs uppercase tracking-wide mb-2 flex items-center">
                                <span class="w-2 h-2 bg-black mr-1.5"></span> Alternatif Default (7)
                            </h5>
                            <ul class="text-xs font-semibold text-slate-800 space-y-1">
                                <li>• A1: HP 250 G6</li>
                                <li>• A2: Acer Aspire 3</li>
                                <li>• A3: Dell Inspiron 3567</li>
                                <li>• A4: Asus VivoBook Max</li>
                                <li>• A5: Lenovo IdeaPad 320</li>
                                <li>• A6: Acer Swift 3</li>
                                <li>• <strong>A7: Asus VivoBook A407 (Top #1)</strong></li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-3 bg-cyan-100 border-2 border-black shadow-[2px_2px_0px_0px_#000] text-xs font-bold text-black flex items-start space-x-2">
                        <i data-lucide="info" class="w-4 h-4 text-black stroke-[2.5] flex-shrink-0 mt-0.5"></i>
                        <span>Sistem ini mendukung <strong>CRUD Dinamis</strong>: Anda dapat menambah kriteria baru, mengubah bobot, serta <strong>mengubah angka dan isi skala kriteria</strong> kapan saja secara mandiri!</span>
                    </div>
                </div>

                <div class="bg-slate-50 border-t-2 border-black px-6 py-4 flex justify-end">
                    <button type="button" @click="showPaperInfo = false" class="neo-btn bg-black text-white hover:bg-slate-800">
                        Mengerti & Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    @yield('modals')

    <script>
        function spkWizardApp() {
            return {
                currentStep: {{ $currentStep ?? 1 }},
                showPaperInfo: false,
                showScaleGuide: false,
                
                // View Mode for Alternatives in Step 1: 'cards' or 'table'
                altViewMode: 'cards',

                // Alternative Modal State
                showAltModal: false,
                isEditAlt: false,
                altForm: {
                    id: null,
                    code: '',
                    name: '',
                    brand: '',
                    price_raw: '',
                    spec_summary: '',
                },
                altScores: {},

                // Criteria Modal State
                showCritModal: false,
                isEditCrit: false,
                critForm: {
                    id: null,
                    code: '',
                    name: '',
                    attribute: 'benefit',
                    weight: 0.1,
                    unit: '',
                    description: '',
                },

                // Scales Management Modal State (Ubah Angka & Isi Skala)
                showManageScalesModal: false,
                currentScaleCrit: {
                    id: null,
                    code: '',
                    name: '',
                    attribute: 'benefit',
                    weight: 0,
                    scales: []
                },

                activeTabStep1: 'alternatives', // 'alternatives' or 'criterias'
                
                // Navigation
                goToStep(step) {
                    this.currentStep = step;
                    const url = new URL(window.location);
                    url.searchParams.set('step', step);
                    window.history.pushState({}, '', url);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                        if (step === 3 && typeof window.renderCharts === 'function') {
                            window.renderCharts();
                        }
                    });
                },

                openAddAlternativeModal() {
                    this.isEditAlt = false;
                    this.altForm = {
                        id: null,
                        code: 'A{{ $alternatives->count() + 1 }}',
                        name: '',
                        brand: '',
                        price_raw: '',
                        spec_summary: '',
                    };
                    this.altScores = {};
                    @foreach($criterias as $crit)
                        @php
                            $defaultScore = $crit->scales->isNotEmpty() ? $crit->scales->first()->value : 3;
                        @endphp
                        this.altScores[{{ $crit->id }}] = {{ $defaultScore }};
                    @endforeach
                    this.showAltModal = true;
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },

                openEditAlternativeModal(alt, scores) {
                    this.isEditAlt = true;
                    this.altForm = {
                        id: alt.id,
                        code: alt.code,
                        name: alt.name,
                        brand: alt.brand || '',
                        price_raw: alt.price_raw || '',
                        spec_summary: alt.spec_summary || '',
                    };
                    this.altScores = scores || {};
                    this.showAltModal = true;
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },

                openAddCriteriaModal() {
                    this.isEditCrit = false;
                    this.critForm = {
                        id: null,
                        code: 'C{{ $criterias->count() + 1 }}',
                        name: '',
                        attribute: 'benefit',
                        weight: 0.10,
                        unit: '',
                        description: '',
                    };
                    this.showCritModal = true;
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },

                openEditCriteriaModal(crit) {
                    this.isEditCrit = true;
                    this.critForm = {
                        id: crit.id,
                        code: crit.code,
                        name: crit.name,
                        attribute: crit.attribute,
                        weight: crit.weight,
                        unit: crit.unit || '',
                        description: crit.description || '',
                    };
                    this.showCritModal = true;
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },

                // Open dedicated Scale Manager Modal (Ubah Angka & Isi Skala)
                openManageScalesModal(crit) {
                    let parsedScales = [];
                    if (crit.scales && crit.scales.length > 0) {
                        parsedScales = JSON.parse(JSON.stringify(crit.scales));
                    } else {
                        // Default template 5 rows
                        if (crit.attribute === 'cost') {
                            parsedScales = [
                                { value: 1, label: '< Rp 4.000.000 / Sangat Ringan (Paling Menguntungkan)', description: 'Tingkat terbaik' },
                                { value: 2, label: 'Rp 4.000.000 - Rp 6.000.000 / Ringan', description: 'Tingkat baik' },
                                { value: 3, label: 'Rp 6.000.000 - Rp 8.000.000 / Sedang', description: 'Tingkat standar' },
                                { value: 4, label: 'Rp 8.000.000 - Rp 10.000.000 / Berat', description: 'Tingkat kurang ideal' },
                                { value: 5, label: '> Rp 10.000.000 / Sangat Berat', description: 'Tingkat paling memberatkan' },
                            ];
                        } else {
                            parsedScales = [
                                { value: 5, label: 'Sangat Tinggi / Maksimal (Paling Menguntungkan)', description: 'Performa / kapasitas tertinggi' },
                                { value: 4, label: 'Tinggi / Cepat', description: 'Performa di atas rata-rata' },
                                { value: 3, label: 'Sedang / Cukup', description: 'Standar memadai' },
                                { value: 2, label: 'Rendah / Kurang', description: 'Performa minimal' },
                                { value: 1, label: 'Sangat Rendah / Sangat Kurang', description: 'Entry level dasar' },
                            ];
                        }
                    }

                    this.currentScaleCrit = {
                        id: crit.id,
                        code: crit.code,
                        name: crit.name,
                        attribute: crit.attribute,
                        weight: crit.weight,
                        scales: parsedScales
                    };

                    this.showScaleGuide = false;
                    this.showManageScalesModal = true;
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },

                addScaleRow() {
                    let nextVal = 1;
                    if (this.currentScaleCrit.scales.length > 0) {
                        const vals = this.currentScaleCrit.scales.map(s => Number(s.value) || 0);
                        nextVal = Math.max(...vals) + 1;
                    }
                    this.currentScaleCrit.scales.unshift({
                        value: nextVal,
                        label: '',
                        description: ''
                    });
                    this.$nextTick(() => {
                        if (window.lucide) lucide.createIcons();
                    });
                },

                removeScaleRow(index) {
                    if (this.currentScaleCrit.scales.length <= 1) {
                        alert('Kriteria minimal harus memiliki setidaknya 1 tingkat skala penilaian.');
                        return;
                    }
                    this.currentScaleCrit.scales.splice(index, 1);
                },

                resetScalesTemplate(type = 'default') {
                    if (this.currentScaleCrit.attribute === 'cost') {
                        this.currentScaleCrit.scales = [
                            { value: 1, label: 'Sangat Rendah / Sangat Murah / Sangat Ringan (Optimal)', description: 'Tingkat terbaik kriteria cost' },
                            { value: 2, label: 'Rendah / Murah / Ringan (Baik)', description: 'Tingkat baik' },
                            { value: 3, label: 'Sedang / Rata-rata (Standar)', description: 'Tingkat standar' },
                            { value: 4, label: 'Tinggi / Mahal / Berat', description: 'Tingkat kurang ideal' },
                            { value: 5, label: 'Sangat Tinggi / Sangat Mahal / Sangat Berat', description: 'Tingkat paling memberatkan' }
                        ];
                    } else {
                        this.currentScaleCrit.scales = [
                            { value: 5, label: 'Sangat Tinggi / Maksimal (Optimal)', description: 'Performa / kapasitas tertinggi' },
                            { value: 4, label: 'Tinggi / Unggul', description: 'Performa di atas rata-rata' },
                            { value: 3, label: 'Sedang / Cukup', description: 'Standar memadai harian' },
                            { value: 2, label: 'Rendah / Minimal', description: 'Performa dasar' },
                            { value: 1, label: 'Sangat Rendah / Terbatas', description: 'Tingkat paling dasar' }
                        ];
                    }
                },

                confirmReset() {
                    Swal.fire({
                        title: 'RESET KE DATA MAKALA NAW?',
                        text: 'Seluruh kriteria, bobot, skala, dan data alternatif laptop akan dikembalikan ke dataset default acuan makalah (C1-C5 & A1-A7).',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'YA, RESET SEKARANG',
                        cancelButtonText: 'BATAL',
                        buttonsStyling: false,
                        customClass: {
                            popup: 'border-4 border-black shadow-[8px_8px_0px_0px_#000] rounded-none bg-white p-6',
                            title: 'font-black text-black uppercase tracking-tight text-xl',
                            htmlContainer: 'text-sm font-semibold text-slate-700',
                            confirmButton: 'neo-btn bg-yellow-300 text-black mx-2',
                            cancelButton: 'neo-btn bg-white text-black mx-2'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('resetDefaultForm').submit();
                        }
                    });
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
