<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            /* Ukuran font standar lebih kecil untuk laporan padat */
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            /* Jarak lebih besar setelah header */
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #222;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* Tetap collapse untuk garis yang rapi */
            margin-bottom: 20px;
        }

        /* Styling sel header dan data untuk tampilan ledger/buku besar */
        table th,
        table td {
            padding: 10px;
            /* Padding lebih lega */
            text-align: left;
            /* Hapus border individu, ganti dengan border bawah */
            border: none;
            border-bottom: 1px solid #e2e8f0;
            /* Garis horizontal abu-abu muda */
        }

        /* Header Tabel yang Profesional */
        table th {
            background-color: #4A5568;
            /* Abu-abu gelap */
            color: #FFFFFF;
            font-weight: bold;
            text-transform: uppercase;
            /* Huruf kapital untuk judul kolom */
            letter-spacing: 0.05em;
            /* Jarak antar huruf */
            border-top: 2px solid #374151;
            /* Garis tebal di atas header */
            border-bottom: 2px solid #374151;
            /* Garis tebal di bawah header */
        }

        /* Zebra-striping untuk baris agar mudah dibaca */
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .text-right {
            text-align: right !important;
        }

        /* Baris Total yang Menonjol */
        .total-row {
            font-weight: bold;
            background-color: #f1f5f9;
            /* Latar belakang sedikit berbeda */
            border-top: 2px solid #cbd5e1;
            /* Garis pemisah yang jelas */
        }

        .total-row td {
            font-size: 11px;
            /* Sedikit lebih besar untuk total */
        }

        /* Footer yang Fungsional */
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
            width: 48%;
            text-align: left;
        }

        .footer-right {
            float: right;
            width: 48%;
            text-align: right;
            color: #888;
        }
    </style>
</head>

<body>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
            $size = 8;
            $font = $fontMetrics->getFont("helvetica", "normal");
            $width = $fontMetrics->getTextWidth($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) - 20; // Posisi X (kanan)
            $y = $pdf->get_height() - 35;          // Posisi Y (bawah)
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
    <div class="container">
        <div class="header">
            <h1>Laporan Laba Rugi</h1>
            {{-- Ganti dengan nama usaha Anda --}}
            <p><strong>DISKON BESAR 22</strong></p>
            <p>Periode: {{ \Carbon\Carbon::parse($start)->format('d F Y') }} -
                {{ \Carbon\Carbon::parse($end)->format('d F Y') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th class="text-right">Pendapatan</th>
                    <th class="text-right">Pembelian Barang</th>
                    <th class="text-right">Biaya Operasional</th>
                    <th class="text-right">Laba Bersih</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPendapatan = 0;
                    $totalPembelian = 0;
                    $totalPengeluaran = 0;
                    $totalLaba = 0;
                @endphp
                @forelse ($periode as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}</td>
                        <td class="text-right">Rp {{ number_format($item['total_pendapatan'], 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item['pembelian_barang'], 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item['pengeluaran_operasional'], 0, ',', '.') }}
                        </td>
                        <td class="text-right">Rp {{ number_format($item['laba_bersih'], 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalPendapatan += $item['total_pendapatan'];
                        $totalPembelian += $item['pembelian_barang'];
                        $totalPengeluaran += $item['pengeluaran_operasional'];
                        $totalLaba += $item['laba_bersih'];
                    @endphp
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalPembelian, 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalLaba, 0, ',', '.') }}</strong></td>
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
    </div>
</body>

</html>
