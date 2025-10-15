{{-- Ganti seluruh isi file dengan ini --}}
<table class="main-table">
    <thead>
        <tr>
            <th style="width: 15%;">No. Transaksi</th>
            <th style="width: 15%;">Tanggal</th>
            <th style="width: 55%;">Detail Barang</th>
            <th class="text-right" style="width: 15%;">Total</th> {{-- Menggunakan class --}}
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualan as $trx)
            @php
                $rowTotal =
                    $brandId && $brandId != 'all'
                        ? $trx->detail
                            ->filter(fn($item) => optional($item->barang)->brand_id == $brandId)
                            ->sum('subtotal')
                        : $trx->total_harga;
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
                                    {{-- Menggunakan class --}}
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </td>
                <td class="text-right">Rp {{ number_format($rowTotal, 0, ',', '.') }}</td> {{-- Menggunakan class --}}
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-right"><strong>Total Keseluruhan</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td colspan="4" class="terbilang">
                ({{ $totalPenjualanTerbilang }})
            </td>
        </tr>
    </tfoot>
</table>
