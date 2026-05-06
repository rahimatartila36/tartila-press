<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- PROFIL --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- KERANJANG --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Keranjang Saya
                </h3>

                @if(isset($carts) && $carts->count() > 0)

                    <div class="space-y-4">
                        @foreach($carts as $item)
                            <div class="border rounded-lg p-4 flex justify-between items-center">

                                <div>
                                    <h4 class="font-semibold">
                                        {{ $item->book->title }}
                                    </h4>

                                    <p class="text-sm text-gray-600">
                                        Qty: {{ $item->qty }}
                                    </p>

                                    <p class="text-sm font-semibold text-green-700">
                                        Rp {{ number_format($item->book->harga * $item->qty, 0, ',', '.') }}
                                    </p>
                                </div>

                                <a href="/cart/delete/{{ $item->id }}"
                                   class="bg-red-600 text-white px-3 py-2 rounded text-sm">
                                    Hapus
                                </a>

                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 flex gap-3">
                        <a href="/cart"
                           class="bg-blue-600 text-white px-4 py-2 rounded">
                            Lihat Keranjang
                        </a>

                        <a href="/checkout"
                           class="bg-green-600 text-white px-4 py-2 rounded">
                            Checkout
                        </a>
                    </div>

                @else

                    <p class="text-gray-600">
                        Keranjang masih kosong.
                    </p>

                    <a href="/#books"
                       class="inline-block mt-3 bg-blue-600 text-white px-4 py-2 rounded">
                        Lihat Katalog Buku
                    </a>

                @endif
            </div>

            {{-- PROGRES PEMBELIAN --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">
                    Progres Pembelian Buku
                </h3>

                @if(isset($orders) && $orders->count() > 0)

                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="border rounded-lg p-4">

                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-semibold">
                                            Order #{{ $order->id }}
                                        </h4>

                                        <p class="text-sm text-gray-600">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>

                                    <span class="bg-blue-900 text-white px-3 py-1 rounded text-sm">
                                        {{ str_replace('_', ' ', $order->status) }}
                                    </span>
                                </div>

                                <div class="border-t border-b py-3 my-3 space-y-2">
                                    @foreach($order->items as $item)
                                        <div class="flex justify-between text-sm">
                                            <span>
                                                {{ $item->book_title }} x {{ $item->qty }}
                                            </span>

                                            <span>
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex justify-between items-center">
                                    <strong>
                                        Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </strong>

                                    <a href="/orders/{{ $order->id }}"
                                       class="bg-gray-800 text-white px-3 py-2 rounded text-sm">
                                        Detail Pesanan
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>

                @else

                    <p class="text-gray-600">
                        Belum ada pembelian buku.
                    </p>

                @endif
            </div>

            {{-- HAPUS AKUN --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>