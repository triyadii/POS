@include('backend.laporan.laporan_penjualan_kategori._partials.pdf-style')

<body>
    {{-- Skrip nomor halaman ini tetap di sini dan akan tetap berfungsi --}}
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

    @include('backend.laporan.laporan_penjualan_kategori._partials.pdf-header')

    <main>
        @include('backend.laporan.laporan_penjualan_kategori._partials.pdf-table')

        {{-- ======================================= --}}
        {{-- PERUBAHAN: Footer dipindah ke DALAM main --}}
        {{-- ======================================= --}}
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

    {{-- Footer sudah tidak di sini lagi --}}

</body>

</html>
