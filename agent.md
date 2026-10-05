# Agent Instructions: Pembuatan Website SPK Pemilihan Laptop Fully Dinamis (Metode SAW - Minimalist Wizard UI)

Dokumen ini berisi pedoman lengkap untuk merancang dan membangun website **Sistem Pendukung Keputusan (SPK) Pemilihan Laptop Terbaik Bagi Mahasiswa IT** menggunakan metode **Simple Additive Weighting (SAW)**. Seluruh komponen sistem—mulai dari **Kriteria, Bobot, Atribut (Benefit/Cost), hingga Alternatif Laptop**—harus bersifat **dinamis (Fully Editable/CRUD melalui antarmuka web)**, serta menerapkan standar **Minimalist UI** dan **Wizard UX** yang optimal berdasarkan makalah acuan[cite: 1].

---

## 1. Deskripsi Proyek & Tujuan
- **Judul Sistem:** SPK Pemilihan Laptop Terbaik untuk Mahasiswa IT[cite: 1].
- **Metode:** Simple Additive Weighting (SAW)[cite: 1].
- **Fitur Utama Dinamis:** Admin/Pengguna dapat menambah, mengubah, atau menghapus kriteria, mengubah bobot secara fleksibel (dengan validasi total bobot = 1.0 atau 100%), serta mengelola data alternatif laptop secara mandiri tanpa mengubah kode program.

---

## 2. Panduan UI & UX (Desain dan Interaksi Pengguna)

### A. Minimalist UI (Sangat Direkomendasikan)
- **Alasan Pemilihan:** Website SPK melibatkan banyak proses berpikir dan analisis data numerik. Desain minimalis memberikan ruang kosong (*whitespace*) yang cukup, sehingga pengguna tidak merasa pusing atau kewalahan melihat banyaknya angka dan opsi kriteria.
- **Karakteristik Visual:** 
  - Menggunakan font yang sangat mudah dibaca (clean sans-serif).
  - Warna latar belakang netral (putih bersih / abu-abu terang / *off-white*).
  - Fokus visual hanya pada elemen fungsional yang penting, tanpa dekorasi berlebihan.
  - Garis tabel tipis dan transisi elemen yang halus (`rounded-lg`, `shadow-sm`).

### B. Metode Langkah demi Langkah (Wizard UX)
- **Alasan Pemilihan:** Mencegah penumpukan informasi dalam satu halaman panjang yang membuat antarmuka terlihat rumit.
- **Penerapan Alur:** Bagi proses interaksi aplikasi menjadi beberapa tahapan terstruktur:
  - **Langkah 1: Input Alternatif & Data Dasar** (Pengelolaan data laptop dan kriteria).
  - **Langkah 2: Bobot Kriteria & Normalisasi** (Pengaturan bobot dan tinjauan matriks normalisasi).
  - **Langkah 3: Hasil & Rekomendasi** (Menampilkan hasil akhir perankingan).
- Sediakan navigasi tombol yang jelas antar langkah (misalnya tombol **"Lanjut ➔"** dan **"← Kembali"**).

### C. Kontras Warna pada Hasil Akhir
- Alternatif yang terpilih sebagai **"Rekomendasi Terbaik"** (Peringkat #1) wajib memiliki kontras warna atau penanda visual yang paling mencolok agar langsung terlihat oleh pengambil keputusan tanpa harus mencari-cari (misalnya menggunakan latar belakang hijau muda/emerald terang, border tebal, dan badge **"🏆 Rekomendasi Utama"**).

---

## 3. Fitur Manajemen Kriteria (Dinamis)
Sistem harus menyediakan menu atau bagian khusus untuk mengelola kriteria penilaian dengan ketentuan:
- **Atribut Kriteria:** Dapat dipilih antara **Benefit** (semakin besar nilai semakin baik) atau **Cost** (semakin kecil nilai semakin baik)[cite: 1].
- **Bobot Kriteria ($W$):** Dapat diubah nilainya secara bebas. Sistem **wajib** memberikan validasi agar total keseluruhan bobot kriteria bernilai `1.0` (atau `100%`).
- **Data Default Kriteria (Berdasarkan Makalah)[cite: 1]:**
  1. C1 - Harga (Cost, Bobot: 0.35)[cite: 1]
  2. C2 - Berat Laptop (Cost, Bobot: 0.05)[cite: 1]
  3. C3 - CPU / Prosesor (Benefit, Bobot: 0.25)[cite: 1]
  4. C4 - Jenis Storage (Benefit, Bobot: 0.15)[cite: 1]
  5. C5 - Kapasitas RAM (Benefit, Bobot: 0.20)[cite: 1]

---

## 4. Fitur Manajemen Alternatif & Nilai (Dinamis)
- Pengguna dapat menambah, mengedit, atau menghapus data alternatif laptop.
- Karena kriteria bersifat dinamis, form input nilai alternatif harus secara otomatis menyesuaikan dengan daftar kriteria aktif yang ada di dalam database.
- **Dataset Default Makalah (Seeding):**
  - A1: Laptop HP 250 G6[cite: 1]
  - A2: Laptop Acer Aspire 3[cite: 1]
  - A3: Laptop Dell Inspiron 3567[cite: 1]
  - A4: Laptop Asus VivoBook Max[cite: 1]
  - A5: Laptop Lenovo IdeaPad 320[cite: 1]
  - A6: Laptop Acer Swift 3[cite: 1]
  - A7: Asus VivoBook A407 (Target Rekomendasi Utama / Nilai Preferensi 0.700)[cite: 1]

---

## 5. Logika Perhitungan SAW (Dinamis Berdasarkan Database)
Sistem tidak boleh menggunakan nilai *hardcoded*, melainkan harus menghitung secara dinamis:
1. **Normalisasi Matriks ($r_{ij}$):**
   - Jika kriteria bertipe *Benefit*: $r_{ij} = \frac{x_{ij}}{\max(x_{ij})}[cite: 1]$
   - Jika kriteria bertipe *Cost*: $r_{ij} = \frac{\min(x_{ij})}{x_{ij}}[cite: 1]$
   *(Nilai $\max$ dan $\min$ dicari secara dinamis dari seluruh data nilai alternatif yang tersimpan).*
2. **Nilai Preferensi ($V_i$):**
   - $V_i = \sum_{j=1}^{n} w_j r_{ij}$ (menggunakan bobot $w_j$ yang diatur dinamis oleh pengguna)[cite: 1].
3. **Perangkingan:**
   - Mengurutkan hasil akhir $V_i$ dari yang terbesar ke terkecil secara otomatis[cite: 1].

---

## 6. Instruksi untuk Developer / AI Code Generator
- Pastikan struktur database mendukung fleksibilitas perubahan kriteria dan bobot.
- Terapkan konsep *Minimalist UI* menggunakan framework CSS modern (seperti Tailwind CSS) dengan ruang putih yang lega dan tipografi yang bersih.
- Implementasikan sistem *Wizard UI* untuk memecah form yang panjang menjadi beberapa tahapan logis agar pengalaman pengguna terasa ringan dan nyaman.