<?php

namespace Database\Seeders;

use App\Models\Alternative;
use App\Models\AlternativeScore;
use App\Models\Criteria;
use App\Models\CriteriaScale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AlternativeScore::truncate();
        CriteriaScale::truncate();
        Alternative::truncate();
        Criteria::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Kriteria Default (Berdasarkan Makalah)
        $criteriasData = [
            [
                'code' => 'C1',
                'name' => 'Harga',
                'attribute' => 'cost',
                'weight' => 0.35,
                'unit' => 'Juta Rp / Skala',
                'description' => 'Tingkat harga laptop (semakin murah / skala kecil semakin baik bagi mahasiswa)',
                'order' => 1,
                'scales' => [
                    ['label' => '< Rp 4.000.000 (Sangat Murah)', 'value' => 1, 'description' => 'Sangat ramah di kantong mahasiswa'],
                    ['label' => 'Rp 4.000.000 - Rp 6.000.000 (Murah)', 'value' => 2, 'description' => 'Rentang harga budget favorit'],
                    ['label' => 'Rp 6.000.000 - Rp 8.000.000 (Sedang)', 'value' => 3, 'description' => 'Harga standar menengah'],
                    ['label' => 'Rp 8.000.000 - Rp 10.000.000 (Mahal)', 'value' => 4, 'description' => 'Harga di atas rata-rata'],
                    ['label' => '> Rp 10.000.000 (Sangat Mahal)', 'value' => 5, 'description' => 'Segmen premium / gaming'],
                ]
            ],
            [
                'code' => 'C2',
                'name' => 'Berat Laptop',
                'attribute' => 'cost',
                'weight' => 0.05,
                'unit' => 'Kg / Skala',
                'description' => 'Bobot fisik laptop untuk mobilitas ke kampus (semakin ringan semakin baik)',
                'order' => 2,
                'scales' => [
                    ['label' => '< 1.4 Kg (Sangat Ringan)', 'value' => 1, 'description' => 'Ultra portable'],
                    ['label' => '1.4 - 1.7 Kg (Ringan)', 'value' => 2, 'description' => 'Mudah dibawa dalam ransel harian'],
                    ['label' => '1.8 - 2.0 Kg (Sedang)', 'value' => 3, 'description' => 'Ukuran standar laptop 14-15 inch'],
                    ['label' => '2.1 - 2.4 Kg (Berat)', 'value' => 4, 'description' => 'Cukup berat untuk mobilitas tinggi'],
                    ['label' => '> 2.4 Kg (Sangat Berat)', 'value' => 5, 'description' => 'Laptop gaming tebal'],
                ]
            ],
            [
                'code' => 'C3',
                'name' => 'CPU / Prosesor',
                'attribute' => 'benefit',
                'weight' => 0.25,
                'unit' => 'Tingkat Kinerja',
                'description' => 'Kekuatan komputasi untuk coding, kompilasi, dan multitasking',
                'order' => 3,
                'scales' => [
                    ['label' => 'Intel Core i7 / AMD Ryzen 7 (Sangat Tinggi)', 'value' => 5, 'description' => 'Performa komputasi maksimal'],
                    ['label' => 'Intel Core i5 / AMD Ryzen 5 (Tinggi)', 'value' => 4, 'description' => 'Sangat lancar untuk software dev & VM'],
                    ['label' => 'Intel Core i3 / AMD Ryzen 3 (Cukup)', 'value' => 3, 'description' => 'Mumpuni untuk coding web & tugas kuliah'],
                    ['label' => 'Intel Celeron / Pentium / Athlon (Rendah)', 'value' => 2, 'description' => 'Standar office ringan'],
                    ['label' => 'Intel Atom / Entry Level (Sangat Rendah)', 'value' => 1, 'description' => 'Kapasitas komputasi dasar'],
                ]
            ],
            [
                'code' => 'C4',
                'name' => 'Jenis Storage',
                'attribute' => 'benefit',
                'weight' => 0.15,
                'unit' => 'Teknologi & Kecepatan',
                'description' => 'Kecepatan booting, loading project IDE, dan keandalan penyimpanan',
                'order' => 4,
                'scales' => [
                    ['label' => 'SSD NVMe M.2 512GB+ (Sangat Cepat)', 'value' => 5, 'description' => 'Read/Write hingga 3000+ MB/s'],
                    ['label' => 'SSD NVMe 256GB / SSD SATA 512GB (Cepat)', 'value' => 4, 'description' => 'Booting hitungan detik'],
                    ['label' => 'SSD SATA 256GB / Dual SSD+HDD (Sedang)', 'value' => 3, 'description' => 'Kombinasi kecepatan & kapasitas'],
                    ['label' => 'HDD 1TB 5400 RPM (Lambat)', 'value' => 2, 'description' => 'Kapasitas besar namun akses lambat'],
                    ['label' => 'eMMC / HDD 500GB (Sangat Lambat)', 'value' => 1, 'description' => 'Penyimpanan entry level'],
                ]
            ],
            [
                'code' => 'C5',
                'name' => 'Kapasitas RAM',
                'attribute' => 'benefit',
                'weight' => 0.20,
                'unit' => 'GB / Kapasitas',
                'description' => 'Kapasitas memori untuk menjalankan Docker, VS Code, Browser tabs secara simultan',
                'order' => 5,
                'scales' => [
                    ['label' => '16 GB+ Dual Channel (Sangat Besar)', 'value' => 5, 'description' => 'Multitasking kelas berat tanpa lag'],
                    ['label' => '8 GB Dual Channel / Upgradable (Besar)', 'value' => 4, 'description' => 'Standar ideal mahasiswa IT masa kini'],
                    ['label' => '8 GB Single Channel (Cukup)', 'value' => 3, 'description' => 'Cukup untuk aktivitas pemrograman umum'],
                    ['label' => '4 GB Single Channel (Kurang)', 'value' => 2, 'description' => 'Terbatas untuk multitasking berat'],
                    ['label' => '< 4 GB (Sangat Kurang)', 'value' => 1, 'description' => 'Sering mengalami swap/out of memory'],
                ]
            ],
        ];

        $criteriaModels = [];
        foreach ($criteriasData as $cData) {
            $scales = $cData['scales'];
            unset($cData['scales']);
            
            $crit = Criteria::create($cData);
            $criteriaModels[$crit->code] = $crit;

            foreach ($scales as $sData) {
                $crit->scales()->create($sData);
            }
        }

        // 2. Alternatif Laptop Default (Berdasarkan Makalah)
        $alternativesData = [
            [
                'code' => 'A1',
                'name' => 'Laptop HP 250 G6',
                'brand' => 'HP',
                'spec_summary' => 'Intel Celeron N4000 / Core i3, RAM 4GB, HDD 500GB, Layar 15.6 Inch, Berat 2.0 Kg',
                'price_raw' => 5200000,
                'order' => 1,
                'scores' => [
                    'C1' => 4, // Skala 4 (Rp 5.2 Juta)
                    'C2' => 3, // Skala 3 (2.0 Kg)
                    'C3' => 2, // Skala 2 (Entry Celeron/i3)
                    'C4' => 2, // Skala 2 (HDD 500GB)
                    'C5' => 2, // Skala 2 (RAM 4GB)
                ]
            ],
            [
                'code' => 'A2',
                'name' => 'Laptop Acer Aspire 3',
                'brand' => 'Acer',
                'spec_summary' => 'AMD Ryzen 3 / Core i3, RAM 4GB, HDD 1TB, Layar 14 Inch, Berat 1.8 Kg',
                'price_raw' => 6100000,
                'order' => 2,
                'scores' => [
                    'C1' => 3, // Skala 3 (Rp 6.1 Juta)
                    'C2' => 3, // Skala 3 (1.8 Kg)
                    'C3' => 3, // Skala 3 (Ryzen 3 / Core i3)
                    'C4' => 2, // Skala 2 (HDD 1TB)
                    'C5' => 2, // Skala 2 (RAM 4GB)
                ]
            ],
            [
                'code' => 'A3',
                'name' => 'Laptop Dell Inspiron 3567',
                'brand' => 'Dell',
                'spec_summary' => 'Intel Core i3 6006U, RAM 4GB, HDD 1TB, Layar 15.6 Inch, Berat 2.2 Kg',
                'price_raw' => 5800000,
                'order' => 3,
                'scores' => [
                    'C1' => 4, // Skala 4 (Rp 5.8 Juta)
                    'C2' => 4, // Skala 4 (2.2 Kg)
                    'C3' => 3, // Skala 3 (Core i3)
                    'C4' => 2, // Skala 2 (HDD 1TB)
                    'C5' => 2, // Skala 2 (RAM 4GB)
                ]
            ],
            [
                'code' => 'A4',
                'name' => 'Laptop Asus VivoBook Max',
                'brand' => 'Asus',
                'spec_summary' => 'Intel Core i3 7th Gen, RAM 4GB, HDD 1TB, Layar 14 Inch, Berat 1.75 Kg',
                'price_raw' => 6400000,
                'order' => 4,
                'scores' => [
                    'C1' => 3, // Skala 3 (Rp 6.4 Juta)
                    'C2' => 2, // Skala 2 (1.75 Kg)
                    'C3' => 3, // Skala 3 (Core i3 7th Gen)
                    'C4' => 2, // Skala 2 (HDD 1TB)
                    'C5' => 2, // Skala 2 (RAM 4GB)
                ]
            ],
            [
                'code' => 'A5',
                'name' => 'Laptop Lenovo IdeaPad 320',
                'brand' => 'Lenovo',
                'spec_summary' => 'Intel Core i3 6006U, RAM 4GB DDR4, HDD 1TB, Layar 14 Inch, Berat 1.9 Kg',
                'price_raw' => 5900000,
                'order' => 5,
                'scores' => [
                    'C1' => 3, // Skala 3 (Rp 5.9 Juta)
                    'C2' => 3, // Skala 3 (1.9 Kg)
                    'C3' => 3, // Skala 3 (Core i3)
                    'C4' => 2, // Skala 2 (HDD 1TB)
                    'C5' => 2, // Skala 2 (RAM 4GB)
                ]
            ],
            [
                'code' => 'A6',
                'name' => 'Laptop Acer Swift 3',
                'brand' => 'Acer',
                'spec_summary' => 'Intel Core i5 8th Gen, RAM 8GB DDR4, SSD 256GB NVMe, Layar 14 Inch FHD, Berat 1.5 Kg',
                'price_raw' => 9500000,
                'order' => 6,
                'scores' => [
                    'C1' => 5, // Skala 5 (Rp 9.5 Juta - mahal)
                    'C2' => 2, // Skala 2 (1.5 Kg)
                    'C3' => 3, // Skala 3 (Core i5 balanced)
                    'C4' => 3, // Skala 3 (SSD 256GB)
                    'C5' => 3, // Skala 3 (RAM 8GB single)
                ]
            ],
            [
                'code' => 'A7',
                'name' => 'Asus VivoBook A407',
                'brand' => 'Asus',
                'spec_summary' => 'Intel Core i3 7020U / i5, RAM 8GB Dual Channel, SSD 256GB + HDD 1TB, Layar 14 Inch NanoEdge, Berat 1.5 Kg',
                'price_raw' => 5700000,
                'order' => 7,
                'scores' => [
                    'C1' => 2, // Skala 2 (Rp 5.7 Juta - Best Price/Performance)
                    'C2' => 2, // Skala 2 (1.5 Kg - Ringan)
                    'C3' => 3, // Skala 3 (Core i3 / i5)
                    'C4' => 3, // Skala 3 (Dual Storage SSD+HDD)
                    'C5' => 3, // Skala 3 (RAM 8GB)
                ]
            ],
        ];

        foreach ($alternativesData as $aData) {
            $scores = $aData['scores'];
            unset($aData['scores']);

            $alt = Alternative::create($aData);

            foreach ($scores as $critCode => $scoreVal) {
                if (isset($criteriaModels[$critCode])) {
                    AlternativeScore::create([
                        'alternative_id' => $alt->id,
                        'criteria_id' => $criteriaModels[$critCode]->id,
                        'score' => $scoreVal,
                    ]);
                }
            }
        }
    }
}
