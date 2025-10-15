<table class="main-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Supplier</th>
            <th class="text-right">Jumlah Barang Diterima</th>
            <th class="text-right">Total Pembelian</th>
        </tr>
    </thead>
    <tbody>
        {{-- Ganti variabel $dataBarang menjadi $dataSupplier --}}
        @forelse ($dataSupplier as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama }}</td>
                {{-- Ganti properti data --}}
                <td class="text-right">{{ number_format($item->total_qty_masuk, 0, ',', '.') }} Pcs</td>
                <td class="text-right">Rp {{ number_format($item->total_harga_beli, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="2"><strong>Total</strong></td>
            {{-- Ganti variabel total --}}
            <td class="text-right"><strong>{{ number_format($totalBarangDiterima, 0, ',', '.') }} Pcs</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($totalPembelian, 0, ',', '.') }}</strong></td>
        </tr>
    </tfoot>
</table>
