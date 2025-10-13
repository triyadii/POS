@include('backend.laporan.laporan_penjualan._partials.pdf-style')

<body>
    @include('backend.laporan.laporan_penjualan._partials.pdf-header')
    <main>
        @include('backend.laporan.laporan_penjualan._partials.pdf-statistik')
        <h3 class="section-title">Detail Transaksi</h3>
        @include('backend.laporan.laporan_penjualan._partials.pdf-table')
    </main>
</body>

</html>
