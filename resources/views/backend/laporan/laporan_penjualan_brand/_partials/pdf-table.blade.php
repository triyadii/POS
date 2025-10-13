<table class="main-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Brand</th>
            <th class="text-right">Total Item Terjual</th>
            <th class="text-right">Total Penjualan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($dataBrand as $brand)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $brand->nama }}</td>
                <td class="text-right">{{ number_format($brand->total_qty, 0, ',', '.') }} Pcs</td>
                <td class="text-right">Rp {{ number_format($brand->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data penjualan pada periode ini.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="2"><strong>Total Keseluruhan</strong></td>
            <td class="text-right"><strong>{{ number_format($totalProdukTerjual, 0, ',', '.') }} Pcs</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($totalPendapatanKeseluruhan, 0, ',', '.') }}</strong>
            </td>
        </tr>
    </tfoot>
</table>
