<div class="header">
    <h1>Laporan Penjualan Harian</h1>
    <p><strong>DISKON BESAR 22</strong></p>
    <p>Periode: {{ $start->translatedFormat('d F Y') }} - {{ $end->translatedFormat('d F Y') }}</p>
    {{-- (BARU) Tampilkan filter yang aktif --}}
    <p style="font-size: 11px; margin-top: 2px;">Jenis Pembayaran: <strong>{{ $namaJenisPembayaran }}</strong></p>
    {{-- =================================== --}}
    {{-- PERUBAHAN: Tampilkan filter Tipe Penjualan --}}
    {{-- =================================== --}}
    <p style="font-size: 11px; margin-top: 2px;">Tipe Penjualan: <strong>{{ $namaKategoriPenjualan }}</strong></p>
</div>
