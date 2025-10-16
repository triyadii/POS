<div class="header">
    <h1>Laporan Pembelian By Supplier</h1>
    <p><strong>DISKON BESAR 22</strong></p>
    {{-- Tampilkan nama supplier yang difilter --}}
    <p>Supplier: <strong>{{ $namaSupplierFilter }}</strong></p>
    <p>Periode: {{ $start->translatedFormat('d F Y') }} - {{ $end->translatedFormat('d F Y') }}</p>
</div>
