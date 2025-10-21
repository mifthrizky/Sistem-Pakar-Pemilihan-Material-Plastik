# Sistem Pakar Pemilihan Material Plastik untuk Industri Otomotif

Repositori ini berisi kode sumber untuk aplikasi **Sistem Pakar** yang dirancang untuk membantu pengguna dalam memilih material plastik yang paling sesuai untuk aplikasi industri otomotif, seperti pembuatan dashboard dan komponen interior lainnya.

Aplikasi ini menggunakan pendekatan berbasis aturan (*rule-based*) dengan sistem skoring untuk menganalisis kebutuhan pengguna melalui serangkaian pertanyaan dan memberikan rekomendasi material yang paling optimal.

---

## 📋 Fitur Utama

-   **Kuesioner Interaktif**: Mengajukan serangkaian pertanyaan terpandu untuk memahami kebutuhan pengguna dari segi teknis, biaya, hingga estetika.
-   **Mesin Inferensi Berbasis Skor**: Backend Flask memproses jawaban pengguna dan memberikan skor pada setiap material kandidat berdasarkan *knowledge base* yang telah didefinisikan.
-   **Rekomendasi Cerdas**: Memberikan rekomendasi material utama yang paling cocok, lengkap dengan **tingkat keyakinan (confidence score)**.
-   **Alasan dan Karakteristik**: Menjelaskan alasan di balik setiap rekomendasi dan menyoroti karakteristik utama dari material yang disarankan.
-   **Rekomendasi Alternatif**: Menyajikan 2 material alternatif teratas sebagai bahan pertimbangan lebih lanjut.
-   **Unduh Hasil Analisis**: Pengguna dapat mengunduh ringkasan hasil konsultasi dalam format file `.txt`.
-   **Antarmuka Modern**: UI yang bersih dan responsif dibangun menggunakan Tailwind CSS.
-   **Kontainerisasi**: Seluruh aplikasi (frontend dan backend) diatur dalam kontainer menggunakan Docker, memastikan instalasi dan deployment yang mudah dan konsisten.

---

## 🚀 Teknologi yang Digunakan

-   **Frontend**:
    -   PHP 8.2
    -   Apache Server
    -   Tailwind CSS
-   **Backend**:
    -   Python 3.9
    -   Flask Framework
-   **Orchestration**:
    -   Docker
    -   Docker Compose

---

## 🔧 Prasyarat

Sebelum memulai, pastikan Anda telah menginstal perangkat lunak berikut di sistem Anda:
-   [**Docker**](https://docs.docker.com/get-docker/)
-   [**Docker Compose**](https://docs.docker.com/compose/install/)
-   [**Git**](https://git-scm.com/downloads)

---

## ⚙️ Instalasi dan Penggunaan

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi secara lokal.

1.  **Clone repositori ini:**
    ```sh
    git clone [https://github.com/mifthrizky/sistem-pakar-pemilihan-material-plastik.git](https://github.com/mifthrizky/sistem-pakar-pemilihan-material-plastik.git)
    ```

2.  **Masuk ke direktori proyek:**
    ```sh
    cd sistem-pakar-pemilihan-material-plastik
    ```

3.  **Build dan jalankan container menggunakan Docker Compose:**
    Perintah ini akan membuat *image* untuk layanan frontend dan backend, serta menjalankan keduanya di latar belakang.
    ```sh
    docker-compose up -d --build
    ```

4.  **Akses Aplikasi:**
    Setelah container berhasil berjalan, buka browser Anda dan akses alamat berikut:
    [**http://localhost:8080**](http://localhost:8080)

5.  **Mulai Konsultasi:**
    -   Klik tombol "Mulai Analisis".
    -   Jawab semua pertanyaan sesuai dengan kebutuhan Anda.
    -   Lihat hasil rekomendasi yang diberikan oleh sistem.

---

# Sistem Pakar Pemilihan Material Plastik untuk Industri Otomotif

<p align="center">
  <img src="https://user-images.githubusercontent.com/81005256/212260797-e83f293b-9a93-45a7-a46c-c82703f256b8.png" alt="PHP" width="60" height="60"/>
  <img src="https://user-images.githubusercontent.com/81005256/212260799-222a20a0-3843-410a-8c90-00a83e0c52f6.png" alt="Python" width="60" height="60"/>
  <img src="https://user-images.githubusercontent.com/81005256/212260791-37053e18-09f1-432a-b286-90b957b9e075.png" alt="Docker" width="60" height="60"/>
  <img src="https://user-images.githubusercontent.com/81005256/212260805-752c5c5e-8566-4e50-a24a-e49a02263d91.png" alt="TailwindCSS" width="60" height="60"/>
</p>

Repositori ini berisi kode sumber untuk aplikasi **Sistem Pakar** yang dirancang untuk membantu pengguna dalam memilih material plastik yang paling sesuai untuk aplikasi industri otomotif, seperti pembuatan dashboard dan komponen interior lainnya.

Aplikasi ini menggunakan pendekatan berbasis aturan (*rule-based*) dengan sistem skoring untuk menganalisis kebutuhan pengguna melalui serangkaian pertanyaan dan memberikan rekomendasi material yang paling optimal.

---

## 📋 Fitur Utama

-   **Kuesioner Interaktif**: Mengajukan serangkaian pertanyaan terpandu untuk memahami kebutuhan pengguna dari segi teknis, biaya, hingga estetika.
-   **Mesin Inferensi Berbasis Skor**: Backend Flask memproses jawaban pengguna dan memberikan skor pada setiap material kandidat berdasarkan *knowledge base* yang telah didefinisikan.
-   **Rekomendasi Cerdas**: Memberikan rekomendasi material utama yang paling cocok, lengkap dengan **tingkat keyakinan (confidence score)**.
-   **Alasan dan Karakteristik**: Menjelaskan alasan di balik setiap rekomendasi dan menyoroti karakteristik utama dari material yang disarankan.
-   **Rekomendasi Alternatif**: Menyajikan 2 material alternatif teratas sebagai bahan pertimbangan lebih lanjut.
-   **Unduh Hasil Analisis**: Pengguna dapat mengunduh ringkasan hasil konsultasi dalam format file `.txt`.
-   **Antarmuka Modern**: UI yang bersih dan responsif dibangun menggunakan Tailwind CSS.
-   **Kontainerisasi**: Seluruh aplikasi (frontend dan backend) diatur dalam kontainer menggunakan Docker, memastikan instalasi dan deployment yang mudah dan konsisten.

---

## 🚀 Teknologi yang Digunakan

-   **Frontend**:
    -   PHP 8.2
    -   Apache Server
    -   Tailwind CSS
-   **Backend**:
    -   Python 3.9
    -   Flask Framework
-   **Orchestration**:
    -   Docker
    -   Docker Compose

---

## 🔧 Prasyarat

Sebelum memulai, pastikan Anda telah menginstal perangkat lunak berikut di sistem Anda:
-   [**Docker**](https://docs.docker.com/get-docker/)
-   [**Docker Compose**](https://docs.docker.com/compose/install/)
-   [**Git**](https://git-scm.com/downloads)

---

## ⚙️ Instalasi dan Penggunaan

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi secara lokal.

1.  **Clone repositori ini:**
    ```sh
    git clone [https://github.com/mifthrizky/sistem-pakar-pemilihan-material-plastik.git](https://github.com/mifthrizky/sistem-pakar-pemilihan-material-plastik.git)
    ```

2.  **Masuk ke direktori proyek:**
    ```sh
    cd sistem-pakar-pemilihan-material-plastik
    ```

3.  **Build dan jalankan container menggunakan Docker Compose:**
    Perintah ini akan membuat *image* untuk layanan frontend dan backend, serta menjalankan keduanya di latar belakang.
    ```sh
    docker-compose up -d --build
    ```

4.  **Akses Aplikasi:**
    Setelah container berhasil berjalan, buka browser Anda dan akses alamat berikut:
    [**http://localhost:8080**](http://localhost:8080)

5.  **Mulai Konsultasi:**
    -   Klik tombol "Mulai Analisis".
    -   Jawab semua pertanyaan sesuai dengan kebutuhan Anda.
    -   Lihat hasil rekomendasi yang diberikan oleh sistem.

```

## 📜 Lisensi

Proyek ini dilisensikan di bawah **Lisensi MIT**. Lihat file `LICENSE` untuk detail lebih lanjut.
