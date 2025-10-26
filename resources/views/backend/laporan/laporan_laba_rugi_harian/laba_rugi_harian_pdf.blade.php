<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi Harian</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 10px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #4A5568;
            color: #FFFFFF;
            font-weight: bold;
            text-transform: uppercase;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .total-row {
            font-weight: bold;
            background-color: #f1f5f9;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 50px;
            font-size: 9px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }

        .footer-left {
            float: left;
            width: 50%;
        }

        .footer-right {
            float: right;
            width: 50%;
            text-align: right;
            color: #888;
        }

        .page-break {
            page-break-after: always;
        }

        .summary-table {
            width: 60%;
            margin: 20px 0 30px 0;
        }

        .summary-table td {
            border: none;
            padding: 8px;
            font-size: 12px;
        }

        .summary-table .label {
            font-weight: bold;
            width: 50%;
        }

        .summary-table .value {
            text-align: right;
            font-weight: bold;
        }

        .summary-table .profit {
            color: #007bff;
        }

        .summary-table .loss {
            color: #dc3545;
        }
    </style>
</head>

<body>
    {{-- Nomor Halaman --}}
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
            $size = 8; $font = $fontMetrics->getFont("helvetica", "normal");
            $width = $fontMetrics->getTextWidth($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) - 20; $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>

    <div class="header">
        <h1>Laporan Laba Rugi Harian (Detail)</h1>
        <p><strong>DISKON BESAR 22</strong></p>
        <p>Periode: {{ $tanggal->translatedFormat('d F Y') }}</p>
    </div>

    <main>
        <h3>Ringkasan Keuangan</h3>
       <div class="row">
        <div class="col-xl-6">
            <table class="summary-table">
                <tr>
                    <td class="label">Total Penjualan Hari Ini(Kotor)</td>
                    <td class="value">Rp {{ number_format($total_penjualan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">Total Pembelian Barang Hari Ini</td>
                    <td class="value">Rp {{ number_format($total_pembelian, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">Total Pengeluaran Hari Ini(Biaya)</td>
                    <td class="value">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td class="label" style="font-size: 13px;">Laba / Rugi Kotor</td>
                    <td class="value {{ $laba_rugi >= 0 ? 'profit' : 'loss' }}" style="font-size: 13px;">
                        Rp {{ number_format($laba_rugi, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-xl-6">
            <table class="summary-table">
                <tr>
                    <td class="label" style="padding-left: 20px; font-style: italic;">Total Modal Pembelian Barang Berdasarkan Item Yang Dijual  (HPP)</td>
                    <td class="value" style="font-style: italic;">
                        - Rp {{ number_format($total_hpp_penjualan, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td class="label" style="padding-left: 20px; font-weight: bold;">Total Profit Kotor (Margin Berdasarkan Penjualan Dengan Modal)</td>
                    <td class="value" style="font-weight: bold;">
                        Rp {{ number_format($total_profit_kotor, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>
       </div>

        <hr style="border: 0; border-top: 1px dashed #ccc;">

        <h3>Detail Penjualan (Pendapatan)</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detail_penjualan as $item)
                    <tr>
                        <td>{{ $item->barang->nama ?? 'N/A' }}</td>
                        <td class="text-right">{{ $item->qty }}</td>
                        <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada penjualan</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="2" class="text-right"><strong>Total Penjualan</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($total_penjualan, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <h3>Detail Pembelian (Barang Masuk)</h3>
        <table>
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detail_pembelian as $item)
                    <tr>
                        <td>{{ $item->barangMasuk->kode_transaksi ?? '-' }}</td>
                        <td>{{ $item->barang->nama ?? 'N/A' }}</td>
                        <td class="text-right">{{ $item->qty }}</td>
                        <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada pembelian</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right"><strong>Total Pembelian</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($total_pembelian, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <h3>Detail Pengeluaran (Biaya)</h3>
        <table>
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th>Kategori</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detail_pengeluaran as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori->nama ?? 'N/A' }}</td>
                        <td class="text-right">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada pengeluaran</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="2" class="text-right"><strong>Total Pengeluaran</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>


        <h3>Komparasi Profit Item Terjual</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th class="text-right">Hrg. Beli</th>
                    <th class="text-right">Hrg. Jual</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Profit</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detail_penjualan as $item)
                    @php
                        $profit = $item->subtotal - $item->harga_beli * $item->qty;
                    @endphp
                    <tr>
                        <td>{{ $item->barang->nama ?? 'N/A' }}</td>
                        <td class="text-right">{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $item->qty }}</td>
                        <td class="text-right">{{ number_format($profit, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada penjualan</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="text-right"><strong>Total Profit Kotor (Margin)</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($total_profit_kotor, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>

        <footer class="footer">
            <div class="footer-left">
                Dicetak oleh: <strong>{{ $namaUser }}</strong> <br>
                Tanggal Cetak: {{ $tanggalCetak->translatedFormat('d F Y, H:i:s') }}
            </div>
            <div class="footer-right">
                Dokumen ini dibuat secara otomatis oleh sistem.
            </div>
        </footer>
    </main>


</body>

</html>
