<section id="paket" class="py-5 bg-light">

<div class="container">

<h2 class="text-center mb-5">
Paket Penerbitan
</h2>

<div class="row">

@foreach($packages as $package)

<div class="col-md-3 mb-4">

<div class="card h-100 shadow-sm">

@if($package->image)

<img
src="/packages/{{ $package->image }}"
class="card-img-top"
style="height:180px; object-fit:cover;">

@endif

<div class="card-body">

<h5 class="card-title">
{{ $package->name }}
</h5>

<p class="text-muted">
{{ $package->category }}
</p>

@php

$finalPrice =
$package->price -
($package->price *
$package->discount / 100);

@endphp

@if($package->discount > 0)

<p class="mb-1">

<s class="text-muted">

Rp {{ number_format($package->price) }}

</s>

</p>

@endif

<h5 class="text-success">

Rp {{ number_format($finalPrice) }}

</h5>

@if($package->discount > 0)

<span class="badge bg-danger">

Diskon {{ $package->discount }}%

</span>

@endif

</div>

<div class="card-footer bg-white">

<a
href="https://wa.me/6281270348598?text=Saya tertarik paket {{ $package->name }}"
target="_blank"
class="btn btn-success w-100 mb-2">

Tanya via WhatsApp

</a>

<a
href="/payment/package/{{ $package->id }}"
class="btn btn-primary w-100">

Bayar Sekarang

</a>

</div>

</div>

</div>

@endforeach

</div>

</div>

</section>