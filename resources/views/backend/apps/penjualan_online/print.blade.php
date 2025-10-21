<!DOCTYPE html>
<html>

<head>
    <title>Print Struk</title>
    <style>
        @media print {
            @page {
                size: 58mm auto;
                margin: 0;
            }

            body {
                width: 58mm;
                margin: 0 auto;
                font-family: monospace;
                font-size: 13px;
                color: #000;
            }
        }

        body {
            width: 58mm;
            margin: 0 auto;
            font-family: monospace;
            font-size: 13px;
            color: #000;
        }

        hr {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        div,
        td,
        span {
            line-height: 1.3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 1px 0;
            vertical-align: top;
        }
    </style>
</head>

<body onload="window.print(); setTimeout(() => window.close(), 500);">

    <div style="font-family: monospace; font-size: 13px; width: 58mm; margin: 0 auto;">
        <div style="text-align:center;">
            <img src="{{ asset('storage/' . ($appSetting->logo_black ?? 'settings/logo_black_1761010416.svg')) }}"
                alt="Logo"
                style="display:block; margin:0 auto 8px auto; width:140px; height:auto; object-fit:contain;">
            <div style="font-size:13px; line-height:1.3;">
                Jl. KL. Yos Sudarso Pajak Sore Km 9.5, Mabar<br>
                Medan Deli, Kota Medan<br>
                Telp: 0812-1000-3014
            </div>
            <hr>
        </div>

        <div style="line-height:1.3; margin-bottom:5px;">
            <div>Tanggal : {{ $penjualan->tanggal_penjualan->format('d/m/Y H:i') }}</div>
            <div>Kode : {{ $penjualan->no_penjualan ?? $penjualan->kode_transaksi ?? '-' }}</div>
            <div>Kasir : {{ Auth::user()->name }}</div>
            <div>Pembayaran : {{ $metode ?? '-' }}</div>
            <div>Kategori : Online</div>
        </div>

        <hr>
        <table style="width:100%; border-collapse:collapse;">
            <tbody>
                @foreach($penjualan->detail as $item)
                    <tr>
                        <td>
                            {{ $item->barang->nama ?? '-' }}<br>
                            {{ $item->qty }} x {{ number_format($item->harga_jual, 0, ',', '.') }}
                        </td>
                        <td style="text-align:right;">
                            {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>

        <div style="display:flex; justify-content:space-between;">
            <span>Potongan</span>
            <span>Rp {{ number_format($penjualan->potongan ?? 0, 0, ',', '.') }}</span>
        </div>
        <div style="display:flex; justify-content:space-between;">
            <span>Total</span>
            <span>Rp {{ number_format($penjualan->total_harga ?? 0, 0, ',', '.') }}</span>
        </div>
        <div style="display:flex; justify-content:space-between;">
            <span>Bayar</span>
            <span>Rp {{ number_format($penjualan->total_bayar ?? 0, 0, ',', '.') }}</span>
        </div>
        <div style="display:flex; justify-content:space-between;">
            <span>Kembalian</span>
            <span>Rp {{ number_format(($penjualan->total_bayar ?? 0) - ($penjualan->total_harga ?? 0), 0, ',', '.') }}</span>
        </div>

        <hr>
        <div style="text-align:center; font-size:14px; margin-top:4px;">
            Terima Kasih 😊<br>
            --- Struk Non Pajak ---
        </div>
    </div>

</body>
</html>
