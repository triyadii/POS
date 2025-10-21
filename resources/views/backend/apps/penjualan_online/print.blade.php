<!DOCTYPE html>
<html>
<head>
    <title>Print Struk</title>
    <style>
        @media print {
            @page { size: 58mm auto; margin: 0; }
            body { width: 58mm; font-size: 11px; font-family: 'Courier New', monospace; }
        }
        body { margin: 10px; }
        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
    </style>
</head>

<body onload="window.print(); window.close();">

    <div class="center">
        <strong>DiskonBesar22</strong><br>
        <small>Tanggal: {{ $penjualan->tanggal_penjualan->format('d/m/Y H:i') }}</small>
    </div>
    <div class="line"></div>

    @foreach($penjualan->detail as $item)
        <div>
            {{ $item->barang->nama }}<br>
            {{ $item->qty }} x {{ number_format($item->harga, 0, ',', '.') }} =
            <span style="float:right;">{{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
    @endforeach

    <div class="line"></div>
    <div><strong>Total:</strong> <span style="float:right;">{{ number_format($penjualan->total_harga, 0, ',', '.') }}</span></div>
    <div><strong>Bayar:</strong> <span style="float:right;">{{ number_format($penjualan->total_bayar ?? 0, 0, ',', '.') }}</span></div>
    <div><strong>Kembali:</strong> <span style="float:right;">{{ number_format(($penjualan->total_bayar ?? 0) - $penjualan->total_harga, 0, ',', '.') }}</span></div>

    <div class="line"></div>
    <div class="center">Terima kasih!</div>

</body>
</html>
