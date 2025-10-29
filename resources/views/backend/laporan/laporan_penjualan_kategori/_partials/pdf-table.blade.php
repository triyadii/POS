<table class="main-table">
    <thead>
        <tr>
            <th style="width: 15%;">Tanggal</th>
            <th style="width: 15%;">No. Transaksi</th>
            <th style="width: 15%;">Kategori Penjualan</th>
            <th style="width: 15%;">Jenis Pembayaran</th>
            <th style="width: 10%;">Catatan</th>
            <th style="width: 15%;" class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualan as $trx)
            <tr>
                <td>{{ $trx->tanggal_penjualan->translatedFormat('d M Y') }}</td>
                <td>
                    {{ $trx->kode_transaksi }} <br>
                    <small style="color: #666;">Kasir: {{ $trx->user->name ?? 'N/A' }}</small>
                </td>

                <td>{{ $trx->kategori_penjualan ?? '-' }}</td>
                
                <td> {{-- DATA BARU --}}
                    @if ($trx->jenis_pembayaran)
                        <span style="font-weight: bold;">{{ $trx->jenis_pembayaran->nama }}</span><br>
                        <small>{{ $trx->jenis_pembayaran->no_rekening }}</small>
                    @else
                        -
                    @endif
                </td>
                <td style="word-wrap: break-word; max-width: 10%;">{{ $trx->catatan ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="5" class="text-right"><strong>Total Keseluruhan</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($penjualan->sum('total_harga'), 0, ',', '.') }}</strong>
            </td>
        </tr>
        <tr class="total-row">
            <td colspan="6" style="font-style: italic; text-align: right;">
                ({{ $totalPenjualanTerbilang }})
            </td>
        </tr>
    </tfoot>
</table>
