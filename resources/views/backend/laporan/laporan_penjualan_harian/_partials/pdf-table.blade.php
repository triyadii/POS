<table class="main-table">
    <thead>
        <tr>
            {{-- Lebar kolom telah diatur ulang agar total 100% --}}
            <th style="width: 8%;">Tanggal</th>
            <th style="width: 12%;">No. Transaksi</th>
            <th style="width: 16%;">Nama Barang</th>
            <th style="width: 3%;" class="text-right">Qty</th>
            <th style="width: 7%;" class="text-right">Harga Jual</th>
            <th style="width: 7%;" class="text-right">Harga Beli</th>
            <th style="width: 8%;" class="text-right">Sub Total</th>
            <th style="width: 7%;" class="text-right">Profit</th>
            <th style="width: 4%;" class="text-right">Pot.</th>
            <th style="width: 4%;" class="text-right">Pajak</th>
            <th style="width: 4%;" class="text-right">Biaya Lain</th>
            <th style="width: 8%;" class="text-right">Total Akhir</th>
            <th style="width: 6%;" class="text-right">Tunai</th>
            <th style="width: 6%;" class="text-right">Kredit</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualanDetails as $detail)
            @php
                $profit = $detail->subtotal - $detail->harga_beli * $detail->qty;
                $isTunai = optional(optional($detail->penjualan)->pembayaran)->nama === 'Tunai';
                $total_akhir = $detail->subtotal; // Sesuai permintaan
            @endphp
            <tr>
                <td>{{ optional($detail->penjualan)->tanggal_penjualan ? $detail->penjualan->tanggal_penjualan->format('d-m-Y') : '-' }}
                </td>
                <td>{{ optional($detail->penjualan)->kode_transaksi ?? '-' }}</td>
                <td>{{ optional($detail->barang)->nama ?? 'N/A' }}</td>
                <td class="text-right">{{ $detail->qty }}</td>
                <td class="text-right">{{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($profit, 0, ',', '.') }}</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
                <td class="text-right">{{ number_format($total_akhir, 0, ',', '.') }}</td>
                <td class="text-right">{{ $isTunai ? number_format($detail->subtotal, 0, ',', '.') : '0' }}</td>
                <td class="text-right">{{ !$isTunai ? number_format($detail->subtotal, 0, ',', '.') : '0' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="14" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            {{-- Sesuaikan colspan agar pas --}}
            <td colspan="3" class="text-right"><strong>Total</strong></td>
            <td class="text-right"><strong>{{ number_format($jumlahProdukTerjual, 0, ',', '.') }}</strong></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"><strong>{{ number_format($total_subtotal, 0, ',', '.') }}</strong></td>
            <td class="text-right"><strong>{{ number_format($total_profit, 0, ',', '.') }}</strong></td>
            <td class="text-right"><strong>0</strong></td>
            <td class="text-right"><strong>0</strong></td>
            <td class="text-right"><strong>0</strong></td>
            <td class="text-right"><strong>{{ number_format($total_akhir, 0, ',', '.') }}</strong></td>
            <td class="text-right"><strong>{{ number_format($total_tunai, 0, ',', '.') }}</strong></td>
            <td class="text-right"><strong>{{ number_format($total_kredit, 0, ',', '.') }}</strong></td>
        </tr>
        <tr class="total-row">
            <td colspan="14" style="font-style: italic; text-align: right;">
                ({{ $totalTerbilang }})
            </td>
        </tr>
    </tfoot>
</table>

{{-- Summary Box (Tidak berubah) --}}
<div style="margin-top: 20px; width: 350px; margin-left: auto; font-size: 11px;">
    {{-- ... (Isi summary box tidak perlu diubah) ... --}}
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
            <td style="padding: 5px; text-align: right; font-weight: bold;">0</td>
        </tr>
        <tr>
            <td style="padding: 5px;">Pajak :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold;">0</td>
        </tr>
        <tr>
            <td style="padding: 5px;">Biaya Lain :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold;">0</td>
        </tr>
        <tr style="border-top: 1px dashed #999; border-bottom: 1px dashed #999;">
            <td style="padding: 8px; font-weight: bold; font-size: 12px;">Total Akhir :</td>
            <td style="padding: 8px; text-align: right; font-weight: bold; font-size: 13px;">
                {{ number_format($total_akhir, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 5px; color: #007bff;">Bayar Tunai :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold; color: #007bff;">
                {{ number_format($total_tunai, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 5px; color: #dc3545;">Bayar Kredit :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold; color: #dc3545;">
                {{ number_format($total_kredit, 0, ',', '.') }}</td>
        </tr>
        <tr style="border-top: 1px dashed #999;">
            <td style="padding: 5px; color: #28a745;">Total Profit :</td>
            <td style="padding: 5px; text-align: right; font-weight: bold; color: #28a745;">
                {{ number_format($total_profit, 0, ',', '.') }}</td>
        </tr>
    </table>
</div>
