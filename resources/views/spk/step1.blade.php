<div class="space-y-6">

    <!-- Step 1 Header & Quick Stats (AgentUI: Strict Symmetrical Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        
        <div class="neo-box p-5 bg-white flex items-center space-x-4">
            <div class="w-12 h-12 bg-yellow-300 border-2 border-black shadow-[2px_2px_0px_0px_#000] flex items-center justify-center font-black">
                <i data-lucide="sliders" class="w-6 h-6 stroke-[2.5]"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-wider text-slate-700">Total Kriteria</p>
                <div class="flex items-baseline space-x-2">
                    <span class="text-2xl font-black text-black">{{ $criterias->count() }}</span>
                    <span class="text-xs font-bold text-slate-600">Kriteria Aktif</span>
                </div>
            </div>
        </div>

        <div class="neo-box p-5 bg-white flex items-center space-x-4">
            <div class="w-12 h-12 bg-lime-300 border-2 border-black shadow-[2px_2px_0px_0px_#000] flex items-center justify-center font-black">
                <i data-lucide="percent" class="w-6 h-6 stroke-[2.5]"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-wider text-slate-700">Total Bobot (W)</p>
                <div class="flex items-baseline space-x-2">
                    <span class="text-2xl font-black {{ abs($criterias->sum('weight') - 1.0) < 0.01 ? 'text-black' : 'text-amber-600' }}">
                        {{ number_format($criterias->sum('weight'), 2) }}
                    </span>
                    <span class="text-xs font-bold {{ abs($criterias->sum('weight') - 1.0) < 0.01 ? 'text-emerald-700' : 'text-amber-600' }}">
                        ({{ round($criterias->sum('weight') * 100) }}%)
                    </span>
                </div>
            </div>
        </div>

        <div class="neo-box p-5 bg-white flex items-center space-x-4">
            <div class="w-12 h-12 bg-cyan-300 border-2 border-black shadow-[2px_2px_0px_0px_#000] flex items-center justify-center font-black">
                <i data-lucide="laptop" class="w-6 h-6 stroke-[2.5]"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-wider text-slate-700">Alternatif Laptop</p>
                <div class="flex items-baseline space-x-2">
                    <span class="text-2xl font-black text-black">{{ $alternatives->count() }}</span>
                    <span class="text-xs font-bold text-slate-600">Laptop Pilihan</span>
                </div>
            </div>
        </div>

        <div class="neo-box p-5 bg-white flex items-center space-x-4">
            <div class="w-12 h-12 bg-violet-300 border-2 border-black shadow-[2px_2px_0px_0px_#000] flex items-center justify-center font-black">
                <i data-lucide="scale" class="w-6 h-6 stroke-[2.5]"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-wider text-slate-700">Tipe Atribut</p>
                <div class="flex items-center space-x-1.5 text-[11px] font-black text-black mt-0.5">
                    <span class="px-1.5 py-0.5 bg-lime-200 border border-black">{{ $criterias->where('attribute', 'benefit')->count() }} Benefit</span>
                    <span class="px-1.5 py-0.5 bg-amber-200 border border-black">{{ $criterias->where('attribute', 'cost')->count() }} Cost</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Tab Selector (Alternatif vs Kriteria) + Action Buttons -->
    <div class="neo-box p-3 sm:p-4 bg-white mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
        
        <!-- Left: Tab Switcher -->
        <div class="flex items-center space-x-2 w-full md:w-auto">
            <button type="button" @click="activeTabStep1 = 'alternatives'"
                class="flex-1 md:flex-initial neo-btn-sm"
                :class="activeTabStep1 === 'alternatives' ? 'bg-yellow-300 text-black shadow-[3px_3px_0px_0px_#000]' : 'bg-white text-slate-700 shadow-[2px_2px_0px_0px_#000]'">
                <i data-lucide="laptop" class="w-4 h-4 mr-1.5 stroke-[2.5]"></i>
                <span>Data Laptop Alternatif ({{ $alternatives->count() }})</span>
            </button>
            <button type="button" @click="activeTabStep1 = 'criterias'"
                class="flex-1 md:flex-initial neo-btn-sm"
                :class="activeTabStep1 === 'criterias' ? 'bg-yellow-300 text-black shadow-[3px_3px_0px_0px_#000]' : 'bg-white text-slate-700 shadow-[2px_2px_0px_0px_#000]'">
                <i data-lucide="sliders" class="w-4 h-4 mr-1.5 stroke-[2.5]"></i>
                <span>Kriteria & Skala Penilaian ({{ $criterias->count() }})</span>
            </button>
        </div>

        <!-- Right: Actions based on active tab -->
        <div class="flex items-center space-x-2 w-full md:w-auto justify-end">
            <template x-if="activeTabStep1 === 'alternatives'">
                <div class="flex items-center space-x-2 w-full md:w-auto justify-end">
                    <!-- Toggle View Mode: Grid Cards vs Table -->
                    <div class="hidden sm:flex items-center border-2 border-black bg-slate-100 p-0.5">
                        <button type="button" @click="altViewMode = 'cards'" 
                            class="px-2.5 py-1 text-xs font-bold transition-all flex items-center space-x-1"
                            :class="altViewMode === 'cards' ? 'bg-black text-white' : 'text-slate-700 hover:text-black'">
                            <i data-lucide="layout-grid" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                            <span>Kartu</span>
                        </button>
                        <button type="button" @click="altViewMode = 'table'" 
                            class="px-2.5 py-1 text-xs font-bold transition-all flex items-center space-x-1"
                            :class="altViewMode === 'table' ? 'bg-black text-white' : 'text-slate-700 hover:text-black'">
                            <i data-lucide="table" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                            <span>Tabel</span>
                        </button>
                    </div>

                    <!-- Add Alternative Button -->
                    <button type="button" @click="openAddAlternativeModal()" class="neo-btn bg-lime-300 hover:bg-lime-400 text-black">
                        <i data-lucide="plus-circle" class="w-4 h-4 mr-1.5 stroke-[2.5]"></i>
                        <span>Tambah Laptop Baru</span>
                    </button>
                </div>
            </template>

            <template x-if="activeTabStep1 === 'criterias'">
                <div class="flex items-center space-x-2 w-full md:w-auto justify-end">
                    <button type="button" @click="showScaleGuide = true" class="neo-btn-sm bg-white hover:bg-slate-100 text-black">
                        <i data-lucide="help-circle" class="w-4 h-4 mr-1.5 stroke-[2.5]"></i>
                        <span>Panduan Skala Lengkap</span>
                    </button>
                    <button type="button" @click="openAddCriteriaModal()" class="neo-btn bg-yellow-300 hover:bg-yellow-400 text-black">
                        <i data-lucide="plus-circle" class="w-4 h-4 mr-1.5 stroke-[2.5]"></i>
                        <span>Tambah Kriteria Baru</span>
                    </button>
                </div>
            </template>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- TAB 1: DATA ALTERNATIF LAPTOP -->
    <!-- ========================================== -->
    <div x-show="activeTabStep1 === 'alternatives'" class="space-y-6">

        <!-- VIEW MODE 1: GRID CARDS (AgentUI Section 2.B: Equal Height Cards) -->
        <div x-show="altViewMode === 'cards'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($alternatives as $alt)
                <div class="neo-box p-5 bg-white h-full flex flex-col justify-between hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#000] transition-all">
                    
                    <!-- Card Top: Badges & Brand -->
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div class="flex items-center space-x-1.5">
                                <span class="neo-badge bg-black text-white text-xs">
                                    {{ $alt->code }}
                                </span>
                                @if($alt->brand)
                                    <span class="neo-badge bg-slate-100 text-black text-[11px]">
                                        {{ $alt->brand }}
                                    </span>
                                @endif
                            </div>

                            @if($alt->code === 'A7')
                                <span class="neo-badge bg-lime-300 text-black text-[10px] animate-pulse">
                                    ⭐ Target Makalah
                                </span>
                            @else
                                <span class="neo-badge bg-yellow-100 text-black text-[10px]">
                                    Alternatif
                                </span>
                            @endif
                        </div>

                        <!-- Title & Specs (AgentUI: font-bold text-lg, Subteks text-sm) -->
                        <h4 class="font-black text-lg text-black tracking-tight leading-snug">
                            {{ $alt->name }}
                        </h4>
                        
                        <p class="text-sm font-semibold text-slate-600 mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $alt->spec_summary ?? 'Spesifikasi standar laptop untuk pemrograman dan tugas kuliah IT.' }}
                        </p>

                        <!-- Price Tag -->
                        @if($alt->price_raw)
                            <div class="mt-3">
                                <span class="inline-block px-2.5 py-1 bg-yellow-200 border-2 border-black font-black text-xs shadow-[2px_2px_0px_0px_#000]">
                                    💰 Est. Rp {{ number_format($alt->price_raw, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif

                        <!-- Criteria Scores Grid Preview -->
                        <div class="mt-4 pt-3 border-t-2 border-black">
                            <p class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-2">Nilai Kriteria Aktif ($x_{ij}$):</p>
                            <div class="grid grid-cols-5 gap-1.5 text-center">
                                @foreach($criterias as $crit)
                                    @php
                                        $val = $alt->getScoreForCriteria($crit->id);
                                    @endphp
                                    <div class="border border-black bg-slate-50 p-1">
                                        <div class="text-[9px] font-bold text-slate-600 truncate">{{ $crit->code }}</div>
                                        <div class="text-xs font-black text-black">{{ $val }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Card Bottom: Symmetrical Action Buttons -->
                    <div class="mt-5 pt-3 border-t-2 border-black flex items-center justify-between gap-2">
                        <button type="button" @click="openEditAlternativeModal({{ json_encode($alt) }}, {{ json_encode($alt->scores->pluck('score', 'criteria_id')) }})" 
                            class="flex-1 neo-btn-sm bg-yellow-300 hover:bg-yellow-400 text-black">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5 mr-1 stroke-[2.5]"></i>
                            <span>Edit Nilai</span>
                        </button>
                        
                        <form action="{{ route('alternatives.destroy', $alt->id) }}" method="POST" onsubmit="return confirm('Hapus alternatif {{ $alt->code }} - {{ $alt->name }}?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="neo-btn-sm bg-rose-300 hover:bg-rose-400 text-black px-2.5" title="Hapus Laptop">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="col-span-full neo-box p-12 bg-white text-center">
                    <i data-lucide="inbox" class="w-12 h-12 mx-auto text-black stroke-[2] mb-3"></i>
                    <h4 class="text-base font-black text-black uppercase">Belum ada alternatif laptop</h4>
                    <p class="text-xs font-semibold text-slate-600 mt-1">Gunakan tombol "Tambah Laptop Baru" atau "Reset ke Data Makalah".</p>
                </div>
            @endforelse
        </div>

        <!-- VIEW MODE 2: TABULAR MATRIX VIEW -->
        <div x-show="altViewMode === 'table'" class="neo-box bg-white overflow-hidden">
            <div class="px-6 py-4 border-b-2 border-black bg-yellow-300 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-black uppercase tracking-tight">Tabel Alternatif Laptop & Nilai ($x_{ij}$)</h3>
                    <p class="text-xs font-bold text-slate-800">Menampilkan matriks nilai numerik laptop terhadap masing-masing kriteria.</p>
                </div>
                <span class="neo-badge bg-black text-white text-xs">{{ $alternatives->count() }} Laptop</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-slate-100 border-b-2 border-black text-xs font-black text-black uppercase tracking-wider">
                            <th class="py-3 px-4 border-r-2 border-black text-center w-16">Kode</th>
                            <th class="py-3 px-4 border-r-2 border-black min-w-[200px]">Nama Laptop</th>
                            <th class="py-3 px-4 border-r-2 border-black min-w-[220px]">Spesifikasi & Harga</th>
                            @foreach($criterias as $crit)
                                <th class="py-3 px-3 border-r-2 border-black text-center min-w-[90px]">
                                    <div class="font-black text-black">{{ $crit->code }}</div>
                                    <div class="text-[10px] font-semibold text-slate-600 capitalize">{{ $crit->name }}</div>
                                </th>
                            @endforeach
                            <th class="py-3 px-4 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black">
                        @foreach($alternatives as $alt)
                            <tr class="hover:bg-yellow-50/60 transition-colors">
                                <td class="py-3.5 px-4 border-r-2 border-black text-center">
                                    <span class="neo-badge bg-black text-white text-xs">
                                        {{ $alt->code }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 border-r-2 border-black">
                                    <div class="font-black text-black">{{ $alt->name }}</div>
                                    @if($alt->brand)
                                        <div class="text-xs font-bold text-slate-600">{{ $alt->brand }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 border-r-2 border-black text-xs font-semibold text-slate-700">
                                    {{ $alt->spec_summary ?? '-' }}
                                    @if($alt->price_raw)
                                        <div class="font-black text-black mt-1">Est. Rp {{ number_format($alt->price_raw, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                                @foreach($criterias as $crit)
                                    @php
                                        $score = $alt->getScoreForCriteria($crit->id);
                                    @endphp
                                    <td class="py-3.5 px-3 border-r-2 border-black text-center">
                                        <span class="inline-block px-2.5 py-1 text-xs font-black bg-white border-2 border-black shadow-[2px_2px_0px_0px_#000]">
                                            {{ $score }}
                                        </span>
                                    </td>
                                @endforeach
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="button" @click="openEditAlternativeModal({{ json_encode($alt) }}, {{ json_encode($alt->scores->pluck('score', 'criteria_id')) }})" 
                                            class="neo-btn-sm bg-yellow-300 hover:bg-yellow-400 text-black px-2 py-1" title="Edit Alternatif">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                                        </button>
                                        <form action="{{ route('alternatives.destroy', $alt->id) }}" method="POST" onsubmit="return confirm('Hapus {{ $alt->code }} - {{ $alt->name }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="neo-btn-sm bg-rose-300 hover:bg-rose-400 text-black px-2 py-1" title="Hapus">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- TAB 2: DATA KRITERIA & SKALA PENILAIAN -->
    <!-- ========================================== -->
    <div x-show="activeTabStep1 === 'criterias'" class="space-y-6">
        
        <!-- Explanation Banner -->
        <div class="neo-box p-4 bg-cyan-100 text-black flex items-start space-x-3">
            <i data-lucide="info" class="w-5 h-5 stroke-[2.5] flex-shrink-0 mt-0.5"></i>
            <div class="text-xs font-bold leading-relaxed">
                <strong>Pengaturan Fleksibel Kriteria & Skala:</strong> Anda dapat mengubah data kriteria, bobot, dan atribut (Benefit/Cost). Pada kolom <strong>"Tingkat Skala Penilaian"</strong>, klik tombol <strong>"⚙️ Kelola Skala"</strong> untuk mengubah angka nilai sekaligus teks isi/label kriteria secara bebas!
            </div>
        </div>

        <div class="neo-box bg-white overflow-hidden">
            <div class="px-6 py-4 border-b-2 border-black bg-yellow-300 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-black uppercase tracking-tight">Daftar Kriteria Penilaian & Sub-Skala</h3>
                    <p class="text-xs font-bold text-slate-800">Setiap kriteria memiliki skala tingkat yang dapat disesuaikan isinya sesuai kebutuhan.</p>
                </div>
                <span class="neo-badge bg-black text-white text-xs">{{ $criterias->count() }} Kriteria</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-slate-100 border-b-2 border-black text-xs font-black text-black uppercase tracking-wider">
                            <th class="py-3 px-4 border-r-2 border-black text-center w-16">Kode</th>
                            <th class="py-3 px-4 border-r-2 border-black min-w-[160px]">Nama Kriteria</th>
                            <th class="py-3 px-4 border-r-2 border-black text-center w-28">Atribut</th>
                            <th class="py-3 px-4 border-r-2 border-black text-center w-28">Bobot (W)</th>
                            <th class="py-3 px-4 border-r-2 border-black min-w-[280px]">Skala Penilaian (Nilai & Isi)</th>
                            <th class="py-3 px-4 border-r-2 border-black min-w-[160px]">Deskripsi</th>
                            <th class="py-3 px-4 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black">
                        @forelse($criterias as $crit)
                            <tr class="hover:bg-yellow-50/60 transition-colors">
                                <!-- Kode -->
                                <td class="py-4 px-4 border-r-2 border-black text-center">
                                    <span class="neo-badge bg-black text-yellow-300 text-xs">
                                        {{ $crit->code }}
                                    </span>
                                </td>

                                <!-- Nama & Satuan -->
                                <td class="py-4 px-4 border-r-2 border-black">
                                    <div class="font-black text-black text-base">{{ $crit->name }}</div>
                                    <div class="text-xs font-bold text-slate-600 mt-0.5">{{ $crit->unit ?? 'Tanpa satuan' }}</div>
                                </td>

                                <!-- Atribut -->
                                <td class="py-4 px-4 border-r-2 border-black text-center">
                                    @if($crit->isBenefit())
                                        <span class="neo-badge bg-lime-300 text-black text-xs">
                                            <i data-lucide="trending-up" class="w-3.5 h-3.5 mr-1 stroke-[2.5]"></i> Benefit
                                        </span>
                                    @else
                                        <span class="neo-badge bg-amber-300 text-black text-xs">
                                            <i data-lucide="trending-down" class="w-3.5 h-3.5 mr-1 stroke-[2.5]"></i> Cost
                                        </span>
                                    @endif
                                </td>

                                <!-- Bobot -->
                                <td class="py-4 px-4 border-r-2 border-black text-center">
                                    <div class="font-black text-black text-base">{{ number_format($crit->weight, 2) }}</div>
                                    <div class="text-[11px] font-bold text-slate-600">({{ round($crit->weight * 100) }}%)</div>
                                </td>

                                <!-- Skala Penilaian (Nilai & Isi) -->
                                <td class="py-4 px-4 border-r-2 border-black">
                                    <div class="space-y-2">
                                        <!-- Main CTA to open dedicated scale manager modal -->
                                        <div class="flex items-center space-x-2">
                                            <button type="button" @click="openManageScalesModal({{ json_encode($crit) }})" 
                                                class="neo-btn-sm bg-emerald-300 hover:bg-emerald-400 text-black font-black tracking-tight"
                                                title="Klik untuk mengubah nilai angka dan teks isi skala ini">
                                                <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5 mr-1.5 stroke-[2.5]"></i>
                                                <span>Kelola Skala ({{ $crit->scales->count() }} Opsi) ✏️</span>
                                            </button>
                                        </div>

                                        <!-- Quick preview of first 3 scales -->
                                        @if($crit->scales->isNotEmpty())
                                            <div class="flex flex-wrap gap-1 text-[11px]">
                                                @foreach($crit->scales->take(3) as $sc)
                                                    <span class="px-1.5 py-0.5 border border-black bg-white font-semibold text-slate-800">
                                                        <strong>[{{ $sc->value }}]</strong> {{ Str::limit($sc->label, 24) }}
                                                    </span>
                                                @endforeach
                                                @if($crit->scales->count() > 3)
                                                    <span class="px-1.5 py-0.5 border border-black bg-slate-200 font-bold text-slate-700">
                                                        +{{ $crit->scales->count() - 3 }} lainnya
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-rose-600 font-bold italic">Belum ada tingkat skala.</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Deskripsi -->
                                <td class="py-4 px-4 border-r-2 border-black text-xs font-semibold text-slate-700">
                                    {{ $crit->description ?? '-' }}
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Kelola Skala -->
                                        <button type="button" @click="openManageScalesModal({{ json_encode($crit) }})" 
                                            class="neo-btn-sm bg-emerald-300 hover:bg-emerald-400 text-black px-2 py-1" title="Ubah Nilai & Isi Skala">
                                            <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                                        </button>
                                        <!-- Edit Kriteria -->
                                        <button type="button" @click="openEditCriteriaModal({{ json_encode($crit) }})" 
                                            class="neo-btn-sm bg-yellow-300 hover:bg-yellow-400 text-black px-2 py-1" title="Edit Kriteria">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                                        </button>
                                        <!-- Hapus Kriteria -->
                                        <form action="{{ route('criterias.destroy', $crit->id) }}" method="POST" onsubmit="return confirm('Hapus kriteria {{ $crit->code }} - {{ $crit->name }}? Seluruh nilai terkait akan ikut terhapus.')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="neo-btn-sm bg-rose-300 hover:bg-rose-400 text-black px-2 py-1" title="Hapus">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-500 font-bold">
                                    Belum ada kriteria penilaian terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Step 1 Bottom Action Bar (AgentUI Section 3.A: Symmetrical Navigation) -->
    <div class="neo-box p-5 bg-white mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <!-- Left: Status note -->
        <div class="text-xs font-bold text-slate-800 text-center sm:text-left flex items-center space-x-2">
            <span class="w-3 h-3 bg-lime-300 border border-black inline-block"></span>
            <span><strong>Tahap 1 Siap:</strong> Seluruh data alternatif dan kriteria telah terekam. Lanjutkan untuk meninjau bobot dan normalisasi matriks SAW.</span>
        </div>

        <!-- Right: Forward button -->
        <div class="flex items-center space-x-3 w-full sm:w-auto justify-end">
            <button type="button" @click="goToStep(2)" class="w-full sm:w-auto neo-btn bg-yellow-300 hover:bg-yellow-400 text-black">
                <span>Lanjut ke Langkah 2: Matriks Normalisasi (R)</span>
                <i data-lucide="arrow-right" class="w-4 h-4 ml-2 stroke-[3]"></i>
            </button>
        </div>

    </div>

</div>
