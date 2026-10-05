<!-- SPK MODALS COMPONENT (NEO-BRUTALISM UI) -->
<div>

    <!-- ========================================================================= -->
    <!-- 1. MODAL ADD / EDIT ALTERNATIVE LAPTOP                                   -->
    <!-- ========================================================================= -->
    <div x-show="showAltModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-alt-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showAltModal" x-transition class="fixed inset-0 bg-black/60 backdrop-blur-xs" @click="showAltModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="showAltModal" x-transition 
                class="inline-block align-bottom bg-white border-4 border-black shadow-[8px_8px_0px_0px_#000] text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                
                <form :action="isEditAlt ? '/alternatives/' + altForm.id : '{{ route('alternatives.store') }}'" method="POST">
                    @csrf
                    <template x-if="isEditAlt">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <!-- Modal Header -->
                    <div class="bg-yellow-300 border-b-2 border-black px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-black text-yellow-300 flex items-center justify-center border-2 border-black font-black">
                                <i data-lucide="laptop" class="w-5 h-5 stroke-[2.5]"></i>
                            </div>
                            <h3 class="text-base font-black text-black uppercase tracking-tight" id="modal-alt-title" 
                                x-text="isEditAlt ? 'Edit Data Laptop Alternatif' : 'Tambah Laptop Alternatif Baru'"></h3>
                        </div>
                        <button type="button" @click="showAltModal = false" class="p-1 border-2 border-black bg-white hover:bg-black hover:text-white transition-colors">
                            <i data-lucide="x" class="w-4 h-4 stroke-[3]"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto">
                        
                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Kode Alternatif *</label>
                                <input type="text" name="code" x-model="altForm.code" required placeholder="A8"
                                    class="neo-input font-black uppercase">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Nama Laptop *</label>
                                <input type="text" name="name" x-model="altForm.name" required placeholder="Contoh: Asus VivoBook 14"
                                    class="neo-input font-bold">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Brand / Merk</label>
                                <input type="text" name="brand" x-model="altForm.brand" placeholder="Asus, Acer, Lenovo, HP, Dell, dll"
                                    class="neo-input font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Estimasi Harga Riil (Rp)</label>
                                <input type="number" step="100000" name="price_raw" x-model="altForm.price_raw" placeholder="Contoh: 6500000"
                                    class="neo-input font-mono font-bold">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Spesifikasi Ringkas</label>
                            <textarea name="spec_summary" x-model="altForm.spec_summary" rows="2" placeholder="Prosesor, RAM, Penyimpanan, Ukuran Layar, Bobot..."
                                class="neo-input font-medium"></textarea>
                        </div>

                        <!-- Dynamic Criteria Scores Section -->
                        <div class="pt-4 border-t-2 border-black">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-xs font-black uppercase tracking-wider text-black flex items-center space-x-1.5">
                                    <i data-lucide="sliders" class="w-4 h-4 text-black stroke-[2.5]"></i>
                                    <span>Penilaian Kriteria ($x_{ij}$) Menggunakan Skala</span>
                                </h4>
                                <span class="text-[11px] font-bold text-slate-600">Menyesuaikan skala aktif</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 border-2 border-black bg-slate-50 shadow-[3px_3px_0px_0px_#000]">
                                @foreach($criterias as $crit)
                                    <div class="bg-white p-3 border-2 border-black shadow-[2px_2px_0px_0px_#000] space-y-1.5">
                                        <div class="flex items-center justify-between">
                                            <span class="neo-badge bg-black text-yellow-300 text-[11px]">
                                                {{ $crit->code }}
                                            </span>
                                            <span class="neo-badge {{ $crit->isBenefit() ? 'bg-lime-200' : 'bg-amber-200' }} text-[10px]">
                                                {{ $crit->attribute }} ({{ round($crit->weight * 100) }}%)
                                            </span>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-xs font-black text-black">{{ $crit->name }}</label>
                                            <p class="text-[10px] font-bold text-slate-500 truncate">{{ $crit->unit ?? 'Tingkat skala' }}</p>
                                        </div>

                                        @if($crit->scales->isNotEmpty())
                                            <!-- Select dropdown with predefined sub-criteria scales -->
                                            <select name="scores[{{ $crit->id }}]" x-model="altScores[{{ $crit->id }}]" required
                                                class="neo-input mt-1 text-xs font-bold py-1.5 cursor-pointer">
                                                <option value="" disabled>-- Pilih Tingkat Nilai & Isi Skala --</option>
                                                @foreach($crit->scales as $scale)
                                                    <option value="{{ $scale->value }}">
                                                        Skala {{ $scale->value }} : {{ $scale->label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <!-- Generic numeric input if no scales -->
                                            <input type="number" step="any" name="scores[{{ $crit->id }}]" x-model="altScores[{{ $crit->id }}]" required placeholder="Masukkan angka skor"
                                                class="neo-input mt-1 text-xs font-bold py-1.5">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-slate-100 border-t-2 border-black px-6 py-4 flex items-center justify-between">
                        <button type="button" @click="showAltModal = false" class="neo-btn bg-white hover:bg-slate-200 text-black">
                            Batal
                        </button>
                        <button type="submit" class="neo-btn bg-yellow-300 hover:bg-yellow-400 text-black">
                            <i data-lucide="check" class="w-4 h-4 mr-1.5 stroke-[3]"></i>
                            <span x-text="isEditAlt ? 'Simpan Perubahan' : 'Tambahkan Laptop'"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- 2. MODAL ADD / EDIT CRITERIA                                             -->
    <!-- ========================================================================= -->
    <div x-show="showCritModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-crit-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showCritModal" x-transition class="fixed inset-0 bg-black/60 backdrop-blur-xs" @click="showCritModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="showCritModal" x-transition 
                class="inline-block align-bottom bg-white border-4 border-black shadow-[8px_8px_0px_0px_#000] text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form :action="isEditCrit ? '/criterias/' + critForm.id : '{{ route('criterias.store') }}'" method="POST">
                    @csrf
                    <template x-if="isEditCrit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <!-- Modal Header -->
                    <div class="bg-yellow-300 border-b-2 border-black px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-black text-yellow-300 flex items-center justify-center border-2 border-black font-black">
                                <i data-lucide="sliders" class="w-5 h-5 stroke-[2.5]"></i>
                            </div>
                            <h3 class="text-base font-black text-black uppercase tracking-tight" id="modal-crit-title" 
                                x-text="isEditCrit ? 'Edit Kriteria Penilaian' : 'Tambah Kriteria Penilaian Baru'"></h3>
                        </div>
                        <button type="button" @click="showCritModal = false" class="p-1 border-2 border-black bg-white hover:bg-black hover:text-white transition-colors">
                            <i data-lucide="x" class="w-4 h-4 stroke-[3]"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Kode *</label>
                                <input type="text" name="code" x-model="critForm.code" required placeholder="C6"
                                    class="neo-input font-black uppercase">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Nama Kriteria *</label>
                                <input type="text" name="name" x-model="critForm.name" required placeholder="Contoh: Daya Tahan Baterai"
                                    class="neo-input font-bold">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Atribut Kriteria *</label>
                                <select name="attribute" x-model="critForm.attribute" required class="neo-input font-bold cursor-pointer">
                                    <option value="benefit">Benefit (Makin Besar Makin Baik)</option>
                                    <option value="cost">Cost (Makin Kecil Makin Baik)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Bobot Default (0 - 1.0)</label>
                                <input type="number" step="0.01" min="0" max="1" name="weight" x-model="critForm.weight" required placeholder="0.10"
                                    class="neo-input font-mono font-bold">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Satuan / Unit Ukur</label>
                            <input type="text" name="unit" x-model="critForm.unit" placeholder="Contoh: Jam / GB / Skala 1-5"
                                class="neo-input font-semibold">
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-black mb-1">Deskripsi / Penjelasan</label>
                            <textarea name="description" x-model="critForm.description" rows="2" placeholder="Jelaskan pengaruh kriteria ini bagi pemilihan laptop..."
                                class="neo-input font-medium"></textarea>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-slate-100 border-t-2 border-black px-6 py-4 flex items-center justify-between">
                        <button type="button" @click="showCritModal = false" class="neo-btn bg-white hover:bg-slate-200 text-black">
                            Batal
                        </button>
                        <button type="submit" class="neo-btn bg-yellow-300 hover:bg-yellow-400 text-black">
                            <i data-lucide="check" class="w-4 h-4 mr-1.5 stroke-[3]"></i>
                            <span x-text="isEditCrit ? 'Simpan Kriteria' : 'Tambah Kriteria'"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- 3. MODAL KELOLA SKALA PENILAIAN SUB-KRITERIA (ANGKA & ISI)                -->
    <!-- USER REQUIREMENT: "skala pada masing masing kriteria bisa diubah,         -->
    <!-- bukan hanya mengubah angkanya tetapi isinya juga"                         -->
    <!-- ========================================================================= -->
    <div x-show="showManageScalesModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-manage-scales-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showManageScalesModal" x-transition class="fixed inset-0 bg-black/60 backdrop-blur-xs" @click="showManageScalesModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="showManageScalesModal" x-transition 
                class="inline-block align-bottom bg-white border-4 border-black shadow-[8px_8px_0px_0px_#000] text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                
                <form :action="'/criterias/' + currentScaleCrit.id + '/scales/batch'" method="POST">
                    @csrf
                    <input type="hidden" name="redirect_step" :value="currentStep">

                    <!-- Modal Header -->
                    <div class="bg-yellow-300 border-b-2 border-black px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-9 h-9 bg-black text-yellow-300 flex items-center justify-center border-2 border-black font-black">
                                <i data-lucide="sliders-horizontal" class="w-5 h-5 stroke-[2.5]"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-black uppercase tracking-tight" id="modal-manage-scales-title">
                                    Kelola Skala Penilaian Kriteria
                                </h3>
                                <p class="text-xs font-bold text-slate-800">
                                    <span x-text="currentScaleCrit.code"></span> - <span x-text="currentScaleCrit.name"></span>
                                    (<span class="uppercase" x-text="currentScaleCrit.attribute"></span>)
                                </p>
                            </div>
                        </div>
                        <button type="button" @click="showManageScalesModal = false" class="p-1 border-2 border-black bg-white hover:bg-black hover:text-white transition-colors">
                            <i data-lucide="x" class="w-4 h-4 stroke-[3]"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto">
                        
                        <!-- Prominent Instructions Banner -->
                        <div class="p-3.5 border-2 border-black bg-cyan-100 shadow-[3px_3px_0px_0px_#000] text-xs font-bold text-black flex items-start space-x-2.5">
                            <i data-lucide="info" class="w-5 h-5 stroke-[2.5] flex-shrink-0 mt-0.5"></i>
                            <div>
                                <p class="font-black uppercase text-[11px] mb-0.5">Ubah Angka & Isi Teks Skala Bebas:</p>
                                <p>Anda dapat mengubah <strong>angka nilai skala</strong> (skor numerik untuk perhitungan normalisasi SAW) serta <strong>isinya</strong> (label teks pilihan, rentang harga/spesifikasi, dan keterangan). Anda juga dapat menambah baris baru atau menghapus baris skala.</p>
                            </div>
                        </div>

                        <!-- Table Header for Scale Items -->
                        <div class="border-2 border-black overflow-hidden shadow-[3px_3px_0px_0px_#000]">
                            <div class="bg-black text-white px-4 py-2.5 text-xs font-black uppercase tracking-wider grid grid-cols-12 gap-3 items-center">
                                <div class="col-span-3 sm:col-span-2 text-center">Angka Nilai *</div>
                                <div class="col-span-8 sm:col-span-5">Label / Isi Skala (Pilihan) *</div>
                                <div class="hidden sm:block sm:col-span-4">Keterangan / Penjelasan</div>
                                <div class="col-span-1 text-center">Hapus</div>
                            </div>

                            <!-- Dynamic Scale Rows with Alpine.js -->
                            <div class="p-3 space-y-2.5 bg-slate-50 max-h-80 overflow-y-auto divide-y divide-slate-200">
                                <template x-for="(scale, index) in currentScaleCrit.scales" :key="index">
                                    <div class="grid grid-cols-12 gap-2 sm:gap-3 items-center pt-2">
                                        <!-- Column 1: Angka / Numeric Value -->
                                        <div class="col-span-3 sm:col-span-2">
                                            <input type="number" step="any" :name="'scales[' + index + '][value]'" x-model="scale.value" required
                                                placeholder="Nilai" class="neo-input text-center font-black py-1.5 text-sm" title="Angka Nilai Numerik">
                                        </div>

                                        <!-- Column 2: Label / Isi Skala (Text) -->
                                        <div class="col-span-8 sm:col-span-5">
                                            <input type="text" :name="'scales[' + index + '][label]'" x-model="scale.label" required
                                                placeholder="Contoh: < Rp 4.000.000 (Sangat Murah)" class="neo-input font-bold py-1.5 text-xs sm:text-sm" title="Teks Isi / Label Skala">
                                        </div>

                                        <!-- Column 3: Deskripsi / Penjelasan -->
                                        <div class="col-span-11 sm:col-span-4">
                                            <input type="text" :name="'scales[' + index + '][description]'" x-model="scale.description"
                                                placeholder="Keterangan opsional..." class="neo-input font-medium py-1.5 text-xs text-slate-700">
                                        </div>

                                        <!-- Column 4: Hapus Baris -->
                                        <div class="col-span-1 text-center">
                                            <button type="button" @click="removeScaleRow(index)" 
                                                class="p-1.5 border-2 border-black bg-rose-300 hover:bg-rose-400 text-black shadow-[1px_1px_0px_0px_#000] cursor-pointer" title="Hapus Baris Skala">
                                                <i data-lucide="trash-2" class="w-4 h-4 stroke-[2.5]"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Footer of table: Add scale row & quick template buttons -->
                            <div class="bg-white border-t-2 border-black p-3 flex flex-col sm:flex-row items-center justify-between gap-2">
                                <button type="button" @click="addScaleRow()" class="w-full sm:w-auto neo-btn-sm bg-cyan-300 hover:bg-cyan-400 text-black">
                                    <i data-lucide="plus" class="w-3.5 h-3.5 mr-1 stroke-[3]"></i>
                                    <span>Tambah Tingkat Skala Baru</span>
                                </button>

                                <button type="button" @click="resetScalesTemplate()" class="w-full sm:w-auto neo-btn-sm bg-white hover:bg-slate-100 text-slate-800">
                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 mr-1 stroke-[2.5]"></i>
                                    <span>Gunakan Template Standar 5 Tingkat</span>
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-slate-100 border-t-2 border-black px-6 py-4 flex items-center justify-between">
                        <button type="button" @click="showManageScalesModal = false" class="neo-btn bg-white hover:bg-slate-200 text-black">
                            Batal
                        </button>
                        <button type="submit" class="neo-btn bg-lime-300 hover:bg-lime-400 text-black">
                            <i data-lucide="save" class="w-4 h-4 mr-1.5 stroke-[2.5]"></i>
                            <span>Simpan Seluruh Perubahan Skala</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- 4. MODAL PANDUAN SKALA PENILAIAN SUB-KRITERIA                             -->
    <!-- ========================================================================= -->
    <div x-show="showScaleGuide" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-scale-guide-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showScaleGuide" x-transition class="fixed inset-0 bg-black/60 backdrop-blur-xs" @click="showScaleGuide = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="showScaleGuide" x-transition 
                class="inline-block align-bottom bg-white border-4 border-black shadow-[8px_8px_0px_0px_#000] text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                
                <div class="bg-yellow-300 border-b-2 border-black px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-black text-yellow-300 flex items-center justify-center border-2 border-black font-black">
                            <i data-lucide="help-circle" class="w-5 h-5 stroke-[2.5]"></i>
                        </div>
                        <h3 class="text-base font-black text-black uppercase tracking-tight" id="modal-scale-guide-title">
                            Panduan Skala Penilaian Kriteria Aktif
                        </h3>
                    </div>
                    <button type="button" @click="showScaleGuide = false" class="p-1 border-2 border-black bg-white hover:bg-black hover:text-white transition-colors">
                        <i data-lucide="x" class="w-4 h-4 stroke-[3]"></i>
                    </button>
                </div>

                <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                    <div class="p-3.5 border-2 border-black bg-lime-100 shadow-[3px_3px_0px_0px_#000] text-xs font-bold text-black leading-relaxed">
                        Sistem SAW laptop ini menggunakan skala dinamis. Pada kriteria <strong>Cost</strong>, skala bernilai kecil merepresentasikan opsi yang paling menguntungkan (paling murah/paling ringan). Pada kriteria <strong>Benefit</strong>, skala bernilai besar merepresentasikan performa/kapasitas yang paling tinggi.
                    </div>

                    <div class="space-y-4">
                        @foreach($criterias as $crit)
                            <div class="p-4 border-2 border-black bg-slate-50 shadow-[3px_3px_0px_0px_#000]">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2">
                                        <span class="neo-badge bg-black text-yellow-300 text-xs">
                                            {{ $crit->code }}
                                        </span>
                                        <h4 class="font-black text-black text-sm">{{ $crit->name }}</h4>
                                        <span class="neo-badge {{ $crit->isBenefit() ? 'bg-lime-200' : 'bg-amber-200' }} text-[10px]">
                                            {{ ucfirst($crit->attribute) }} ({{ round($crit->weight * 100) }}%)
                                        </span>
                                    </div>
                                    <button type="button" @click="openManageScalesModal({{ json_encode($crit) }})" 
                                        class="neo-btn-sm bg-emerald-300 hover:bg-emerald-400 text-black text-[11px] font-black">
                                        <i data-lucide="edit-3" class="w-3 h-3 mr-1 stroke-[2.5]"></i>
                                        <span>Ubah Skala Ini</span>
                                    </button>
                                </div>

                                @if($crit->scales->isNotEmpty())
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5 mt-2">
                                        @foreach($crit->scales as $sc)
                                            <div class="bg-white p-2.5 border-2 border-black shadow-[2px_2px_0px_0px_#000] text-xs">
                                                <div class="flex items-center justify-between font-black text-black mb-1">
                                                    <span class="px-1.5 py-0.2 bg-black text-white text-[11px]">Skala {{ $sc->value }}</span>
                                                </div>
                                                <div class="font-black text-slate-900 leading-snug">{{ $sc->label }}</div>
                                                @if($sc->description)
                                                    <div class="text-[10px] font-semibold text-slate-500 mt-1 border-t border-slate-200 pt-0.5">
                                                        {{ $sc->description }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs font-bold text-slate-500 italic">Belum ada rincian sub-kriteria.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-slate-100 border-t-2 border-black px-6 py-4 flex justify-end">
                    <button type="button" @click="showScaleGuide = false" class="neo-btn bg-black text-white hover:bg-slate-800">
                        Mengerti & Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>
