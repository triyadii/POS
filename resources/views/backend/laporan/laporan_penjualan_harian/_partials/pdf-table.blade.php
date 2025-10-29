{{-- Hapus tabel utama, kita akan buat per transaksi --}}

@forelse ($penjualanTransactions as $trx)

    {{-- 1. HEADER TRANSAKSI --}}
    <table class="transaction-header">
        <tr>
            <td><strong>Tanggal:</strong> {{ $trx->tanggal_penjualan->format('d-m-Y') }}</td>
            <td><strong>No. Transaksi:</strong> {{ $trx->kode_transaksi }}</td>
            <td><strong>Pembayaran:</strong> {{ optional($trx->jenis_pembayaran)->nama ?? '-' }}</td>
            <td><strong>Kategori Penjualan:</strong> {{ ucwords($trx->kategori_penjualan) }}</td>
            <td style="max-width: 150px;"><strong>Catatan:</strong> {{ $trx->catatan ?? '-' }}</td>
            <td class="text-right"><strong>Sub Total:</strong>
                {{ number_format($trx->detail->sum('subtotal'), 0, ',', '.') }}</td>
            <td class="text-right"><strong>Potongan:</strong> {{ number_format($trx->potongan, 0, ',', '.') }}</td>
            <td class="text-right"><strong>Total Akhir:</strong> {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- 2. TABEL DETAIL ITEM (Untuk Komparasi) --}}
    <table class="item-table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th class="text-right" style="width: 10%;">Qty</th>
                <th class="text-right" style="width: 15%;">Harga Jual</th>
                <th class="text-right" style="width: 15%;">Harga Beli</th>
                <th class="text-right" style="width: 15%;">Sub Total</th>
                <th class="text-right" style="width: 15%;">Profit</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trx->detail as $detail)
                @php
                    $profit = $detail->subtotal - $detail->harga_beli * $detail->qty;
                @endphp
                <tr>
                    <td>{{ optional($detail->barang)->nama ?? 'N/A' }}</td>
                    <td class="text-right">{{ $detail->qty }}</td>
                    <td class="text-right">{{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($profit, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">...Data detail tidak ditemukan...</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@empty
    <table class="item-table">
        <tr>
            <td colspan="6" style="text-align: center;">Tidak ada data transaksi.</td>
        </tr>
    </table>
@endforelse


{{-- 3. SUMMARY BOX (Pindahkan dari tfoot ke sini) --}}
<div style="margin-top: 20px; width: 350px; margin-left: auto; font-size: 11px;">
    <table style="width: 100%;">
        <tr>
            <td style="padding: 5px;">Jumlah Item :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold;">
                {{ number_format($jumlahProdukTerjual, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 5px;">Sub Total :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold;">
                {{ number_format($total_subtotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 5px;">Potongan :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold;">
                {{ number_format($total_potongan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 5px;">Biaya Lain :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold;">
                {{ number_format($total_biaya_lain, 0, ',', '.') }}</td>
        </tr>
        <tr style="border-top: 1px dashed #999; border-bottom: 1px dashed #999;">
            <td style="padding: 8px; font-weight: bold; font-size: 12px;">Total Akhir :</td>
            <td style="padding: 8px; text-align: right; font-weight: bold; font-size: 13px;">
                {{ number_format($total_akhir, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 5px; color: #007bff;">Total Bayar Tunai :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold; color: #007bff;">
                {{ number_format($total_tunai, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 5px; color: #dc3545;">Total Bayar Kredit :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold; color: #dc3545;">
                {{ number_format($total_kredit, 0, ',', '.') }}</td>
        </tr>
        <tr style="border-top: 1px dashed #999;">
            <td style="padding: 5px; color: #dc3545;">Subtotal Harga Beli :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold; color: #dc3545;">
                {{ number_format($total_harga_beli, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td style="padding: 5px; color: #28a745;">Total Profit :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold; color: #28a745;">
                {{ number_format($total_profit, 0, ',', '.') }}</td>
        </tr>
    </table>
</div>
