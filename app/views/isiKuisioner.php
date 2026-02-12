
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studia - Kuesioner</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php include 'components/header.php'; ?>

    <main class="container">
        <div class="progress-container">
            <div class="progress-info">
                <span>Pertanyaan 1 dari 3</span>
                <span class="percentage">33%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill"></div>
            </div>
        </div>

        <div class="card">
            <h2 class="question-title">Apa yang paling menarik perhatian Anda?</h2>
            <p class="question-subtitle">Apa yang paling menarik perhatian Anda?</p>

            <div class="options-group">
                <button class="option-btn">Teknologi dan Inovasi</button>
                <button class="option-btn">Seni dan Kreativitas</button>
                <button class="option-btn">Komunikasi dan Interaksi sosial</button>
                <button class="option-btn">Bisnis dan kewirausahaan</button>
            </div>

            <div class="card-footer">
                <button class="btn-back">
                    <i class="fa-solid fa-chevron-left"></i> Kembali
                </button>
                <button class="btn-next">
                    Lanjut <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <p class="skip-link">Lewati dan pilih keterampilan langsung</p>
    </main>

</body>
</html>