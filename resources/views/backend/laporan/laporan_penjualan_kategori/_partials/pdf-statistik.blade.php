<div class="stats-container">
    <div class="stat-box">
        <div class="value">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</div>
        <div class="label">Total Penjualan</div>
    </div>
    <div class="stat-box">
        <div class="value">{{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        <div class="label">Total Kategori Terjual</div>
    </div>
    <div class="stat-box">
        <div class="value">{{ number_format($jumlahItemTerjual, 0, ',', '.') }}</div>
        <div class="label">Produk Terjual</div>
    </div>
</div>
