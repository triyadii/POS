<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Barang</title>
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
            color: #222;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        /* ====================================================== */
        /* PERUBAHAN 1: Memberi jarak agar tidak tertimpa footer  */
        /* ====================================================== */
        main {
            margin-bottom: 60px;
            /* Menambahkan margin bawah seukuran footer + spasi */
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
            padding-left: 10px;
            padding-right: 10px;
        }

        .footer-left {
            float: left;
            width: 50%;
            text-align: left;
        }

        .footer-right {
            float: right;
            width: 50%;
            text-align: right;
            color: #888;
        }

        /* ====================================================== */
        /* PERUBAHAN 2: Mempercantik Tabel Utama                  */
        /* ====================================================== */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ddd;
            /* Border lebih soft */
            padding: 8px;
            /* Padding lebih besar */
            text-align: left;
            vertical-align: top;
        }

        .main-table th {
            background-color: #4A5568;
            /* Header lebih gelap */
            color: #FFFFFF;
            /* Teks header putih */
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Zebra-striping untuk baris agar mudah dibaca */
        .main-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right !important;
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

    <div class="header">
        <h1>Laporan Stok Barang</h1>
        <p><strong>DISKON BESAR 22</strong></p>
        <p>Data per Tanggal: {{ $tanggalCetak->translatedFormat('d F Y') }}</p>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Size</th>
                <th class="text-left">Stok</th>
                <th>Brand</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barang as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->size ?? '-' }}</td>
                    <td class="text-left">{{ $item->stok }}</td>
                    <td>{{ $item->brand->nama ?? '-' }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data barang.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #f9f9f9;">
                <td colspan="6">Total Stok Keseluruhan</td>
                <td class="text-right">{{ $barang->sum('stok') }}</td>
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
</body>

</html>
