<h2>Data Pembayaran</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>User</th>
        <th>Jenis</th>
        <th>Bukti</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($payments as $payment)
    <tr>
        <td>{{ $payment->user_id }}</td>

        <td>
            @if($payment->type == 'buku')
                Buku Fisik / Ebook
            @else
                Paket Penerbitan
            @endif
        </td>

        <td>
            <img src="{{ asset('storage/' . $payment->proof) }}" width="100">
        </td>

        <td>{{ $payment->status }}</td>

        <td>
            @if($payment->status == 'pending')
                <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST">
                    @csrf
                    <button type="submit">Approve</button>
                </form>

                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                    @csrf
                    <button type="submit">Reject</button>
                </form>
            @else
                Selesai
            @endif
        </td>
    </tr>
    @endforeach
</table>