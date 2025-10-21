<?php
session_start();

// Autoloader dari Composer
require_once __DIR__ . '/../../vendor/autoload.php';

// Apakah ada data laporan di session ?
if (!isset($_SESSION['report_data'])) {
    die("Data laporan tidak ditemukan. Silakan ulangi proses dari awal.");
}

// Ambil data dari session
$data = $_SESSION['report_data'];

// Salin fungsi format_jawaban dari hasil.php
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
            $map = ['sangat_penting' => 'Sangat Penting', 'cukup_penting' => 'Cukup Penting', 'standar' => 'Standar'];
            $formatted = $map[$value] ?? ucfirst($value);
            break;
        case 'estetika':
            $map = ['low_gloss' => 'Low-Gloss', 'beragam' => 'Beragam Tekstur', 'seragam' => 'Seragam dengan Komponen Lain'];
            $formatted = $map[$value] ?? ucfirst($value);
            break;
        default:
            $formatted = ucfirst($value);
    }
    return ['label' => $label, 'value' => $formatted];
}


// Objek mPDF
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 20,
    'margin_bottom' => 20,
]);

// Panggil konten HTML untuk PDF
ob_start();
?>

<style>
    body {
        font-family: sans-serif;
        font-size: 11pt;
        color: #333;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #3d453c;
        padding-bottom: 10px;
    }

    .header h1 {
        font-size: 20pt;
        color: #3d453c;
        margin: 0;
    }

    .header p {
        font-size: 10pt;
        color: #6c7a67;
        margin: 5px 0 0 0;
    }

    h2 {
        font-size: 14pt;
        color: #3d453c;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
        margin-top: 25px;
        margin-bottom: 10px;
    }

    .section {
        background-color: #f9f9f9;
        border: 1px solid #eee;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .section-highlight {
        background-color: #eaf1ee;
        border-left: 5px solid #3d453c;
    }

    .section p {
        line-height: 1.6;
    }

    .label {
        font-weight: bold;
        color: #3d453c;
    }

    .list-karakteristik {
        list-style-type: '✓ ';
        padding-left: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 9pt;
        color: #aaa;
    }
</style>

<body>
    <div class="header">
        <h1>Laporan Hasil Rekomendasi Material</h1>
        <p>Sistem Pakar Otomotif | Dibuat pada: <?= date('d F Y H:i') ?></p>
    </div>

    <h2>Hasil Rekomendasi Utama</h2>
    <div class="section section-highlight">
        <p><span class="label">Material Direkomendasikan:</span> <strong><?= $data['rekomendasi'] ?></strong></p>
        <p><span class="label">Tingkat Keyakinan (Confidence):</span> <?= $data['confidence'] ?></p>
        <p><span class="label">Alasan:</span> <?= $data['alasan'] ?></p>
    </div>

    <?php if (!empty($data['karakteristik'])): ?>
        <h2>Karakteristik Utama Material</h2>
        <div class="section">
            <ul class="list-karakteristik">
                <?php foreach ($data['karakteristik'] as $kar): ?>
                    <li><?= htmlspecialchars($kar) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <h2>Kriteria yang Anda Pilih</h2>
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th>Pilihan Anda</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['jawaban'] as $key => $value):
                    $formatted = format_jawaban($key, $value);
                ?>
                    <tr>
                        <td><?= $formatted['label'] ?></td>
                        <td><?= $formatted['value'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($data['skor_detail'])):
        $skor_detail = $data['skor_detail'];
        arsort($skor_detail);
    ?>
        <h2>Detail Peringkat Semua Material</h2>
        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Peringkat</th>
                        <th>Nama Material</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rank = 1;
                    foreach ($skor_detail as $material => $score): ?>
                        <tr>
                            <td><?= $rank++ ?></td>
                            <td><?= htmlspecialchars(ucwords(str_replace('_', ' ', $material))) ?></td>
                            <td><?= $score ?> poin</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="footer">
        Laporan ini dibuat secara otomatis oleh Sistem Pakar Rekomendasi Material.
    </div>

</body>

<?php
$html = ob_get_contents(); // Ambil konten HTML dari buffer
ob_end_clean(); // Hentikan dan bersihkan buffer

// Tulis HTML ke PDF
$mpdf->WriteHTML($html);

// Tampilkan PDF di browser
$filename = "laporan-rekomendasi-" . date('Ymd-His') . ".pdf";
$mpdf->Output($filename, 'I'); // 'I' untuk inline (tampil di browser), 'D' untuk download

exit;
