{{-- Menggunakan style dari pdf-style.blade.php --}}
<table class="main-table">
    <thead>
        <tr>
            {{-- =================================== --}}
            {{-- PENYESUAIAN LEBAR KOLOM (TOTAL 100%) --}}
            {{-- =================================== --}}
            <th style="width: 10%;">Tanggal</th>
            <th style="width: 15%;">No. Transaksi</th>
            <th style="width: 10%;">Kategori</th>
            <th style="width: 15%;">Kasir</th> {{-- KOLOM BARU --}}
            <th style="width: 15%;">Jenis Pembayaran</th>
            <th style="width: 10%;">Catatan</th>
            <th style="width: 10%;" class="text-right">Potongan</th>
            <th style="width: 15%;" class="text-right">Total</th> {{-- Lebar disesuaikan --}}
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualan as $trx)
            <tr>
                <td>{{ $trx->tanggal_penjualan->format('d-m-Y') }}</td>
                <td>{{ $trx->kode_transaksi }}</td>
                <td>{{ $trx->kategori_penjualan ?? '-' }}</td>
                
                {{-- =================================== --}}
                {{-- MENGGANTI DETAIL BARANG MENJADI KASIR --}}
                {{-- =================================== --}}
                <td>{{ $trx->user->name ?? '-' }}</td>

                {{-- Kolom Jenis Pembayaran (Tidak berubah) --}}
                <td>
                    @if ($trx->jenis_pembayaran)
                        <span style="font-weight: bold;">{{ $trx->jenis_pembayaran->nama }}</span><br>
                        <small>{{ $trx->jenis_pembayaran->no_rekening }}</small>
                    @else
                        -
                    @endif
                </td>

                <td style="word-wrap: break-word; max-width: 10%;">{{ $trx->catatan ?? '-' }}</td>
                
                <td class="text-right" style="color: #dc3545;">
                    Rp {{ number_format($trx->potongan ?? 0, 0, ',', '.') }}
                </td>

                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                {{-- Colspan tetap 8 --}}
                <td colspan="8" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
        @endforelse

        {{-- Baris Total --}}
        <tr class="total-row">
            {{-- Colspan disesuaikan menjadi 7 --}}
            <td colspan="7" class="text-right"><strong>Total Keseluruhan</strong></td>
            <td class="text-right" style="text-align: right;"><strong>Rp
                    {{ number_format($penjualan->sum('total_harga'), 0, ',', '.') }}</strong>
            </td>
        </tr>
        <tr class="total-row">
            {{-- Colspan 8 --}}
            <td colspan="8" style="font-style: italic; text-align: right;" class="terbilang">
                ({{ $totalPenjualanTerbilang }})
            </td>
        </tr>
    </tbody>
</table>