<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        .stats-box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            overflow: auto;
        }

        .stat-item {
            float: left;
            width: 33.33%;
            text-align: center;
        }

        .stat-item h3 {
            margin: 0 0 5px 0;
            font-size: 18px;
        }

        .stat-item p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }

        .transaction-block {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            page-break-inside: avoid;
        }

        .transaction-header {
            background-color: #f2f2f2;
            padding: 8px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .transaction-header span {
            margin-right: 15px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table th,
        .detail-table td {
            border-bottom: 1px solid #eee;
            padding: 8px;
            text-align: left;
        }

        .detail-table th {
            background-color: #fafafa;
            font-size: 10px;
            text-transform: uppercase;
        }

        .text-right {
            text-align: right !important;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p><strong>Nama Usaha Anda</strong></p>
        <p>Periode: {{ $start->translatedFormat('d F Y') }} - {{ $end->translatedFormat('d F Y') }}</p>
    </div>

    <div class="stats-box">
        <div class="stat-item">
            <h3>{{ number_format($totalTransaksi, 0, ',', '.') }}</h3>
            <p>Total Transaksi</p>
        </div>
        <div class="stat-item">
            <h3>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
            <p>Total Penjualan</p>
        </div>
        <div class="stat-item">
            <h3>{{ number_format($jumlahItemTerjual, 0, ',', '.') }}</h3>
            <p>Item Terjual</p>
        </div>
    </div>

    @forelse ($penjualan as $trx)
        <div class="transaction-block">
            <div class="transaction-header">
                <span>{{ $trx->kode_transaksi }}</span> |
                <span>{{ $trx->tanggal_penjualan->translatedFormat('d M Y, H:i') }}</span> |
                <span>Kasir: {{ $trx->user->name ?? 'N/A' }}</span> |
                <span>Customer: {{ $trx->customer_nama }}</span> |
                <span style="float: right;">Total: Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
            </div>
            <table class="detail-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Tipe</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Potongan</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trx->detail as $item)
                        <tr>
                            <td>{{ $item->barang->kode_barang ?? '' }}</td>
                            <td>{{ $item->barang->nama ?? 'Produk Dihapus' }}</td>
                            <td>{{ $item->barang->tipe->nama ?? '-' }}</td>
                            <td class="text-right">{{ $item->qty }}</td>
                            <td class="text-right">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="text-right">Rp 0</td>
                            <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p style="text-align: center;">Tidak ada data penjualan pada periode ini.</p>
    @endforelse

</body>

</html>
