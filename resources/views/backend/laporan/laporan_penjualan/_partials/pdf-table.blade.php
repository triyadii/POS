<table class="main-table">
    <thead>
        <tr>
            <th style="width: 15%;">Tanggal</th>
            <th style="width: 15%;">No. Transaksi</th>
            <th style="width: 45%;">Detail Barang</th>
            <th style="width: 15%;" class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualan as $trx)
            <tr>
                <td>{{ $trx->tanggal_penjualan->format('d-m-Y H:i') }}</td>
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
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="3" class="text-right"><strong>Total Keseluruhan</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($penjualan->sum('total_harga'), 0, ',', '.') }}</strong>
            </td>
        </tr>
    </tfoot>
</table>
