@extends('layouts.app')

@section('title', 'SPK Pemilihan Laptop - Neo-Brutalism Wizard SAW')

@section('content')
<div class="space-y-6">

    <!-- Stepper Navigation Header (AgentUI Section 3.A: Identical Step Indicators) -->
    <div class="neo-box p-4 sm:p-6 mb-6 bg-white">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Step 1 Button -->
            <button type="button" @click="goToStep(1)" 
                class="w-full text-left p-3.5 border-2 border-black transition-all flex items-center space-x-3.5 cursor-pointer"
                :class="currentStep === 1 
                    ? 'bg-yellow-300 shadow-[4px_4px_0px_0px_#000] translate-x-[-1px] translate-y-[-1px]' 
                    : (currentStep > 1 ? 'bg-lime-200 hover:bg-lime-300 shadow-[2px_2px_0px_0px_#000]' : 'bg-slate-100 hover:bg-slate-200 shadow-[2px_2px_0px_0px_#000]')">
                <div class="w-10 h-10 border-2 border-black flex-shrink-0 flex items-center justify-center font-black text-sm"
                    :class="currentStep === 1 ? 'bg-black text-yellow-300' : (currentStep > 1 ? 'bg-black text-lime-300' : 'bg-white text-black')">
                    <template x-if="currentStep > 1">
                        <i data-lucide="check" class="w-5 h-5 stroke-[3]"></i>
                    </template>
                    <template x-if="currentStep <= 1">
                        <span>1</span>
                    </template>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-800">Tahap 1</p>
                    <h3 class="text-xs sm:text-sm font-black text-black uppercase tracking-tight truncate">
                        Input Alternatif & Data Dasar
                    </h3>
                </div>
            </button>

            <!-- Step 2 Button -->
            <button type="button" @click="goToStep(2)" 
                class="w-full text-left p-3.5 border-2 border-black transition-all flex items-center space-x-3.5 cursor-pointer"
                :class="currentStep === 2 
                    ? 'bg-yellow-300 shadow-[4px_4px_0px_0px_#000] translate-x-[-1px] translate-y-[-1px]' 
                    : (currentStep > 2 ? 'bg-lime-200 hover:bg-lime-300 shadow-[2px_2px_0px_0px_#000]' : 'bg-slate-100 hover:bg-slate-200 shadow-[2px_2px_0px_0px_#000]')">
                <div class="w-10 h-10 border-2 border-black flex-shrink-0 flex items-center justify-center font-black text-sm"
                    :class="currentStep === 2 ? 'bg-black text-yellow-300' : (currentStep > 2 ? 'bg-black text-lime-300' : 'bg-white text-black')">
                    <template x-if="currentStep > 2">
                        <i data-lucide="check" class="w-5 h-5 stroke-[3]"></i>
                    </template>
                    <template x-if="currentStep <= 2">
                        <span>2</span>
                    </template>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-800">Tahap 2</p>
                    <h3 class="text-xs sm:text-sm font-black text-black uppercase tracking-tight truncate">
                        Matriks Normalisasi ($R$)
                    </h3>
                </div>
            </button>

            <!-- Step 3 Button -->
            <button type="button" @click="goToStep(3)" 
                class="w-full text-left p-3.5 border-2 border-black transition-all flex items-center space-x-3.5 cursor-pointer"
                :class="currentStep === 3 
                    ? 'bg-lime-300 shadow-[4px_4px_0px_0px_#000] translate-x-[-1px] translate-y-[-1px]' 
                    : 'bg-slate-100 hover:bg-slate-200 shadow-[2px_2px_0px_0px_#000]'">
                <div class="w-10 h-10 border-2 border-black flex-shrink-0 flex items-center justify-center font-black text-sm"
                    :class="currentStep === 3 ? 'bg-black text-lime-300' : 'bg-white text-black'">
                    <i data-lucide="trophy" class="w-5 h-5 stroke-[2.5]"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-800">Tahap 3</p>
                    <h3 class="text-xs sm:text-sm font-black text-black uppercase tracking-tight truncate">
                        Hasil Perangkingan Akhir ($V_i$)
                    </h3>
                </div>
            </button>

        </div>
    </div>

    <!-- Wizard Steps Panes -->
    
    <!-- STEP 1 PANE -->
    <div x-show="currentStep === 1" x-cloak>
        @include('spk.step1')
    </div>

    <!-- STEP 2 PANE -->
    <div x-show="currentStep === 2" x-cloak>
        @include('spk.step2')
    </div>

    <!-- STEP 3 PANE -->
    <div x-show="currentStep === 3" x-cloak>
        @include('spk.step3')
    </div>

</div>
@endsection

@section('modals')
    @include('spk.modals')
@endsection
