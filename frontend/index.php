<!DOCTYPE html>
<html lang="id" class="bg-[#f8f7f4]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Material Cerdas | Sistem Pakar Otomotif</title>

    <link href="public/style.css" rel="stylesheet">

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .slide-up {
            animation: slideUp 0.8s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#f8f7f4] via-[#f2ede6] to-[#eaf1ee] font-body text-[#3d453c] max-h-screen p-6 md:p-8 overflow-hidden">

    <div class="container mx-auto px-4 py-8 md:py-16">

        <header class="text-center mb-16 fade-in">
            <div class="flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard mr-4">
                    <rect width="7" height="9" x="3" y="3" rx="1" />
                    <rect width="7" height="5" x="14" y="3" rx="1" />
                    <rect width="7" height="9" x="14" y="12" rx="1" />
                    <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                <h1 class="font-display text-4xl md:text-5xl font-semibold text-[#3d453c]">
                    Rekomendasi Material Cerdas
                </h1>
            </div>
            <p class="text-lg text-[#6c7a67] font-light max-w-2xl mx-auto leading-relaxed">
                Penerapan Sistem Pakar dalam Menentukan Material Plastik yang Optimal untuk Aplikasi Industri Otomotif, seperti Pembuatan Dashboard dan Interior.
            </p>
        </header>

        <div class="max-w-4xl mx-auto mb-12">
            <div class="bg-white/50 backdrop-blur-lg border border-white/30 rounded-2xl shadow-lg p-10 md:p-12 text-center slide-up">
                <h2 class="font-display text-3xl font-medium text-[#3d453c] mb-6">
                    Mulai Proses Rekomendasi
                </h2>
                <p class="text-base text-[#5a6856] mb-8 max-w-2xl mx-auto">
                    Jawab pertanyaan kunci agar sistem dapat memberikan rekomendasi material plastik terbaik sesuai kebutuhan teknis, anggaran, dan tampilan yang diinginkan.
                </p>
                <a href="pages/pertanyaan.php" class="bg-[#3d453c] hover:bg-[#2a3028] text-white font-bold py-3 px-8 rounded-full inline-flex items-center gap-x-2 group transition-all duration-300 transform hover:scale-105">
                    Mulai Analisis
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>

            <p class="mt-10 text-center slide-up">Waktu penyelesaian: 5 - 10 menit</p>

        </div>

    </div>

</body>

</html>