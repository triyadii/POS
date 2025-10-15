{{-- 1. Tampilkan kontainer statistik terlebih dahulu --}}
<div class="stats-container">
    <div class="stat-box">
        <div class="value">{{ number_format($totalTransaksi, 0, ',', '.') }}</div>
        <div class="label">Total Transaksi</div>
    </div>
    <div class="stat-box">
        <div class="value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        <div class="label">Total Penjualan</div>
    </div>
    <div class="stat-box">
        <div class="value">{{ number_format($jumlahItemTerjual, 0, ',', '.') }}</div>
        <div class="label">Item Terjual</div>
    </div>
</div>

{{-- 2. Tampilkan chart DI LUAR dan SETELAH kontainer statistik --}}
@if (isset($chartImage) && $chartImage)
    <div style="margin-top: 25px;">
        <h3 class="section-title">Grafik Tren Penjualan</h3>
        <img src="{{ $chartImage }}" style="width: 100%;">
    </div>
@endif

{{-- 3. Sisipkan page break jika diperlukan (biasanya untuk laporan gabungan) --}}
<div style="page-break-before: auto;"></div>
