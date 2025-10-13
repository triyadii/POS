{{-- Menggunakan style, statistik, dan tabel dari Laporan Penjualan Global --}}
@include('backend.laporan.laporan_penjualan_kategori._partials.pdf-style')

<body>
    @include('backend.laporan.laporan_penjualan_kategori._partials.pdf-header')
    <main>
        @include('backend.laporan.laporan_penjualan_kategori._partials.pdf-statistik')
        <h3 class="section-title">Detail Transaksi</h3>
        @include('backend.laporan.laporan_penjualan_kategori._partials.pdf-table')
    </main>
</body>

</html>
