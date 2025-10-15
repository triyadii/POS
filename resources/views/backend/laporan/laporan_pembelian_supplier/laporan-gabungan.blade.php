@include('backend.laporan.laporan_penjualan_supplier._partials.pdf-style')

<body>
    @include('backend.laporan.laporan_penjualan_supplier._partials.pdf-header')
    <main>
        @include('backend.laporan.laporan_penjualan_supplier._partials.pdf-statistik')
        <h3 class="section-title">Detail Barang Terjual</h3>
        @include('backend.laporan.laporan_penjualan_supplier._partials.pdf-table')
    </main>
</body>

</html>
