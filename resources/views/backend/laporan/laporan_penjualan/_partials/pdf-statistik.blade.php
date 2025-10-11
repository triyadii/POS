<div class="stats-container">
    <div class="stat-box">
        <div class="value">{{ number_format($totalTransaksi, 0, ',', '.') }}</div>
        <div class="label">Total Transaksi</div>
    </div>
    <div class="stat-box">
        <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        <div class="label">Total Penjualan</div>
    </div>
    <div class="stat-box">
        <div class="value">{{ number_format($jumlahProdukTerjual, 0, ',', '.') }}</div>
        <div class="label">Produk Terjual</div>
    </div>
</div>
