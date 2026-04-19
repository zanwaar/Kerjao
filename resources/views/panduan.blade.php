@extends('layouts.app')
@section('title', 'Panduan Penggunaan')
@section('content')
<x-page-header title="Panduan Penggunaan" />

<div class="max-w-4xl space-y-5">

    {{-- Alur Kerja --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-4">Alur Kerja Sistem Kerjao</h2>
        <div class="flex items-center gap-2 flex-wrap">
            @foreach([
                ['label' => 'Program Kerja', 'color' => 'bg-indigo-100 text-indigo-700'],
                ['label' => 'Kegiatan', 'color' => 'bg-purple-100 text-purple-700'],
                ['label' => 'Task', 'color' => 'bg-blue-100 text-blue-700'],
                ['label' => 'Daily Scrum', 'color' => 'bg-green-100 text-green-700'],
                ['label' => 'Bukti Aktivitas', 'color' => 'bg-yellow-100 text-yellow-700'],
                ['label' => 'Laporan PDF', 'color' => 'bg-red-100 text-red-700'],
            ] as $i => $step)
            @if($i > 0)
            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            @endif
            <span class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $step['color'] }}">{{ $step['label'] }}</span>
            @endforeach
        </div>
        <p class="text-sm text-gray-500 mt-3">Semua aktivitas berakar dari <strong>Program Kerja</strong>. Pastikan program dan kegiatan sudah dibuat sebelum menambahkan task.</p>
    </div>

    {{-- Program Kerja --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-indigo-50">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white text-sm font-bold shrink-0">1</div>
            <div>
                <h2 class="font-semibold text-gray-800">Program Kerja</h2>
                <p class="text-xs text-gray-500">Wadah utama untuk mengelompokkan seluruh kegiatan kerja dalam satu periode</p>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Cara Mengisi</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-indigo-500 font-bold shrink-0">·</span><span><strong>Nama Program</strong> — Nama resmi program kerja, contoh: "Pengembangan SIMAK 2026"</span></li>
                        <li class="flex gap-2"><span class="text-indigo-500 font-bold shrink-0">·</span><span><strong>Deskripsi</strong> — Penjelasan singkat tujuan dan lingkup program</span></li>
                        <li class="flex gap-2"><span class="text-indigo-500 font-bold shrink-0">·</span><span><strong>Waktu Mulai & Selesai</strong> — Rentang waktu pelaksanaan program</span></li>
                        <li class="flex gap-2"><span class="text-indigo-500 font-bold shrink-0">·</span><span><strong>Status</strong> — Pilih sesuai kondisi: Perencanaan → Aktif → Selesai</span></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Status Program</h3>
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2 text-sm"><span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">Perencanaan</span><span class="text-gray-500">Program sedang dirancang, belum dimulai</span></div>
                        <div class="flex items-center gap-2 text-sm"><span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-medium">Aktif</span><span class="text-gray-500">Program sedang berjalan</span></div>
                        <div class="flex items-center gap-2 text-sm"><span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">Selesai</span><span class="text-gray-500">Program telah selesai dilaksanakan</span></div>
                        <div class="flex items-center gap-2 text-sm"><span class="px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium">Ditunda</span><span class="text-gray-500">Program dihentikan sementara</span></div>
                    </div>
                </div>
            </div>
            <div class="rounded-lg bg-indigo-50 border border-indigo-100 px-4 py-3 text-sm text-indigo-700">
                <strong>Catatan:</strong> Hanya Admin dan Pimpinan yang dapat membuat program kerja. Pegawai hanya dapat melihat.
            </div>
        </div>
    </div>

    {{-- Kegiatan --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-purple-50">
            <div class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center text-white text-sm font-bold shrink-0">2</div>
            <div>
                <h2 class="font-semibold text-gray-800">Kegiatan</h2>
                <p class="text-xs text-gray-500">Sub-bagian dari Program Kerja yang merepresentasikan setiap aktivitas besar</p>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Cara Mengisi</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-purple-500 font-bold shrink-0">·</span><span><strong>Program Kerja</strong> — Pilih program kerja yang menaungi kegiatan ini</span></li>
                        <li class="flex gap-2"><span class="text-purple-500 font-bold shrink-0">·</span><span><strong>Nama Kegiatan</strong> — Nama spesifik kegiatan, contoh: "Analisis Kebutuhan Sistem"</span></li>
                        <li class="flex gap-2"><span class="text-purple-500 font-bold shrink-0">·</span><span><strong>Target Capaian</strong> — Output yang diharapkan dari kegiatan ini</span></li>
                        <li class="flex gap-2"><span class="text-purple-500 font-bold shrink-0">·</span><span><strong>Waktu Mulai & Selesai</strong> — Rentang waktu kegiatan (dalam periode program)</span></li>
                        <li class="flex gap-2"><span class="text-purple-500 font-bold shrink-0">·</span><span><strong>Status</strong> — Update status sesuai perkembangan kegiatan</span></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Hubungan</h3>
                    <div class="rounded-lg bg-gray-50 border border-gray-100 p-3 text-sm text-gray-600 space-y-1">
                        <p>1 Program Kerja dapat memiliki <strong>banyak Kegiatan</strong></p>
                        <p>1 Kegiatan dapat memiliki <strong>banyak Task</strong></p>
                        <p class="text-gray-400 text-xs mt-2">Contoh: Program "SIMAK 2026" → Kegiatan "Pengembangan Backend" → Task "Buat API Pegawai"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Task --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-blue-50">
            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white text-sm font-bold shrink-0">3</div>
            <div>
                <h2 class="font-semibold text-gray-800">Task</h2>
                <p class="text-xs text-gray-500">Pekerjaan spesifik yang dibebankan kepada pegawai, dengan progres yang dapat dilacak</p>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Cara Mengisi</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-blue-500 font-bold shrink-0">·</span><span><strong>Kegiatan</strong> — Pilih kegiatan yang menaungi task ini</span></li>
                        <li class="flex gap-2"><span class="text-blue-500 font-bold shrink-0">·</span><span><strong>Nama Task</strong> — Deskripsi singkat pekerjaan, gunakan kata kerja: "Buat...", "Implementasi...", "Review..."</span></li>
                        <li class="flex gap-2"><span class="text-blue-500 font-bold shrink-0">·</span><span><strong>Ditugaskan ke</strong> — Pilih pegawai penanggung jawab task</span></li>
                        <li class="flex gap-2"><span class="text-blue-500 font-bold shrink-0">·</span><span><strong>Prioritas</strong> — Tentukan urgensi: Rendah / Sedang / Tinggi</span></li>
                        <li class="flex gap-2"><span class="text-blue-500 font-bold shrink-0">·</span><span><strong>Tenggat Waktu</strong> — Batas penyelesaian task</span></li>
                        <li class="flex gap-2"><span class="text-blue-500 font-bold shrink-0">·</span><span><strong>Progres (%)</strong> — Update persentase penyelesaian secara berkala (0–100)</span></li>
                        <li class="flex gap-2"><span class="text-blue-500 font-bold shrink-0">·</span><span><strong>Status</strong> — Ubah status sesuai kondisi terkini</span></li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Status Task</h3>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-sm"><span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">Belum Dimulai</span><span class="text-gray-500">Task baru dibuat, belum dikerjakan</span></div>
                            <div class="flex items-center gap-2 text-sm"><span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">Sedang Berjalan</span><span class="text-gray-500">Task sedang dikerjakan</span></div>
                            <div class="flex items-center gap-2 text-sm"><span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-medium">Selesai</span><span class="text-gray-500">Task telah selesai 100%</span></div>
                            <div class="flex items-center gap-2 text-sm"><span class="px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs font-medium">Dibatalkan</span><span class="text-gray-500">Task tidak dilanjutkan</span></div>
                        </div>
                    </div>
                    <div class="rounded-lg bg-blue-50 border border-blue-100 px-4 py-3 text-sm text-blue-700">
                        <strong>Tips:</strong> Gunakan menu <em>Task Saya</em> di sidebar untuk melihat hanya task yang ditugaskan kepada Anda.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Daily Scrum --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-green-50">
            <div class="w-8 h-8 rounded-lg bg-green-600 flex items-center justify-center text-white text-sm font-bold shrink-0">4</div>
            <div>
                <h2 class="font-semibold text-gray-800">Daily Scrum</h2>
                <p class="text-xs text-gray-500">Catatan harian aktivitas kerja pegawai, diisi <strong>setiap hari kerja</strong> untuk setiap task yang dikerjakan</p>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Cara Mengisi</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-green-500 font-bold shrink-0">·</span><span><strong>Tanggal</strong> — Tanggal hari ini (hari kerja)</span></li>
                        <li class="flex gap-2"><span class="text-green-500 font-bold shrink-0">·</span><span><strong>Task</strong> — Task yang dikerjakan pada hari ini</span></li>
                        <li class="flex gap-2"><span class="text-green-500 font-bold shrink-0">·</span><span><strong>Rencana Kerja Harian</strong> — Apa yang akan/sudah Anda kerjakan hari ini</span></li>
                        <li class="flex gap-2"><span class="text-green-500 font-bold shrink-0">·</span><span><strong>Indikator Capaian</strong> — Target atau output spesifik yang diharapkan selesai</span></li>
                        <li class="flex gap-2"><span class="text-green-500 font-bold shrink-0">·</span><span><strong>Potensi Risiko</strong> — Hambatan yang mungkin ditemui (opsional)</span></li>
                        <li class="flex gap-2"><span class="text-green-500 font-bold shrink-0">·</span><span><strong>Realisasi</strong> — Apa yang benar-benar berhasil diselesaikan (isi saat akhir hari)</span></li>
                        <li class="flex gap-2"><span class="text-green-500 font-bold shrink-0">·</span><span><strong>Rencana Tindak Lanjut</strong> — Kelanjutan yang akan dikerjakan besok</span></li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <div class="rounded-lg bg-green-50 border border-green-100 p-4">
                        <h3 class="text-sm font-semibold text-green-800 mb-2">Contoh Pengisian</h3>
                        <div class="space-y-2 text-xs text-green-700">
                            <div><span class="font-semibold">Rencana Kerja:</span> Melanjutkan implementasi API endpoint CRUD pegawai dan penambahan validasi input</div>
                            <div><span class="font-semibold">Indikator Capaian:</span> Endpoint GET /api/pegawai dan POST /api/pegawai selesai dan tertes</div>
                            <div><span class="font-semibold">Potensi Risiko:</span> Ketergantungan pada struktur tabel yang mungkin berubah</div>
                            <div><span class="font-semibold">Realisasi:</span> Berhasil menyelesaikan endpoint GET dan POST, endpoint PUT masih dalam proses</div>
                            <div><span class="font-semibold">Tindak Lanjut:</span> Lanjutkan endpoint PUT dan DELETE esok hari</div>
                        </div>
                    </div>
                    <div class="rounded-lg bg-yellow-50 border border-yellow-100 px-4 py-3 text-sm text-yellow-700">
                        <strong>Penting:</strong> Isi Daily Scrum <em>setiap hari kerja</em> untuk memastikan capaian Anda tercatat di Laporan Bulanan.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bukti Aktivitas --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-yellow-50">
            <div class="w-8 h-8 rounded-lg bg-yellow-500 flex items-center justify-center text-white text-sm font-bold shrink-0">5</div>
            <div>
                <h2 class="font-semibold text-gray-800">Bukti Aktivitas, GitHub & WakaTime</h2>
                <p class="text-xs text-gray-500">Dokumentasi pendukung sebagai bukti pekerjaan yang telah dilakukan</p>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Bukti Aktivitas</h3>
                    <p class="text-xs text-gray-500 mb-2">Lampirkan bukti pendukung pekerjaan</p>
                    <ul class="space-y-1 text-xs text-gray-600">
                        <li><strong>Link</strong> — URL halaman, dokumen online</li>
                        <li><strong>Dokumen</strong> — File PDF, Word, Excel</li>
                        <li><strong>Foto</strong> — Screenshot, foto kegiatan</li>
                        <li><strong>Catatan</strong> — Ringkasan teks</li>
                        <li><strong>Lainnya</strong> — Jenis bukti lain</li>
                    </ul>
                </div>
                <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">GitHub Activity</h3>
                    <p class="text-xs text-gray-500 mb-2">Catat aktivitas commit ke repository</p>
                    <ul class="space-y-1 text-xs text-gray-600">
                        <li><strong>Repository</strong> — Nama repo (format: owner/repo)</li>
                        <li><strong>Branch</strong> — Nama branch yang digunakan</li>
                        <li><strong>Commit Hash</strong> — Hash SHA commit (7–40 karakter)</li>
                        <li><strong>Commit Time</strong> — Waktu commit dilakukan</li>
                        <li><strong>PR/Issue Link</strong> — URL Pull Request atau Issue</li>
                        <li><strong>Commit Message</strong> — Pesan commit</li>
                    </ul>
                </div>
                <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">WakaTime Activity</h3>
                    <p class="text-xs text-gray-500 mb-2">Catat durasi coding dari WakaTime</p>
                    <ul class="space-y-1 text-xs text-gray-600">
                        <li><strong>Tanggal</strong> — Tanggal aktivitas coding</li>
                        <li><strong>Project Name</strong> — Nama project di WakaTime</li>
                        <li><strong>Language</strong> — Bahasa pemrograman utama</li>
                        <li><strong>Durasi (jam)</strong> — Total jam coding (misal: 2.5 = 2 jam 30 menit)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Laporan --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-red-50">
            <div class="w-8 h-8 rounded-lg bg-red-500 flex items-center justify-center text-white text-sm font-bold shrink-0">6</div>
            <div>
                <h2 class="font-semibold text-gray-800">Laporan Bulanan</h2>
                <p class="text-xs text-gray-500">Rekap otomatis seluruh aktivitas dalam satu bulan, dapat diekspor ke PDF</p>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Cara Menggunakan</h3>
                    <ol class="space-y-2 text-sm text-gray-600 list-decimal list-inside">
                        <li>Pilih <strong>Bulan</strong> dan <strong>Tahun</strong> yang ingin dilihat</li>
                        <li>Filter berdasarkan <strong>Pegawai</strong> tertentu (opsional)</li>
                        <li>Filter berdasarkan <strong>Program Kerja</strong> tertentu (opsional)</li>
                        <li>Klik <strong>Filter</strong> untuk menampilkan data</li>
                        <li>Klik <strong>Export PDF</strong> untuk mengunduh laporan</li>
                    </ol>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Isi Laporan</h3>
                    <ul class="space-y-1 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-red-400">·</span> Rekap semua task beserta status dan progres</li>
                        <li class="flex gap-2"><span class="text-red-400">·</span> Total jam WakaTime per task</li>
                        <li class="flex gap-2"><span class="text-red-400">·</span> Rekap daily scrum seluruh periode</li>
                        <li class="flex gap-2"><span class="text-red-400">·</span> Ringkasan statistik (total task, selesai, jam coding)</li>
                    </ul>
                    <div class="rounded-lg bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-700 mt-3">
                        <strong>Catatan:</strong> Fitur Export PDF hanya tersedia untuk Admin dan Pimpinan.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
