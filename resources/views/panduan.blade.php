@extends('layouts.app')

@section('title', 'Panduan Penggunaan')

@section('content')
<x-page-header title="Panduan Penggunaan" />

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-3">Alur Kerja Sistem Kerjao</h3>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            @foreach([
                                ['label' => 'Program Kerja', 'class' => 'bg-primary-lt text-primary'],
                                ['label' => 'Kegiatan', 'class' => 'bg-purple-lt text-purple'],
                                ['label' => 'Task', 'class' => 'bg-azure-lt text-azure'],
                                ['label' => 'Daily Scrum', 'class' => 'bg-success-lt text-success'],
                                ['label' => 'Bukti Aktivitas', 'class' => 'bg-warning-lt text-warning'],
                                ['label' => 'Laporan PDF', 'class' => 'bg-danger-lt text-danger'],
                            ] as $i => $step)
                            @if($i > 0)
                            <span class="text-secondary">/</span>
                            @endif
                            <span class="badge {{ $step['class'] }}">{{ $step['label'] }}</span>
                            @endforeach
                        </div>
                        <p class="text-secondary mt-3 mb-0">
                            Semua aktivitas berakar dari <strong>Program Kerja</strong>. Pastikan program dan kegiatan sudah dibuat sebelum menambahkan task.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary-lt">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-primary text-white">1</span>
                            <div>
                                <h3 class="card-title mb-1">Program Kerja</h3>
                                <div class="text-secondary small">Wadah utama untuk mengelompokkan seluruh kegiatan kerja dalam satu periode</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6">
                                <h4 class="mb-3">Cara Mengisi</h4>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><strong>Nama Program</strong> - Nama resmi program kerja, contoh: "Pengembangan SIMAK 2026"</li>
                                    <li class="mb-2"><strong>Deskripsi</strong> - Penjelasan singkat tujuan dan lingkup program</li>
                                    <li class="mb-2"><strong>Waktu Mulai &amp; Selesai</strong> - Rentang waktu pelaksanaan program</li>
                                    <li class="mb-0"><strong>Status</strong> - Pilih sesuai kondisi: Perencanaan, Aktif, Selesai, atau Ditunda</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-3">Status Program</h4>
                                <div class="d-flex flex-column gap-2">
                                    <div><span class="badge bg-secondary-lt text-secondary">Perencanaan</span> <span class="text-secondary small">Program sedang dirancang, belum dimulai</span></div>
                                    <div><span class="badge bg-success-lt text-success">Aktif</span> <span class="text-secondary small">Program sedang berjalan</span></div>
                                    <div><span class="badge bg-azure-lt text-azure">Selesai</span> <span class="text-secondary small">Program telah selesai dilaksanakan</span></div>
                                    <div><span class="badge bg-warning-lt text-warning">Ditunda</span> <span class="text-secondary small">Program dihentikan sementara</span></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-primary mb-0" role="alert">
                                    Hanya Admin dan Pimpinan yang dapat membuat program kerja. Pegawai hanya dapat melihat.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-purple-lt">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-purple text-white">2</span>
                            <div>
                                <h3 class="card-title mb-1">Kegiatan</h3>
                                <div class="text-secondary small">Sub-bagian dari Program Kerja yang merepresentasikan setiap aktivitas besar</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6">
                                <h4 class="mb-3">Cara Mengisi</h4>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><strong>Program Kerja</strong> - Pilih program kerja yang menaungi kegiatan ini</li>
                                    <li class="mb-2"><strong>Nama Kegiatan</strong> - Nama spesifik kegiatan, contoh: "Analisis Kebutuhan Sistem"</li>
                                    <li class="mb-2"><strong>Target Capaian</strong> - Output yang diharapkan dari kegiatan ini</li>
                                    <li class="mb-2"><strong>Waktu Mulai &amp; Selesai</strong> - Rentang waktu kegiatan dalam periode program</li>
                                    <li class="mb-0"><strong>Status</strong> - Update status sesuai perkembangan kegiatan</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-3">Hubungan</h4>
                                <div class="card card-sm bg-body-secondary border-0">
                                    <div class="card-body">
                                        <p class="mb-2">1 Program Kerja dapat memiliki <strong>banyak Kegiatan</strong>.</p>
                                        <p class="mb-2">1 Kegiatan dapat memiliki <strong>banyak Task</strong>.</p>
                                        <p class="text-secondary small mb-0">Contoh: Program "SIMAK 2026" -> Kegiatan "Pengembangan Backend" -> Task "Buat API Pegawai"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-azure-lt">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-azure text-white">3</span>
                            <div>
                                <h3 class="card-title mb-1">Task</h3>
                                <div class="text-secondary small">Pekerjaan spesifik yang dibebankan kepada pegawai, dengan progres yang dapat dilacak</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6">
                                <h4 class="mb-3">Cara Mengisi</h4>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><strong>Kegiatan</strong> - Pilih kegiatan yang menaungi task ini</li>
                                    <li class="mb-2"><strong>Nama Task</strong> - Gunakan deskripsi singkat dengan kata kerja yang jelas</li>
                                    <li class="mb-2"><strong>Ditugaskan ke</strong> - Pilih pegawai penanggung jawab task</li>
                                    <li class="mb-2"><strong>Prioritas</strong> - Tentukan urgensi: Rendah, Sedang, atau Tinggi</li>
                                    <li class="mb-2"><strong>Tenggat Waktu</strong> - Batas penyelesaian task</li>
                                    <li class="mb-2"><strong>Progres (%)</strong> - Update persentase penyelesaian berkala</li>
                                    <li class="mb-0"><strong>Status</strong> - Ubah status sesuai kondisi terkini</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-3">Status Task</h4>
                                <div class="d-flex flex-column gap-2">
                                    <div><span class="badge bg-secondary-lt text-secondary">Belum Dimulai</span> <span class="text-secondary small">Task baru dibuat, belum dikerjakan</span></div>
                                    <div><span class="badge bg-azure-lt text-azure">Sedang Berjalan</span> <span class="text-secondary small">Task sedang dikerjakan</span></div>
                                    <div><span class="badge bg-success-lt text-success">Selesai</span> <span class="text-secondary small">Task telah selesai 100%</span></div>
                                    <div><span class="badge bg-danger-lt text-danger">Dibatalkan</span> <span class="text-secondary small">Task tidak dilanjutkan</span></div>
                                </div>
                                <div class="alert alert-azure mt-3 mb-0" role="alert">
                                    Gunakan menu <em>Task Saya</em> di sidebar untuk melihat hanya task yang ditugaskan kepada Anda.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success-lt">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-success text-white">4</span>
                            <div>
                                <h3 class="card-title mb-1">Daily Scrum</h3>
                                <div class="text-secondary small">Catatan harian aktivitas kerja pegawai yang diisi setiap hari kerja untuk tiap task yang dikerjakan</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6">
                                <h4 class="mb-3">Cara Mengisi</h4>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><strong>Tanggal</strong> - Tanggal hari kerja saat scrum diisi</li>
                                    <li class="mb-2"><strong>Task</strong> - Task yang dikerjakan hari ini</li>
                                    <li class="mb-2"><strong>Rencana Kerja Harian</strong> - Apa yang akan atau sudah dikerjakan</li>
                                    <li class="mb-2"><strong>Indikator Capaian</strong> - Target atau output spesifik yang diharapkan selesai</li>
                                    <li class="mb-2"><strong>Potensi Risiko</strong> - Hambatan yang mungkin ditemui</li>
                                    <li class="mb-2"><strong>Realisasi</strong> - Apa yang benar-benar berhasil diselesaikan</li>
                                    <li class="mb-0"><strong>Rencana Tindak Lanjut</strong> - Kelanjutan pekerjaan esok hari</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-sm border-success">
                                    <div class="card-body">
                                        <h4 class="mb-3 text-success">Contoh Pengisian</h4>
                                        <div class="small d-flex flex-column gap-2">
                                            <div><strong>Rencana Kerja:</strong> Melanjutkan implementasi API endpoint CRUD pegawai dan penambahan validasi input.</div>
                                            <div><strong>Indikator Capaian:</strong> Endpoint GET /api/pegawai dan POST /api/pegawai selesai dan teruji.</div>
                                            <div><strong>Potensi Risiko:</strong> Ketergantungan pada struktur tabel yang mungkin berubah.</div>
                                            <div><strong>Realisasi:</strong> Endpoint GET dan POST selesai, endpoint PUT masih dalam proses.</div>
                                            <div><strong>Tindak Lanjut:</strong> Lanjutkan endpoint PUT dan DELETE esok hari.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-warning mt-3 mb-0" role="alert">
                                    Isi Daily Scrum <em>setiap hari kerja</em> agar capaian Anda tercatat di Laporan Bulanan.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning-lt">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-warning text-white">5</span>
                            <div>
                                <h3 class="card-title mb-1">Bukti Aktivitas, GitHub &amp; WakaTime</h3>
                                <div class="text-secondary small">Dokumentasi pendukung sebagai bukti pekerjaan yang telah dilakukan</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-4">
                                <div class="card card-sm h-100">
                                    <div class="card-body">
                                        <h4 class="mb-2">Bukti Aktivitas</h4>
                                        <p class="text-secondary small">Lampirkan bukti pendukung pekerjaan.</p>
                                        <ul class="list-unstyled small mb-0">
                                            <li class="mb-1"><strong>Link</strong> - URL halaman atau dokumen online</li>
                                            <li class="mb-1"><strong>Dokumen</strong> - File PDF, Word, atau Excel</li>
                                            <li class="mb-1"><strong>Foto</strong> - Screenshot atau foto kegiatan</li>
                                            <li class="mb-1"><strong>Catatan</strong> - Ringkasan teks</li>
                                            <li class="mb-0"><strong>Lainnya</strong> - Jenis bukti lain</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-sm h-100">
                                    <div class="card-body">
                                        <h4 class="mb-2">GitHub Activity</h4>
                                        <p class="text-secondary small">Catat aktivitas commit ke repository.</p>
                                        <ul class="list-unstyled small mb-0">
                                            <li class="mb-1"><strong>Repository</strong> - Nama repo dengan format owner/repo</li>
                                            <li class="mb-1"><strong>Branch</strong> - Nama branch yang digunakan</li>
                                            <li class="mb-1"><strong>Commit Hash</strong> - Hash SHA commit 7 sampai 40 karakter</li>
                                            <li class="mb-1"><strong>Commit Time</strong> - Waktu commit dilakukan</li>
                                            <li class="mb-1"><strong>PR/Issue Link</strong> - URL Pull Request atau Issue</li>
                                            <li class="mb-0"><strong>Commit Message</strong> - Pesan commit</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-sm h-100">
                                    <div class="card-body">
                                        <h4 class="mb-2">WakaTime Activity</h4>
                                        <p class="text-secondary small">Catat durasi coding dari WakaTime.</p>
                                        <ul class="list-unstyled small mb-0">
                                            <li class="mb-1"><strong>Tanggal</strong> - Tanggal aktivitas coding</li>
                                            <li class="mb-1"><strong>Project Name</strong> - Nama project di WakaTime</li>
                                            <li class="mb-1"><strong>Language</strong> - Bahasa pemrograman utama</li>
                                            <li class="mb-0"><strong>Durasi (jam)</strong> - Total jam coding, misalnya 2.5 berarti 2 jam 30 menit</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-danger-lt">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-danger text-white">6</span>
                            <div>
                                <h3 class="card-title mb-1">Laporan Bulanan</h3>
                                <div class="text-secondary small">Rekap otomatis seluruh aktivitas dalam satu bulan yang dapat diekspor ke PDF</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-md-6">
                                <h4 class="mb-3">Cara Menggunakan</h4>
                                <ol class="mb-0">
                                    <li class="mb-2">Pilih <strong>Bulan</strong> dan <strong>Tahun</strong> yang ingin dilihat.</li>
                                    <li class="mb-2">Filter berdasarkan <strong>Pegawai</strong> tertentu bila perlu.</li>
                                    <li class="mb-2">Filter berdasarkan <strong>Program Kerja</strong> tertentu bila perlu.</li>
                                    <li class="mb-2">Klik <strong>Filter</strong> untuk menampilkan data.</li>
                                    <li class="mb-0">Klik <strong>Export PDF</strong> untuk mengunduh laporan.</li>
                                </ol>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-3">Isi Laporan</h4>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">Rekap semua task beserta status dan progres.</li>
                                    <li class="mb-2">Total jam WakaTime per task.</li>
                                    <li class="mb-2">Rekap daily scrum seluruh periode.</li>
                                    <li class="mb-0">Ringkasan statistik seperti total task, task selesai, dan jam coding.</li>
                                </ul>
                                <div class="alert alert-danger mt-3 mb-0" role="alert">
                                    Fitur Export PDF hanya tersedia untuk Admin dan Pimpinan.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
