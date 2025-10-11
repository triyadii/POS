<div class="p-3 bg-light">
    <table class="table table-sm table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Tipe</th>
                <th>Qty</th>
                <th class="text-end">Harga Jual</th>
                <th class="text-end">Potongan</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $item)
                <tr>
                    <td>{{ $item->barang->kode_barang ?? 'N/A' }}</td>
                    <td>{{ $item->barang->nama ?? 'N/A' }}</td>
                    <td>{{ $item->barang->tipe->nama ?? '-' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td class="text-end">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td class="text-end">Rp 0</td> {{-- Asumsi belum ada diskon per item --}}
                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
