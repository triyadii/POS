{{-- Ganti seluruh isi file dengan ini --}}
<table class="main-table">
    <thead>
        <tr>
            <th style="width: 15%;">No. Transaksi</th>
            <th style="width: 15%;">Tanggal</th>
            <th style="width: 40%;">Detail Barang</th>
            <th style="width: 15%;">Jenis Pembayaran</th>
            <th class="text-right" style="width: 15%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualan as $trx)
            @php
                // Logika $rowTotal tidak perlu diubah
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
                <td>{{ $trx->tanggal_penjualan->translatedFormat('d M Y') }}</td>
                <td>
                    <table class="detail-table">
                        @foreach ($trx->detail as $item)
                            {{-- Filter item berdasarkan brandId (jika ada) --}}
                            @if (!$brandId || $brandId == 'all' || optional($item->barang)->brand_id == $brandId)
                                <tr class="detail-item">
                                    <td>
                                        {{-- ========================================================== --}}
                                        {{-- PERBAIKAN UTAMA ADA DI SINI --}}
                                        {{-- ========================================================== --}}
                                        <strong>{{ optional($item->barang)->nama ?? '[-]' }}</strong> <br>
                                        <small style="color: #555;">
                                            {{-- Gunakan optional() berlapis untuk keamanan ekstra --}}
                                            Brand: {{ optional(optional($item->barang)->brand)->nama ?? '-' }} | Tipe:
                                            {{ optional(optional($item->barang)->tipe)->nama ?? '-' }}
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
                <td> {{-- DATA BARU - Kode ini sudah benar --}}
                    @if ($trx->pembayaran)
                        <span style="font-weight: bold;">{{ $trx->pembayaran->nama }}</span><br>
                        <small>{{ $trx->pembayaran->no_rekening }}</small>
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format($rowTotal, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right"><strong>Total Keseluruhan</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td colspan="5" class="terbilang">
                ({{ $totalPenjualanTerbilang }})
            </td>
        </tr>
    </tfoot>
</table>
