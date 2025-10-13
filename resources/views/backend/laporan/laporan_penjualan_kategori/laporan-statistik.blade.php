{{-- Menggunakan style dan statistik dari Laporan Penjualan Global --}}
@include('backend.laporan.laporan_penjualan_kategori._partials.pdf-style')

<body>
    @include('backend.laporan.laporan_penjualan_kategori._partials.pdf-header')
    <main>
        @include('backend.laporan.laporan_penjualan_kategori._partials.pdf-statistik')
    </main>
</body>

</html>
