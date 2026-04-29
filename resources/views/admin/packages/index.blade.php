@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header 
        d-flex justify-content-between 
        align-items-center">

            <h5 class="mb-0">
                Daftar Paket Penerbitan
            </h5>

            <a href="/admin/packages/create"
            class="btn btn-primary">

                + Tambah Paket

            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered 
                table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Harga Akhir</th>
                            <th width="150">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($packages as $package)

                        <tr>

                            <td>

                                @if($package->image)

                                <img 
                                src="/packages/{{ $package->image }}"
                                width="80"
                                class="rounded shadow-sm">

                                @endif

                            </td>

                            <td>
                                <strong>
                                {{ $package->name }}
                                </strong>
                            </td>

                            <td>

                                <span 
                                class="badge bg-info text-dark">

                                {{ $package->category }}

                                </span>

                            </td>

                            <td>

                                @if($package->discount > 0)

                                <span 
                                class="text-muted">

                                <s>
                                Rp {{ number_format($package->price) }}
                                </s>

                                </span>

                                @else

                                Rp {{ number_format($package->price) }}

                                @endif

                            </td>

                            <td>

                                @if($package->discount > 0)

                                <span 
                                class="badge bg-danger">

                                {{ $package->discount }}%

                                </span>

                                @else

                                -

                                @endif

                            </td>

                            <td>

                                @php

                                $finalPrice =
                                $package->price -
                                ($package->price *
                                $package->discount / 100);

                                @endphp

                                <strong 
                                class="text-success">

                                Rp {{ number_format($finalPrice) }}

                                </strong>

                            </td>

                            <td>

                                <a href="/admin/packages/{{ $package->id }}/edit"
                                class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <form
                                action="/admin/packages/{{ $package->id }}"
                                method="POST"
                                style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus paket ini?')">

                                    Hapus

                                </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection