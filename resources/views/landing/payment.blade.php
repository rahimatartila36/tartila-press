<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Pembayaran</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card shadow">

<div class="card-header text-center">

<h4>Pembayaran Paket</h4>

</div>

<div class="card-body text-center">

@if($package->image)

<img
src="/packages/{{ $package->image }}"
width="150"
class="mb-3">

@endif

<h5>

{{ $package->name }}

</h5>

<p>

Kategori: {{ $package->category }}

</p>

@php

$finalPrice =
$package->price -
($package->price *
$package->discount / 100);

@endphp

<h3 class="text-success">

Rp {{ number_format($finalPrice) }}

</h3>

<hr>

<h5>Transfer ke Rekening:</h5>

<div class="alert alert-info">

<strong>
Bank BCA
</strong>

<br>

1234567890

<br>

a.n. PT Tartila Press

</div>

<form method="POST"
action="/payment"
enctype="multipart/form-data">

@csrf

<input type="hidden"
name="package_id"
value="{{ $package->id }}">

<div class="mb-3">

<label>Nama Anda</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>No WhatsApp</label>

<input
type="text"
name="phone"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Upload Bukti Transfer</label>

<input
type="file"
name="proof"
class="form-control"
required>

</div>

<button
class="btn btn-primary w-100">

Kirim Bukti Pembayaran

</button>

</form>

<a
href="https://wa.me/6281270348598?text=Saya sudah transfer paket {{ $package->name }}"
target="_blank"
class="btn btn-success w-100">

Konfirmasi Pembayaran via WhatsApp

</a>

</div>

</div>

</div>

</div>

</div>

</body>

</html>