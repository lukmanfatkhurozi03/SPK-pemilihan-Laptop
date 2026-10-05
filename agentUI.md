# Agent Instructions: UI/UX Design System & Precision Guidelines (Neo-Brutalism UI)

Dokumen ini berisi panduan desain antarmuka (*User Interface*) dan pengalaman pengguna (*User Experience*) yang **sangat presisi** untuk aplikasi **Sistem Pendukung Keputusan (SPK) Pemilihan Laptop (Metode SAW)**[cite: 1]. Seluruh elemen visual wajib dirancang secara simetris, konsisten, dan proporsional tanpa ada ketimpangan visual (tidak ada elemen yang lebih besar atau lebih kecil sebelah secara tidak sengaja).

---

## 1. Standar Presisi & Konsistensi Visual (Strict Design Rules)

### A. Sistem Grid & Layout Simetris
- **Aturan Utama:** Semua kontainer utama, kartu, dan tabel wajib menggunakan struktur grid yang konsisten (misalnya menggunakan `grid-cols-1 md:grid-cols-3` dengan ukuran celah/gap yang seragam, yaitu `gap-6` atau `gap-4`).
- **Dimensi & Spasi:** Gunakan kelipatan unit Tailwind yang seragam (misalnya `p-6` untuk padding card, `mb-6` untuk jarak antar section). Hindari penggunaan ukuran bebas yang tidak proporsional antar komponen berdampingan.

### B. Presisi Border & Efek Bayangan (Hard Borders & Shadows)
- **Ketebalan Border:** Seluruh elemen interaktif dan struktural (kartu, tombol, input, tabel) wajib menggunakan ketebalan border yang konsisten, yaitu presisi **2px (`border-2 border-black`)** atau **4px (`border-4 border-black`)** secara seragam di seluruh halaman. Tidak boleh ada elemen yang memiliki border tipis default (*hairline*) berdampingan dengan border tebal.
- **Offset Bayangan (Hard Offset Shadow):** Jarak bayangan keras (*solid shadow*) harus konsisten di seluruh elemen (misalnya offset sejauh `4px 4px` dengan warna hitam legam penuh: `shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]`).

### C. Konsistensi Tombol & Input Form
- **Ukuran Padding Tombol & Input:** Seluruh tombol navigasi, tombol aksi CRUD, dan kotak input form wajib memiliki tinggi baris dan padding horizontal yang seragam (contoh: `py-2.5 px-4` untuk tombol standar).
- **Perataan Teks & Ikon:** Teks di dalam tombol atau tabel harus berada tepat di tengah secara vertikal dan horizontal (`flex items-center justify-center`).

---

## 2. Panduan Tata Letak Berdasarkan Referensi Visual (Neo-Brutalism / Retro Comic Modern)

### A. Header Navigasi Atas (Navbar)
- **Struktur Seimbang:** Terbagi menjadi 3 bagian presisi:
  1. **Kiri:** Logo/Nama Aplikasi dengan kotak bingkai tebal simetris.
  2. **Tengah:** Menu navigasi (Home, Kategori, Panduan) dengan jarak spasi antar teks yang merata (`space-x-6`).
  3. **Kanan:** Tombol Aksi Utama (CTA) dengan ukuran dan bayangan blok yang konsisten.

### B. Kartu Alternatif & Koleksi Data (Grid Cards)
- **Proporsi Kartu:** Setiap kartu alternatif laptop harus memiliki tinggi minimum yang sama (*equal height*) agar baris grid tidak berantakan.
- **Struktur Internal Kartu:**
  - Bagian atas kartu memiliki badge status dengan sudut kotak tegas dan padding simetris.
  - Bagian isi teks memiliki hierarki ukuran font yang konsisten (Judul: `font-bold text-lg`, Subteks: `text-sm text-slate-600`).

---

## 3. Pengalaman Pengguna: Wizard UX & Presisi Hasil Akhir

### A. Alur Langkah demi Langkah (Multi-Step Wizard)
- Pecah aplikasi ke dalam **3 Tahapan Wizard** dengan indikator langkah di atas yang memiliki ukuran bulatan/nomor langkah yang identik:
  - **Langkah 1:** Input Alternatif & Data Dasar[cite: 1]
  - **Langkah 2:** Matriks Normalisasi ($R$)[cite: 1]
  - **Langkah 3:** Hasil Perangkingan Akhir ($V_i$)[cite: 1]
- Tombol navigasi "Lanjut" dan "Kembali" harus diletakkan secara simetris di sisi kiri dan kanan bawah kontainer wizard.

### B. Kontras Warna & Presisi Rekomendasi Utama
- Baris tabel untuk **Peringkat #1 (Rekomendasi Utama)** wajib memiliki warna latar belakang kontras yang penuh satu baris (misalnya hijau neon terang atau kuning pastel) dengan ketebalan border yang sama persis dengan baris lainnya, namun dilengkapi badge **"🏆 Rekomendasi Utama"** berbingkai hitam tebal agar langsung menjadi fokus utama pengambil keputusan tanpa ada elemen yang timpang[cite: 1].