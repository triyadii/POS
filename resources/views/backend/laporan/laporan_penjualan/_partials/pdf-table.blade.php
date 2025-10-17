<table class="main-table">
    <thead>
        <tr>
            <th style="width: 15%;">Tanggal</th>
            <th style="width: 15%;">No. Transaksi</th>
            <th style="width: 45%;">Detail Barang</th>
            <th style="width: 15%;">Jenis Pembayaran</th>
            <th style="width: 15%;" class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualan as $trx)
            <tr>
                <td>{{ $trx->tanggal_penjualan->format('d-m-Y') }}</td>
                <td>{{ $trx->kode_transaksi }}</td>

                <td>
                    <table class="detail-table">
                        @foreach ($trx->detail as $item)
                            <tr class="detail-item">
                                <td>
                                    {{ $item->barang->nama ?? 'N/A' }} ({{ $item->barang->tipe->nama ?? '-' }}) <br>
                                    {{ $item->qty }} x Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                    {{-- Jika ada potongan, tampilkan di sini --}}
                                </td>
                                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td> {{-- DATA BARU --}}
                    @if ($trx->pembayaran)
                        <span style="font-weight: bold;">{{ $trx->pembayaran->nama }}</span><br>
                        <small>{{ $trx->pembayaran->no_rekening }}</small>
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="4" class="text-right"><strong>Total Keseluruhan</strong></td>
            <td class="text-right" style="text-align: right;"><strong>Rp
                    {{ number_format($penjualan->sum('total_harga'), 0, ',', '.') }}</strong>
            </td>
        </tr>
        <tr class="total-row">
            <td colspan="5" style="font-style: italic; text-align: right;">
                ({{ $totalPenjualanTerbilang }})
            </td>
        </tr>

    </tfoot>
</table>
