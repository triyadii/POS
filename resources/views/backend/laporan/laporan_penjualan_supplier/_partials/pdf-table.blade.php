<table class="main-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Supplier Terakhir</th>
            <th class="text-right">Total Terjual</th>
            <th class="text-right">Total Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($dataBarang as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->supplier_terakhir ?? '-' }}</td>
                <td class="text-right">{{ $item->total_qty_terjual }} Pcs</td>
                <td class="text-right">Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="4"><strong>Total</strong></td>
            <td class="text-right"><strong>{{ number_format($totalProdukTerjual, 0, ',', '.') }} Pcs</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
        </tr>
    </tfoot>
</table>
