{{-- Ini adalah tabel yang akan muncul saat tombol + diklik --}}
<table class="table table-row-dashed table-sm gs-0 gy-2">
    <thead>
        <tr class="fw-bold fs-7 text-muted">
            <th>Nama Barang</th>
            <th class="text-end">Qty</th>
            <th class="text-end">Harga Jual</th>
            <th class="text-end">Harga Beli</th>
            <th class="text-end">Sub Total</th>
            <th class="text-end">Profit</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($details as $item)
            @php
                $profit = $item->subtotal - $item->harga_beli * $item->qty;
            @endphp
            <tr>
                <td>{{ $item->barang->nama ?? 'N/A' }}</td>
                <td class="text-end">{{ $item->qty }}</td>
                <td class="text-end">{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                <td class="text-end">{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                <td class="text-end">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                <td class="text-end">{{ number_format($profit, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">...Data detail tidak ditemukan...</td>
            </tr>
        @endforelse
    </tbody>
</table>
