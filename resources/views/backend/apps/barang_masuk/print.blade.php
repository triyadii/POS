<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Barang Masuk - {{ $data->kode_transaksi }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .title { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="title">Laporan Barang Masuk</div>
    <p><strong>Kode Transaksi:</strong> {{ $data->kode_transaksi }}</p>
    <p><strong>Tanggal:</strong> {{ $data->tanggal_masuk }}</p>
    <p><strong>Supplier:</strong> {{ $data->supplier?->nama ?? '-' }}</p>

    <p><strong>Catatan:</strong> {{ $data->catatan ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga Beli</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data->detail as $i => $detail)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $detail->barang?->kode_barang }}</td>
                    <td>{{ $detail->barang?->nama }}</td>
                    <td class="text-right">{{ number_format($detail->qty, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total</th>
                <th class="text-right">Rp {{ number_format($data->total_harga ?? 0, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
