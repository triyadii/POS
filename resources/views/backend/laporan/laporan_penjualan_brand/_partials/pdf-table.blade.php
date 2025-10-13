<table class="main-table">
    <thead>
        <tr>
            <th style="width: 15%;">No. Transaksi</th>
            <th style="width: 15%;">Tanggal</th>
            <th style="width: 55%;">Detail Barang</th>
            <th style="width: 15%;" class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualan as $trx)
            @php
                // Hitung ulang total per baris berdasarkan brand yang difilter
                $rowTotal = 0;
                if ($brandId && $brandId != 'all') {
                    $rowTotal = $trx->detail
                        ->filter(fn($item) => optional($item->barang)->brand_id == $brandId)
                        ->sum('subtotal');
                } else {
                    $rowTotal = $trx->total_harga;
                }
            @endphp
            <tr>
                <td>
                    {{ $trx->kode_transaksi }} <br>
                    <small style="color: #666;">Kasir: {{ $trx->user->name ?? 'N/A' }}</small>
                </td>
                <td>{{ $trx->tanggal_penjualan->translatedFormat('d M Y, H:i') }}</td>
                <td>
                    <table class="detail-table">
                        @foreach ($trx->detail as $item)
                            {{-- Tampilkan hanya item yang cocok dengan filter brand --}}
                            @if (!$brandId || $brandId == 'all' || optional($item->barang)->brand_id == $brandId)
                                <tr class="detail-item">
                                    <td>
                                        <strong>{{ $item->barang->nama ?? 'N/A' }}</strong> <br>
                                        <small style="color: #555;">
                                            Brand: {{ optional($item->barang->brand)->nama ?? '-' }} | Tipe:
                                            {{ optional($item->barang->tipe)->nama ?? '-' }}
                                        </small> <br>
                                        <span>
                                            {{ $item->qty }} x Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </td>
                <td class="text-right">Rp {{ number_format($rowTotal, 0, ',', '.') }}</td>
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
            <td class="text-right"><strong>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></td>
        </tr>
    </tfoot>
</table>
