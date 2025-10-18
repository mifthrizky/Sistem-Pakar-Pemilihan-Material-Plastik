<?php

$rekomendasi = "Tidak Ditemukan";
$alasan = "Tidak ada material yang cocok dengan kriteria Anda. Silakan coba kombinasi lain.";
$karakteristik = [];
$confidence = "0%";
$skor_detail = [];
$alternatif = null;
$jawaban_pengguna = [];

// Pastikan ada data yang dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    // URL dari service backend Flask di Docker
    $url = 'http://backend:5000/api/rekomendasi';

    $data = $_POST;
    $jawaban_pengguna = $data;

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
            'timeout' => 10,
        ],
    ];

    $context  = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result !== FALSE) {
        $response = json_decode($result, true);
        if (isset($response['rekomendasi']) && isset($response['alasan'])) {
            $rekomendasi = htmlspecialchars($response['rekomendasi']);
            $alasan = htmlspecialchars($response['alasan']);
            $karakteristik = $response['karakteristik'] ?? [];
            $confidence = $response['confidence'] ?? "0%";
            $skor_detail = $response['skor_detail'] ?? [];
            $alternatif = $response['alternatif'] ?? null;
        }
    }
} else {
    header('Location: ../index.php');
    exit();
}

// Data untuk JavaScript
$data_for_js = [
    'rekomendasi' => $rekomendasi,
    'alasan' => $alasan,
    'karakteristik' => $karakteristik,
    'confidence' => $confidence,
    'jawaban' => $jawaban_pengguna,
    'skor_detail' => $skor_detail,
    'alternatif' => $alternatif
];

// Fungsi bantu untuk menampilkan jawaban dengan format yang lebih baik
function format_jawaban($key, $value)
{
    $labels = [
        'biaya' => 'Prioritas Biaya Rendah',
        'panas' => 'Ketahanan Panas',
        'impak' => 'Kekuatan Impak Tinggi',
        'suhu_rendah' => 'Kuat pada Suhu Rendah',
        'estetika' => 'Preferensi Estetika',
        'api' => 'Flame Retardancy',
        'proses' => 'Kemudahan Proses',
        'lingkungan' => 'Recyclability',
        'energi' => 'Energy Absorbing',
        'kekakuan' => 'Stiffness/Kekakuan',
        'kimia' => 'Tahan Retak Kimia',
        'serat' => 'Glass Fiber Reinforcement',
        'versatile' => 'Versatility/Serbaguna',
        'blending' => 'Blending Capability'
    ];

    $label = $labels[$key] ?? ucfirst($key);

    switch ($key) {
        case 'biaya':
        case 'impak':
        case 'suhu_rendah':
        case 'api':
        case 'proses':
        case 'lingkungan':
        case 'energi':
        case 'kekakuan':
        case 'kimia':
        case 'serat':
        case 'versatile':
        case 'blending':
            $formatted = $value == 'ya' ? 'Ya' : 'Tidak';
            break;
        case 'panas':
            $map = [
                'sangat_penting' => 'Sangat Penting',
                'cukup_penting' => 'Cukup Penting',
                'standar' => 'Standar'
            ];
            $formatted = $map[$value] ?? ucfirst($value);
            break;
        case 'estetika':
            $map = [
                'low_gloss' => 'Low-Gloss',
                'beragam' => 'Beragam Tekstur',
                'seragam' => 'Seragam dengan Komponen Lain'
            ];
            $formatted = $map[$value] ?? ucfirst($value);
            break;
        default:
            $formatted = ucfirst($value);
    }

    return ['label' => $label, 'value' => $formatted];
}

// Fungsi untuk mendapatkan warna confidence
function get_confidence_color($confidence_str)
{
    $percentage = (float)str_replace('%', '', $confidence_str);
    if ($percentage >= 40) return 'text-green-600 bg-green-50';
    if ($percentage >= 25) return 'text-yellow-600 bg-yellow-50';
    return 'text-orange-600 bg-orange-50';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Analisis | Sistem Pakar Otomotif</title>
    <link href="../public/style.css" rel="stylesheet">

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

        .slide-up-delay-1 {
            animation: slideUp 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }

        .slide-up-delay-2 {
            animation: slideUp 0.8s ease-out 0.4s forwards;
            opacity: 0;
        }

        .characteristic-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #eaf1ee 0%, #f2ede6 100%);
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0.25rem;
            border: 1px solid rgba(61, 69, 60, 0.1);
        }

        .score-bar {
            height: 8px;
            background: linear-gradient(90deg, #3d453c 0%, #6c7a67 100%);
            border-radius: 4px;
            transition: width 0.8s ease-out;
        }

        .alternative-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .alternative-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#f8f7f4] via-[#f2ede6] to-[#eaf1ee] font-body text-[#3d453c] min-h-screen p-6 md:p-8">

    <div class="container mx-auto px-4 py-8 md:py-12">

        <!-- Header -->
        <header class="text-center mb-12 fade-in">
            <div class="flex items-center justify-center mb-6">
                <div class="w-20 h-20 bg-[#eaf1ee] rounded-full flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#3d453c]">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
            </div>
            <h1 class="font-display text-4xl md:text-5xl font-semibold text-[#3d453c] mb-4">
                Analisis Selesai
            </h1>
            <p class="text-lg text-[#6c7a67] font-light max-w-2xl mx-auto leading-relaxed">
                Berikut adalah hasil rekomendasi material berdasarkan kriteria yang Anda berikan.
            </p>
        </header>

        <!-- Hasil Utama -->
        <div class="max-w-5xl mx-auto mb-12">
            <div class="bg-white/60 backdrop-blur-lg border border-white/40 rounded-2xl shadow-lg p-8 md:p-12 slide-up">

                <!-- Rekomendasi Material -->
                <div class="text-center mb-8">
                    <div class="inline-block mb-4">
                        <span class="text-sm font-bold text-[#3d453c] uppercase tracking-wide">Rekomendasi Material</span>
                    </div>
                    <div class="inline-flex items-center justify-center bg-[#3d453c] text-white text-2xl md:text-3xl font-bold font-display px-8 py-4 rounded-2xl shadow-xl mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
                        </svg>
                        <span><?= $rekomendasi ?></span>
                    </div>

                    <!-- Confidence Level -->
                    <div class="inline-flex items-center gap-x-2 <?= get_confidence_color($confidence) ?> px-4 py-2 rounded-full border">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18" />
                            <path d="m19 9-5 5-4-4-3 3" />
                        </svg>
                        <span class="font-semibold">Confidence: <?= $confidence ?></span>
                    </div>
                </div>

                <!-- Alasan Rekomendasi -->
                <div class="bg-gray-50/50 p-6 rounded-xl mb-8 border-l-4 border-[#3d453c]">
                    <h3 class="text-lg font-display font-semibold text-[#3d453c] mb-3 flex items-center gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4" />
                            <path d="M12 8h.01" />
                        </svg>
                        Alasan Rekomendasi
                    </h3>
                    <p class="text-[#5a6856] leading-relaxed"><?= $alasan ?></p>
                </div>

                <!-- Karakteristik Material -->
                <?php if (!empty($karakteristik)): ?>
                    <div class="mb-8">
                        <h3 class="text-lg font-display font-semibold text-[#3d453c] mb-4 flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v20M2 12h20" />
                                <path d="m5 19 14-14M5 5l14 14" />
                            </svg>
                            Karakteristik Utama
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($karakteristik as $kar): ?>
                                <span class="characteristic-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-[#3d453c]">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    <?= htmlspecialchars($kar) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-6 border-t border-gray-200">
                    <button onclick="handleDownloadResults()" class="bg-[#3d453c] hover:bg-[#2a3028] text-white font-bold py-3 px-6 rounded-full inline-flex items-center justify-center gap-x-2 group transition-all duration-300 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-y-[-2px] transition-transform">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" x2="12" y1="15" y2="3" />
                        </svg>
                        Unduh Hasil Lengkap
                    </button>
                    <a href="../index.php" class="bg-gray-200 hover:bg-gray-300 text-[#3d453c] font-bold py-3 px-6 rounded-full inline-flex items-center justify-center gap-x-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 2v6h6" />
                            <path d="M21 12A9 9 0 0 0 6 5.3L3 8" />
                            <path d="M21 22v-6h-6" />
                            <path d="M3 12a9 9 0 0 0 15 6.7l3-2.7" />
                        </svg>
                        Ulangi Konsultasi
                    </a>
                </div>

            </div>
        </div>

        <!-- Material Alternatif -->
        <?php if ($alternatif && isset($alternatif['material']) && count($alternatif['material']) > 0): ?>
            <div class="max-w-5xl mx-auto mb-12 slide-up-delay-1">
                <div class="bg-white/60 backdrop-blur-lg border border-white/40 rounded-2xl shadow-lg p-8 md:p-12">
                    <h3 class="text-2xl font-display font-semibold text-[#3d453c] mb-2 flex items-center gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                            <line x1="12" y1="22.08" x2="12" y2="12" />
                        </svg>
                        Material Alternatif
                    </h3>
                    <p class="text-[#6c7a67] mb-6"><?= htmlspecialchars($alternatif['keterangan'] ?? '') ?></p>

                    <div class="grid md:grid-cols-2 gap-4">
                        <?php foreach ($alternatif['material'] as $alt): ?>
                            <div class="alternative-card bg-gray-50/50 p-5 rounded-xl border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-semibold text-[#3d453c]"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $alt))) ?></span>
                                    <?php if (isset($skor_detail[$alt])): ?>
                                        <span class="text-sm font-bold text-[#6c7a67]"><?= $skor_detail[$alt] ?> poin</span>
                                    <?php endif; ?>
                                </div>
                                <?php if (isset($skor_detail[$alt]) && !empty($skor_detail)): ?>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="score-bar" style="width: <?= (float)$skor_detail[$alt] / max(array_values($skor_detail)) * 100 ?>%"></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Detail Scoring -->
        <?php if (!empty($skor_detail)): ?>
            <div class="max-w-5xl mx-auto mb-12">
                <details class="bg-white/60 backdrop-blur-lg border border-white/40 rounded-2xl shadow-lg p-8 md:p-12">
                    <summary class="cursor-pointer text-xl font-display font-semibold text-[#3d453c] mb-4 flex items-center gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="20" x2="12" y2="10" />
                            <line x1="18" y1="20" x2="18" y2="4" />
                            <line x1="6" y1="20" x2="6" y2="16" />
                        </svg>
                        Detail Scoring Semua Material
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>



                    </summary>

                    <div class="mt-6 space-y-3">
                        <?php
                        arsort($skor_detail);
                        $max_score = max(array_values($skor_detail));
                        foreach ($skor_detail as $material => $score):
                        ?>
                            <div class="bg-gray-50/50 p-4 rounded-xl border">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-[#3d453c]"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $material))) ?></span>
                                    <span class="font-bold text-[#3d453c]"><?= $score ?> poin</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                    <div class="score-bar" style="width: <?= ($score / $max_score * 100) ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </details>
            </div>
        <?php endif; ?>

        <!-- Detail Kriteria Anda -->
        <div class="max-w-5xl mx-auto mb-12 slide-up-delay-2">
            <div class="bg-white/60 backdrop-blur-lg border border-white/40 rounded-2xl shadow-lg p-8 md:p-12">
                <h3 class="text-2xl font-display font-semibold text-[#3d453c] mb-6 flex items-center gap-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <line x1="10" y1="9" x2="8" y2="9" />
                    </svg>
                    Kriteria Yang Anda Pilih
                </h3>

                <div class="grid md:grid-cols-2 gap-4">
                    <?php foreach ($jawaban_pengguna as $key => $value):
                        $formatted = format_jawaban($key, $value);
                    ?>
                        <div class="bg-gray-50/50 p-4 rounded-xl border">
                            <div class="text-sm text-[#6c7a67] mb-1"><?= $formatted['label'] ?></div>
                            <div class="font-semibold text-[#3d453c]"><?= $formatted['value'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <footer class="text-center mt-8 text-[#6c7a67] fade-in" style="animation-delay: 0.3s;">
            <p class="font-light">
                💡 Gunakan hasil ini sebagai panduan awal dalam diskusi teknis lebih lanjut.
            </p>
        </footer>

    </div>

    <script>
        const dataToDownload = <?php echo json_encode($data_for_js); ?>;

        function handleDownloadResults() {
            let resultsText = `╔════════════════════════════════════════════════╗\n`;
            resultsText += `║  HASIL REKOMENDASI SISTEM PAKAR MATERIAL DASHBOARD        ║\n`;
            resultsText += `╚════════════════════════════════════════════════╝\n\n`;

            resultsText += `🏆 REKOMENDASI MATERIAL : \n`;
            resultsText += `${dataToDownload.rekomendasi}\n\n`;

            resultsText += `📊 CONFIDENCE LEVEL : \n`;
            resultsText += `${dataToDownload.confidence}\n\n`;

            resultsText += `💡 ALASAN REKOMENDASI : \n`;
            resultsText += `${dataToDownload.alasan}\n\n`;

            if (dataToDownload.karakteristik && dataToDownload.karakteristik.length > 0) {
                resultsText += `✨ KARAKTERISTIK UTAMA : \n`;
                dataToDownload.karakteristik.forEach((k, i) => {
                    resultsText += `${i + 1}. ${k}\n`;
                });
                resultsText += `\n`;
            }

            if (dataToDownload.alternatif && dataToDownload.alternatif.material) {
                resultsText += `🔄 MATERIAL ALTERNATIF : \n`;
                dataToDownload.alternatif.material.forEach((mat, i) => {
                    const score = dataToDownload.skor_detail[mat] || 'N/A';
                    resultsText += `${i + 1}. ${mat} (${score} poin)\n`;
                });
                resultsText += `\n`;
            }

            resultsText += `─────────────────────────────────────────────────────────\n`;
            resultsText += `📋 KRITERIA YANG ANDA PILIH\n`;
            resultsText += `─────────────────────────────────────────────────────────\n`;
            for (const [key, value] of Object.entries(dataToDownload.jawaban)) {
                const formatted = key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' ');
                resultsText += `${formatted}: ${value}\n`;
            }

            if (dataToDownload.skor_detail) {
                resultsText += `\n─────────────────────────────────────────────────────────\n`;
                resultsText += `📊 DETAIL SCORING SEMUA MATERIAL\n`;
                resultsText += `─────────────────────────────────────────────────────────\n`;

                const sortedScores = Object.entries(dataToDownload.skor_detail)
                    .sort((a, b) => b[1] - a[1]);

                sortedScores.forEach(([material, score], i) => {
                    resultsText += `${i + 1}. ${material}: ${score} poin\n`;
                });
            }

            resultsText += `\n─────────────────────────────────────────────────────────\n`;
            resultsText += `Generated by: Sistem Pakar Material Dashboard\n`;
            resultsText += `Date: ${new Date().toLocaleString('id-ID')}\n`;

            const blob = new Blob([resultsText], {
                type: 'text/plain;charset=utf-8'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `hasil-rekomendasi-material-${Date.now()}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    </script>
</body>

</html>