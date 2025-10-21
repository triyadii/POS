{{-- Menggunakan style dari pdf-style.blade.php --}}
<table class="main-table">
    <thead>
        <tr>
            {{-- =================================== --}}
            {{-- PENYESUAIAN LEBAR KOLOM (TOTAL 100%) --}}
            {{-- =================================== --}}
            <th style="width: 10%;">Tanggal</th>
            <th style="width: 15%;">No. Transaksi</th>
            <th style="width: 10%;">Kategori Penjualan</th>
            <th style="width: 30%;">Detail Barang</th> {{-- Dikecilkan --}}
            <th style="width: 15%;">Jenis Pembayaran</th>
            <th style="width: 10%;" class="text-right">Potongan</th> {{-- Kolom Baru --}}
            <th style="width: 10%;" class="text-right">Total</th> {{-- Dikecilkan --}}
        </tr>
    </thead>
    <tbody>
        @forelse ($penjualan as $trx)
            <tr>
                <td>{{ $trx->tanggal_penjualan->format('d-m-Y') }}</td>
                <td>{{ $trx->kode_transaksi }}</td>
                <td>{{ $trx->kategori_penjualan ?? '-' }}</td>

                {{-- Kolom Detail (Tidak berubah) --}}
                <td>
                    @foreach ($trx->detail as $item)
                        <strong>{{ optional($item->barang)->nama ?? '[-]' }}</strong>
                        @if (optional(optional($item->barang)->tipe)->nama)
                            ({{ optional($item->barang->tipe)->nama }})
                        @endif
                        <br>
                        <small>
                            {{ $item->qty }} x Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                            (Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }})
                        </small>
                        @if (!$loop->last)
                            <br><br>
                        @endif
                    @endforeach
                </td>

                {{-- Kolom Jenis Pembayaran (Tidak berubah) --}}
                <td>
                    @if ($trx->pembayaran)
                        <span style="font-weight: bold;">{{ $trx->pembayaran->nama }}</span><br>
                        <small>{{ $trx->pembayaran->no_rekening }}</small>
                    @else
                        -
                    @endif
                </td>

                {{-- =================================== --}}
                {{-- PENAMBAHAN TD POTONGAN --}}
                {{-- =================================== --}}
                <td class="text-right" style="color: #dc3545;">
                    Rp {{ number_format($trx->potongan ?? 0, 0, ',', '.') }}
                </td>

                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                {{-- Colspan ditambah jadi 7 --}}
                <td colspan="7" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
        @endforelse

        {{-- Baris Total --}}
        <tr class="total-row">
            {{-- Colspan ditambah jadi 6 --}}
            <td colspan="6" class="text-right"><strong>Total Keseluruhan</strong></td>
            <td class="text-right" style="text-align: right;"><strong>Rp
                    {{ number_format($penjualan->sum('total_harga'), 0, ',', '.') }}</strong>
            </td>
        </tr>
        <tr class="total-row">
            {{-- Colspan ditambah jadi 7 --}}
            <td colspan="7" style="font-style: italic; text-align: right;" class="terbilang">
                ({{ $totalPenjualanTerbilang }})
            </td>
        </tr>
    </tbody>
</table>
