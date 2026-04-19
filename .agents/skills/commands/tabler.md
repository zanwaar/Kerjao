# Tabler UI Framework Skill — Spring Boot + CDN

Skill ini digunakan untuk membuat halaman dan komponen Tabler sebagai file HTML standalone dengan CDN.
Output selalu disimpan di: `/Users/elabsid/Batukel-dev/tabler/html compores/`

**Project target:** Spring Boot (Thymeleaf / static resources)
**Aset gambar lokal:** `./static/` (sudah ada di `html compores/static/`)
**Tidak perlu build system** — semua via CDN.

---

## CDN yang Digunakan

```html
<!-- === CSS === -->
<link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-flags.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-payments.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
<style>@import url('https://rsms.me/inter/inter.css');</style>

<!-- === JS (akhir body, defer) === -->
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js" defer></script>

<!-- === Opsional: Charts === -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@5.10.4/dist/apexcharts.min.js" defer></script>

<!-- === Opsional: Maps === -->
<link href="https://cdn.jsdelivr.net/npm/jsvectormap@1.7.0/dist/css/jsvectormap.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.7.0/dist/js/jsvectormap.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.7.0/dist/maps/world.js" defer></script>
```

---

## Template Halaman Baru (WAJIB digunakan)

Setiap file baru di `html compores/` harus menggunakan struktur ini persis:

```html
<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.4.0
* @link https://tabler.io
* Copyright 2018-2026 The Tabler Authors
* Copyright 2018-2026 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
  <title>JUDUL HALAMAN - Tabler</title>

  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-flags.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-payments.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
  <style>@import url('https://rsms.me/inter/inter.css');</style>
</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler-theme.min.js"></script>

  <div class="page">

    <!-- ===== NAVBAR ===== -->
    <header class="navbar navbar-expand-md d-print-none" data-bs-theme="dark">
      <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
          <a href="." aria-label="Home">
            <svg xmlns="http://www.w3.org/2000/svg" width="110" height="32" viewBox="0 0 232 68" class="navbar-brand-image">
              <path d="M64.6 16.2C63 9.9 58.1 5 51.8 3.4 40 1.5 28 1.5 16.2 3.4 9.9 5 5 9.9 3.4 16.2 1.5 28 1.5 40 3.4 51.8 5 58.1 9.9 63 16.2 64.6c11.8 1.9 23.8 1.9 35.6 0C58.1 63 63 58.1 64.6 51.8c1.9-11.8 1.9-23.8 0-35.6zM33.3 36.3c-2.8 4.4-6.6 8.2-11.1 11-1.5.9-3.3.9-4.8.1s-2.4-2.3-2.5-4c0-1.7.9-3.3 2.4-4.1 2.3-1.4 4.4-3.2 6.1-5.3-1.8-2.1-3.8-3.8-6.1-5.3-2.3-1.3-3-4.2-1.7-6.4s4.3-2.9 6.5-1.6c4.5 2.8 8.2 6.5 11.1 10.9 1 1.4 1 3.3.1 4.7zM49.2 46H37.8c-2.1 0-3.8-1-3.8-3s1.7-3 3.8-3h11.4c2.1 0 3.8 1 3.8 3s-1.7 3-3.8 3z" fill="#066fd1"/>
            </svg>
          </a>
        </div>

        <div class="navbar-nav flex-row order-md-last">
          <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown">
              <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
              <div class="d-none d-xl-block ps-2">
                <div>Nama User</div>
                <div class="mt-1 small text-secondary">Role</div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" data-bs-theme="light">
              <a href="#" class="dropdown-item">Profile</a>
              <a href="#" class="dropdown-item">Settings</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">Sign out</a>
            </div>
          </div>
        </div>

        <div class="collapse navbar-collapse" id="navbar-menu">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="#">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M5 12l-2 0l9 -9l9 9l-2 0"/><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"/><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"/></svg>
                </span>
                <span class="nav-link-title">Dashboard</span>
              </a>
            </li>
            <!-- tambah menu lain di sini -->
          </ul>
        </div>
      </div>
    </header>
    <!-- ===== END NAVBAR ===== -->

    <!-- ===== PAGE WRAPPER ===== -->
    <div class="page-wrapper">

      <!-- PAGE HEADER -->
      <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">JUDUL HALAMAN</h2>
              <div class="text-secondary mt-1">Deskripsi singkat</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
              <button class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                Tambah Baru
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- END PAGE HEADER -->

      <!-- PAGE BODY -->
      <div class="page-body">
        <div class="container-xl">

          <!-- KONTEN UTAMA DI SINI -->

        </div>
      </div>
      <!-- END PAGE BODY -->

      <!-- FOOTER -->
      <footer class="footer footer-transparent d-print-none">
        <div class="container-xl">
          <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
              <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item">
                  <a href="#" class="link-secondary">Docs</a>
                </li>
              </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
              <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item">
                  Copyright &copy; 2026 — Nama Aplikasi
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
      <!-- END FOOTER -->

    </div>
    <!-- ===== END PAGE WRAPPER ===== -->

  </div>

  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js" defer></script>
</body>
</html>
```

---

## Komponen Siap Pakai

### Card Dasar

```html
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Judul</h3>
    <div class="card-options">
      <a href="#" class="btn btn-sm btn-outline-secondary">Aksi</a>
    </div>
  </div>
  <div class="card-body">Konten</div>
  <div class="card-footer">
    <button class="btn btn-primary">Simpan</button>
  </div>
</div>
```

**Variasi card:** `.card-borderless` `.card-dashed` `.card-transparent` `.card-status-top` `.card-status-bottom`

---

### Stat Card (KPI / Ringkasan)

```html
<div class="row row-deck row-cards">
  <div class="col-sm-6 col-lg-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="subheader">Total Pengguna</div>
        </div>
        <div class="h1 mb-3">1,200</div>
        <div class="d-flex mb-2">
          <div>Bulan ini</div>
          <div class="ms-auto">
            <span class="text-green d-inline-flex align-items-center lh-1">
              +12%
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon ms-1"><path d="M3 17l6 -6l4 4l8 -10"/><path d="M14 7l7 0l0 7"/></svg>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
```

---

### Tabel Data

```html
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Daftar Data</h3>
    <div class="card-options">
      <div class="input-group">
        <input type="text" class="form-control form-control-sm" placeholder="Cari...">
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th class="w-1"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <div class="d-flex py-1 align-items-center">
              <span class="avatar me-2" style="background-image: url(./static/avatars/000m.jpg)"></span>
              <div class="flex-fill">
                <div class="font-weight-medium">Budi Santoso</div>
                <div class="text-secondary">budi@email.com</div>
              </div>
            </div>
          </td>
          <td><span class="badge bg-success-lt text-success">Aktif</span></td>
          <td class="text-secondary">19 Apr 2026</td>
          <td>
            <div class="dropdown">
              <a href="#" class="btn-action" data-bs-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="#">Edit</a>
                <a class="dropdown-item text-danger" href="#">Hapus</a>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="card-footer d-flex align-items-center">
    <p class="m-0 text-secondary">Menampilkan <strong>1-10</strong> dari <strong>100</strong></p>
    <ul class="pagination m-0 ms-auto">
      <li class="page-item disabled"><a class="page-link" href="#">prev</a></li>
      <li class="page-item active"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">next</a></li>
    </ul>
  </div>
</div>
```

---

### Form Input

```html
<div class="card">
  <div class="card-header"><h3 class="card-title">Form</h3></div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label required">Nama Lengkap</label>
          <input type="text" class="form-control" placeholder="Masukkan nama">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" placeholder="nama@email.com">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select class="form-select">
            <option value="">Pilih status...</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Non-Aktif</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Keterangan</label>
          <textarea class="form-control" rows="3" placeholder="Tulis keterangan..."></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer text-end">
    <button type="button" class="btn btn-ghost-secondary me-2">Batal</button>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>
</div>
```

---

### Modal

```html
<!-- Trigger -->
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-simple">
  Buka Modal
</button>

<!-- Modal -->
<div class="modal modal-blur fade" id="modal-simple" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Judul Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Field 1</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Field 2</label>
              <input type="text" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>
```

---

### Alert & Toast

```html
<!-- Alert statis -->
<div class="alert alert-success alert-dismissible" role="alert">
  <div class="d-flex">
    <div>
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon alert-icon"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path d="M12 7l0 5l3 3"/></svg>
    </div>
    <div>
      <h4 class="alert-title">Data berhasil disimpan!</h4>
      <div class="text-secondary">Perubahan telah tersimpan ke database.</div>
    </div>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
</div>

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast show" role="alert">
    <div class="toast-header">
      <span class="badge bg-success me-2">&nbsp;</span>
      <strong class="me-auto">Sukses</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
    </div>
    <div class="toast-body">Data berhasil disimpan.</div>
  </div>
</div>
```

---

### Sidebar (jika dibutuhkan)

```html
<!-- Tambahkan class "layout-boxed" di <body> jika mau sidebar -->
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark">
      <a href="#">App Name</a>
    </h1>
    <div class="collapse navbar-collapse" id="sidebar-menu">
      <ul class="navbar-nav pt-lg-3">
        <li class="nav-item">
          <a class="nav-link active" href="#">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M5 12l-2 0l9 -9l9 9l-2 0"/><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"/><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"/></svg>
            </span>
            <span class="nav-link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/></svg>
            </span>
            <span class="nav-link-title">Users</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</aside>
```

---

### Chart (ApexCharts)

```html
<!-- Tambahkan di <head> -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@5.10.4/dist/apexcharts.min.js"></script>

<!-- HTML -->
<div class="card">
  <div class="card-header"><h3 class="card-title">Statistik</h3></div>
  <div class="card-body">
    <div id="chart-statistik"></div>
  </div>
</div>

<!-- JS (sebelum </body>) -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  window.ApexCharts && (new ApexCharts(document.getElementById('chart-statistik'), {
    chart: {
      type: "line",
      fontFamily: 'inherit',
      height: 300,
      animations: { enabled: false },
      toolbar: { show: false },
    },
    series: [{
      name: "Penjualan",
      data: [10, 25, 18, 40, 32, 55, 48]
    }],
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul']
    },
    colors: ['#066fd1'],
    stroke: { width: 2, lineCap: "round", curve: "smooth" },
    grid: { strokeDashArray: 4 },
    tooltip: { theme: 'dark' },
  })).render();
});
</script>
```

---

## Warna & Badge

```html
<!-- Badge status -->
<span class="badge bg-success">Aktif</span>
<span class="badge bg-danger">Error</span>
<span class="badge bg-warning text-dark">Pending</span>
<span class="badge bg-info">Info</span>

<!-- Badge muted (lt = light) -->
<span class="badge bg-success-lt text-success">Aktif</span>
<span class="badge bg-danger-lt text-danger">Ditolak</span>

<!-- Warna tersedia -->
blue, azure, indigo, purple, pink, red, orange,
yellow, lime, green, teal, cyan
```

---

## Tombol & Icon

```html
<!-- Tombol utama -->
<button class="btn btn-primary">Simpan</button>
<button class="btn btn-danger">Hapus</button>
<button class="btn btn-ghost-secondary">Batal</button>
<button class="btn btn-outline-primary">Detail</button>

<!-- Tombol + icon -->
<button class="btn btn-primary">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
  Tambah
</button>

<!-- Icon saja -->
<button class="btn btn-sm btn-icon btn-ghost-secondary" title="Edit">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
</button>
```

---

## Icon SVG Referensi

Semua icon diambil dari https://tabler.io/icons (copy paste inline SVG):

```html
<!-- Format standar -->
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
  fill="none" stroke="currentColor" stroke-width="2"
  stroke-linecap="round" stroke-linejoin="round"
  class="icon icon-1">
  <!-- PATH dari tabler.io -->
</svg>

<!-- Class icon -->
.icon-1   → 16px
.icon-2   → 20px  (default tombol kecil)
(tanpa)   → 24px  (default)
```

---

## Aturan File Output

1. **Lokasi:** Selalu di `/Users/elabsid/Batukel-dev/tabler/html compores/`
2. **Aset gambar:** Gunakan `./static/avatars/` dan `./static/brands/` (sudah tersedia)
3. **CSS/JS:** Hanya via CDN, tidak ada path lokal `./dist/`
4. **Lisensi:** Komentar copyright MIT wajib ada di baris 2–9 setiap file
5. **Tidak ada demo.css / demo.js**

---

## Integrasi Spring Boot

Untuk Thymeleaf, tambahkan namespace dan ubah atribut:

```html
<html lang="en" xmlns:th="http://www.thymeleaf.org">

<!-- Link dinamis Thymeleaf -->
<a th:href="@{/dashboard}">Dashboard</a>
<img th:src="@{/static/avatars/000m.jpg}" alt="avatar"/>

<!-- Loop data dari controller -->
<tr th:each="user : ${users}">
  <td th:text="${user.name}">Nama</td>
  <td th:text="${user.email}">Email</td>
  <td>
    <span th:class="${user.active} ? 'badge bg-success' : 'badge bg-danger'"
          th:text="${user.active} ? 'Aktif' : 'Non-Aktif'">Status</span>
  </td>
</tr>

<!-- Fragment layout (jika pakai Thymeleaf fragments) -->
<html th:replace="~{layout/base :: html(~{::head}, ~{::body})}">
```
