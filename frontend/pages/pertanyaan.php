<?php
// Pertanyaan berdasarkan karakteristik dari tabel
$questions = [
    [
        'id' => 'biaya',
        'type' => 'radio',
        'question' => 'Apakah biaya produksi yang rendah menjadi prioritas utama?',
        'description' => 'Pertimbangkan budget dan volume produksi Anda.',
        'options' => ['ya' => 'Ya, biaya rendah prioritas', 'tidak' => 'Tidak, kualitas lebih penting']
    ],
    [
        'id' => 'panas',
        'type' => 'select',
        'question' => 'Seberapa penting ketahanan terhadap suhu tinggi untuk aplikasi Anda?',
        'description' => 'Dashboard mobil terpapar panas dari mesin dan sinar matahari.',
        'options' => [
            'sangat_penting' => 'Sangat Penting (High-temperature application)',
            'cukup_penting' => 'Cukup Penting (Moderate temperature)',
            'standar' => 'Standar (Normal temperature)'
        ]
    ],
    [
        'id' => 'impak',
        'type' => 'radio',
        'question' => 'Apakah material harus memiliki kekuatan impak yang sangat tinggi?',
        'description' => 'Kekuatan impak penting untuk keselamatan dan ketahanan benturan.',
        'options' => ['ya' => 'Ya, sangat penting', 'tidak' => 'Tidak, standar saja']
    ],
    [
        'id' => 'suhu_rendah',
        'type' => 'radio',
        'question' => 'Apakah material harus tetap kuat pada suhu rendah/dingin?',
        'description' => 'Untuk kendaraan di daerah dengan iklim dingin.',
        'options' => ['ya' => 'Ya, akan digunakan di iklim dingin', 'tidak' => 'Tidak perlu'],
        'conditional' => ['impak' => 'ya'] // Hanya tampil jika impak = ya
    ],
    [
        'id' => 'estetika',
        'type' => 'select',
        'question' => 'Apa preferensi untuk tampilan permukaan akhir?',
        'description' => 'Sesuaikan dengan desain interior kendaraan.',
        'options' => [
            'low_gloss' => 'Tampilan Low-Gloss (tidak mengkilap)',
            'beragam' => 'Perlu Beragam Jenis Permukaan/Tekstur',
            'seragam' => 'Harus Seragam dengan Komponen Lain'
        ]
    ],
    [
        'id' => 'api',
        'type' => 'radio',
        'question' => 'Apakah material WAJIB memiliki ketahanan api (flame retardancy) tinggi?',
        'description' => 'Penting untuk standar keselamatan kendaraan.',
        'options' => ['ya' => 'Ya, wajib (Safety requirement)', 'tidak' => 'Tidak wajib']
    ],
    [
        'id' => 'proses',
        'type' => 'radio',
        'question' => 'Apakah kemudahan dalam proses produksi menjadi faktor penting?',
        'description' => 'Injection molding yang mudah dapat mengurangi biaya produksi.',
        'options' => ['ya' => 'Ya, harus mudah diproses', 'tidak' => 'Tidak masalah']
    ],
    [
        'id' => 'lingkungan',
        'type' => 'radio',
        'question' => 'Apakah kemampuan untuk didaur ulang (recyclability) menjadi pertimbangan?',
        'description' => 'Untuk sustainability dan regulasi lingkungan.',
        'options' => ['ya' => 'Ya, penting', 'tidak' => 'Tidak prioritas']
    ],
    [
        'id' => 'energi',
        'type' => 'radio',
        'question' => 'Apakah material perlu kemampuan menyerap energi benturan untuk keselamatan?',
        'description' => 'Energy-absorbing foam untuk perlindungan side impact.',
        'options' => ['ya' => 'Ya, untuk keselamatan penumpang', 'tidak' => 'Tidak perlu']
    ],
    [
        'id' => 'kekakuan',
        'type' => 'radio',
        'question' => 'Apakah material harus memiliki kekakuan (stiffness) yang tinggi?',
        'description' => 'Stiffness tinggi mencegah deformasi dan heat sag.',
        'options' => ['ya' => 'Ya, harus rigid/kaku', 'tidak' => 'Tidak, fleksibel boleh']
    ],
    [
        'id' => 'kimia',
        'type' => 'radio',
        'question' => 'Apakah material harus tahan terhadap retak akibat bahan kimia (chemical stress cracking)?',
        'description' => 'Penting jika terpapar cairan pembersih atau bahan kimia otomotif.',
        'options' => ['ya' => 'Ya, sering terpapar bahan kimia', 'tidak' => 'Tidak perlu']
    ],
    [
        'id' => 'serat',
        'type' => 'radio',
        'question' => 'Apakah material perlu diperkuat dengan glass fiber reinforcement?',
        'description' => 'Glass fiber meningkatkan kekuatan dan ketahanan panas.',
        'options' => ['ya' => 'Ya, perlu reinforcement', 'tidak' => 'Tidak perlu']
    ],
    [
        'id' => 'versatile',
        'type' => 'radio',
        'question' => 'Apakah Anda membutuhkan material yang sangat serbaguna (versatile)?',
        'description' => 'Material yang bisa digunakan untuk berbagai komponen (pillars, IP, door panels).',
        'options' => ['ya' => 'Ya, untuk multiple parts', 'tidak' => 'Tidak, untuk part spesifik']
    ],
    [
        'id' => 'blending',
        'type' => 'radio',
        'question' => 'Apakah material perlu dapat di-blend dengan material lain?',
        'description' => 'Untuk membuat sheet atau kombinasi material.',
        'options' => ['ya' => 'Ya, perlu blending capability', 'tidak' => 'Tidak perlu']
    ]
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Material | Sistem Pakar Otomotif</title>
    <link href="../public/style.css" rel="stylesheet">

    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .question-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .custom-radio-label {
            transition: all 0.2s ease-in-out;
        }

        .custom-radio:checked+.custom-radio-label {
            background-color: #3d453c;
            color: #ffffff;
            border-color: #3d453c;
        }

        .question-description {
            font-size: 0.875rem;
            color: #6c7a67;
            margin-top: 0.5rem;
            font-style: italic;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#f8f7f4] via-[#f2ede6] to-[#eaf1ee] font-body text-[#3d453c] min-h-screen flex items-center justify-center p-4">

    <div class="container mx-auto w-full max-w-4xl">

        <!-- Header dan Progress Bar -->
        <header class="flex items-center justify-between mb-8 px-2">
            <a href="../index.php" class="text-[#6c7a67] hover:text-[#3d453c] inline-flex items-center gap-x-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Kembali
            </a>
            <div class="text-center">
                <p id="progress-text" class="text-sm text-[#6c7a67] mb-1">Pertanyaan 1 dari <span id="total-questions">0</span></p>
                <div class="w-48 bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div id="progress-bar" class="bg-[#3d453c] h-full rounded-full transition-all duration-500" style="width: 0%;"></div>
                </div>
            </div>
            <div class="w-24"></div>
        </header>

        <!-- Kontainer Kuesioner -->
        <main class="bg-white/60 backdrop-blur-lg border border-white/40 rounded-2xl shadow-lg p-8 md:p-12">
            <form id="questionnaire-form" action="hasil.php" method="POST">

                <?php foreach ($questions as $index => $q): ?>
                    <div id="question-<?php echo $index; ?>"
                        class="question-container <?php echo $index > 0 ? 'hidden' : ''; ?>"
                        data-conditional="<?php echo isset($q['conditional']) ? htmlspecialchars(json_encode($q['conditional'])) : ''; ?>">

                        <h2 class="font-display text-2xl md:text-2xl font-medium text-[#3d453c] mb-3 text-center">
                            <?php echo htmlspecialchars($q['question']); ?>
                        </h2>

                        <?php if (isset($q['description'])): ?>
                            <p class="question-description text-center mb-8">
                                <?php echo htmlspecialchars($q['description']); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($q['type'] === 'radio'): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-md mx-auto">
                                <?php foreach ($q['options'] as $value => $label): ?>
                                    <div>
                                        <input type="radio"
                                            id="<?php echo $q['id'] . '_' . $value; ?>"
                                            name="<?php echo $q['id']; ?>"
                                            value="<?php echo $value; ?>"
                                            class="hidden custom-radio">
                                        <label for="<?php echo $q['id'] . '_' . $value; ?>"
                                            class="custom-radio-label block text-center border-2 border-gray-200 rounded-lg py-3 px-5 cursor-pointer hover:border-[#3d453c]">
                                            <?php echo htmlspecialchars($label); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        <?php elseif ($q['type'] === 'select'): ?>
                            <div class="max-w-md mx-auto">
                                <select name="<?php echo $q['id']; ?>"
                                    class="w-full bg-white border-2 border-gray-200 rounded-lg py-3 px-5 focus:border-[#3d453c] focus:ring-0 appearance-none">
                                    <?php foreach ($q['options'] as $value => $label): ?>
                                        <option value="<?php echo $value; ?>"><?php echo htmlspecialchars($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <!-- Navigasi -->
                <div class="flex justify-between items-center mt-12 pt-8 border-t border-gray-200">
                    <button type="button" id="prev-btn"
                        class="bg-gray-200 hover:bg-gray-300 text-[#3d453c] font-bold py-2 px-6 rounded-full inline-flex items-center gap-x-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Sebelumnya
                    </button>
                    <button type="button" id="next-btn"
                        class="bg-[#3d453c] hover:bg-[#2a3028] text-white font-bold py-2 px-6 rounded-full inline-flex items-center gap-x-2 group transition-colors">
                        <span>Selanjutnya</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const allQuestions = document.querySelectorAll('.question-container');
            const prevButton = document.getElementById('prev-btn');
            const nextButton = document.getElementById('next-btn');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            const totalQuestionsSpan = document.getElementById('total-questions');
            const form = document.getElementById('questionnaire-form');

            let currentQuestionIndex = 0;
            let visibleQuestions = [];
            let questionHistory = []; // Track navigation history

            // Fungsi untuk mengecek conditional logic
            function shouldShowQuestion(questionElement) {
                const conditionalData = questionElement.getAttribute('data-conditional');
                if (!conditionalData || conditionalData === '') return true;

                try {
                    const conditions = JSON.parse(conditionalData);
                    for (let [fieldName, requiredValue] of Object.entries(conditions)) {
                        const input = form.querySelector(`input[name="${fieldName}"]:checked, select[name="${fieldName}"]`);
                        if (!input || input.value !== requiredValue) {
                            return false;
                        }
                    }
                    return true;
                } catch (e) {
                    console.error('Error parsing conditional:', e);
                    return true;
                }
            }

            // Update daftar pertanyaan yang visible
            function updateVisibleQuestions() {
                visibleQuestions = Array.from(allQuestions).filter(q => shouldShowQuestion(q));
                totalQuestionsSpan.textContent = visibleQuestions.length;
            }

            function checkAnswer() {
                const currentQuestion = visibleQuestions[currentQuestionIndex];
                const input = currentQuestion.querySelector('input[type="radio"]:checked, select');

                if (input && input.value) {
                    nextButton.disabled = false;
                    nextButton.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    nextButton.disabled = true;
                    nextButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            function showQuestion(index) {
                updateVisibleQuestions();

                allQuestions.forEach(q => q.classList.add('hidden'));

                if (visibleQuestions[index]) {
                    visibleQuestions[index].classList.remove('hidden');
                    visibleQuestions[index].classList.add('question-slide-in');
                }

                const progressPercentage = ((index + 1) / visibleQuestions.length) * 100;
                progressBar.style.width = `${progressPercentage}%`;
                progressText.innerHTML = `Pertanyaan ${index + 1} dari <span id="total-questions">${visibleQuestions.length}</span>`;

                prevButton.disabled = index === 0;
                prevButton.classList.toggle('opacity-50', index === 0);

                if (index === visibleQuestions.length - 1) {
                    nextButton.innerHTML = `<span>Selesai & Dapatkan Hasil</span> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:scale-110 transition-transform"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`;
                } else {
                    nextButton.innerHTML = `<span>Selanjutnya</span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"/></svg>`;
                }

                checkAnswer();
            }

            function handleNext() {
                if (nextButton.disabled) return;

                if (currentQuestionIndex < visibleQuestions.length - 1) {
                    questionHistory.push(currentQuestionIndex);
                    currentQuestionIndex++;
                    showQuestion(currentQuestionIndex);
                } else {
                    form.submit();
                }
            }

            function handlePrev() {
                if (questionHistory.length > 0) {
                    currentQuestionIndex = questionHistory.pop();
                    showQuestion(currentQuestionIndex);
                } else if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    showQuestion(currentQuestionIndex);
                }
            }

            // Event listeners
            nextButton.addEventListener('click', handleNext);
            prevButton.addEventListener('click', handlePrev);
            form.addEventListener('change', () => {
                checkAnswer();
                updateVisibleQuestions();
            });

            // Inisialisasi
            updateVisibleQuestions();
            showQuestion(currentQuestionIndex);
        });
    </script>
</body>

</html>