<?php

return [
    'brand' => [
        'name' => 'STUDIA',
        'logo' => 'fa-solid fa-book'
    ],
    'stats' => [
        [
            'value' => '100+',
            'label' => 'Keterampilan Tersedia',
            'color' => 'var(--primary-color)'
        ],
        [
            'value' => '50+',
            'label' => 'Mentor Berpengalaman',
            'color' => 'var(--secondary-color)'
        ],
        [
            'value' => '200+',
            'label' => 'Sesi Bimbingan Selesai',
            'color' => '#f59e0b'
        ],
        [
            'value' => '98%',
            'label' => 'Siswa Puas',
            'color' => '#ec4899'
        ]
    ],
    'features' => [
        [
            'icon' => 'fa-solid fa-dice',
            'title' => 'Gacha Mentor Cerdas',
            'desc' => 'Jawab kuesioner minat, sistem kami akan secara otomatis mencocokkan kamu dengan mentor terbaik di bidangnya.',
            'bg' => 'rgba(79,70,229,0.2)',
            'color' => '#818cf8'
        ],
        [
            'icon' => 'fa-solid fa-calendar-check',
            'title' => 'Jadwal Fleksibel',
            'desc' => 'Pilih tanggal dan waktu yang cocok untukmu. Mentor mengkonfirmasi jadwal dan memberikan link meeting langsung di platform.',
            'bg' => 'rgba(16,185,129,0.2)',
            'color' => '#34d399'
        ],
        [
            'icon' => 'fa-solid fa-comments',
            'title' => 'Chat Real-time',
            'desc' => 'Diskusikan materi, kirim pertanyaan, dan berikan umpan balik langsung kepada mentor melalui fitur obrolan bawaan.',
            'bg' => 'rgba(245,158,11,0.2)',
            'color' => '#fbbf24'
        ],
        [
            'icon' => 'fa-solid fa-shield-halved',
            'title' => 'Mentor Terverifikasi',
            'desc' => 'Setiap mentor melewati proses persetujuan oleh Admin sebelum bisa mengajar, memastikan kualitas bimbingan terjaga.',
            'bg' => 'rgba(236,72,153,0.2)',
            'color' => '#f472b6'
        ]
    ],
    'steps' => [
        [
            'num' => 1,
            'title' => 'Daftar & Isi Kuesioner',
            'desc' => 'Buat akun siswa dan jawab pertanyaan singkat tentang minat dan tujuan belajarmu.',
            'bg' => 'var(--primary-color)'
        ],
        [
            'num' => 2,
            'title' => 'Pilih Keterampilan',
            'desc' => 'Sistem akan merekomendasikan keterampilan. Kamu bebas memilih sesuai rekomendasinya, atau memilih yang lain.',
            'bg' => 'var(--secondary-color)'
        ],
        [
            'num' => 3,
            'title' => 'Gacha Mentormu!',
            'desc' => 'Tekan tombol, dan sistem akan mencarikan 1 mentor yang spesialis di bidangmu secara otomatis.',
            'bg' => '#f59e0b'
        ],
        [
            'num' => 4,
            'title' => 'Mulai Bimbingan',
            'desc' => 'Ajukan jadwal, mentor konfirmasi dengan link meeting, dan mulailah sesi bimbinganmu!',
            'bg' => '#ec4899'
        ]
    ],
    'testimonials' => [
        [
            'text' => 'Awalnya bingung mau belajar apa, tapi setelah mengisi kuesioner dan dapat rekomendasi Web Dev, saya langsung cocok sama mentor yang diberikan. Sesi pertama sangat membantu!',
            'name' => 'Andi Pratama',
            'role' => 'Siswa — Web Development',
            'initial' => 'A',
            'gradient' => 'linear-gradient(135deg, #4f46e5, #818cf8)'
        ],
        [
            'text' => 'Fitur gacha mentornya unik banget! Saya dapat mentor yang super sabar dan profesional. Proses dari daftar sampai sesi pertama sangat mulus dan tidak ribet.',
            'name' => 'Siska Ayu',
            'role' => 'Siswa — Desain Grafis',
            'initial' => 'S',
            'gradient' => 'linear-gradient(135deg, #10b981, #34d399)'
        ],
        [
            'text' => 'Sebagai mentor, platform ini memudahkan saya mengatur jadwal dengan murid. Link Zoom langsung bisa saya masukkan saat konfirmasi, sangat praktis dan profesional.',
            'name' => 'Budi Santoso',
            'role' => 'Mentor — Public Speaking',
            'initial' => 'B',
            'gradient' => 'linear-gradient(135deg, #f59e0b, #fbbf24)'
        ]
    ]
];
