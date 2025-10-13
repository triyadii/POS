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
