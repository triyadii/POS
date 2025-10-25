
    <input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />

    <!-- HEADER -->
    <div class="border rounded p-5 mb-5 bg-light-subtle">
        <div class="row g-5 mb-4">
            {{-- <div class="col-md-4">
                <label class="form-label fw-semibold">Kode Transaksi</label>
                <input type="text" class="form-control form-control-sm"
                    name="kode_transaksi" value="{{ $data->kode_transaksi }}" readonly />
            </div> --}}

            @php
            // Ambil bagian kode setelah 'DB22-'
            $kodeValue = \Illuminate\Support\Str::after($data->kode_transaksi, 'DB22-');
        @endphp
        <div class="col-md-4">
            <label class="form-label fw-semibold">Kode Transaksi</label>
            <div class="input-group input-group-sm">
                <span class="input-group-text">DB22-</span>
                <input type="text" name="kode_transaksi" class="form-control"
                       value="{{ $kodeValue }}" placeholder="Input Kode...">
            </div>
            <span class="text-danger error-text kode_transaksi_error_edit"></span>
        </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Tanggal Penjualan</label>
                <input type="text" class="form-control form-control-sm"
                    value="{{ \Carbon\Carbon::parse($data->tanggal_penjualan)->translatedFormat('d F Y H:i') }}"
                    readonly />
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Jenis Pembayaran</label>
                <select name="jenis_pembayaran_id"
                    class="form-select form-select-sm edit-jenis-pembayaran-select"
                    data-placeholder="Pilih jenis pembayaran">
                    @if($data->jenis_pembayaran)
                        <option value="{{ $data->jenis_pembayaran_id }}" selected>
                            {{ $data->jenis_pembayaran->nama }}
                        </option>
                    @endif
                </select>
                <span class="text-danger error-text jenis_pembayaran_id_error_edit"></span>
            </div>
        </div>

        <div class="row g-5 mb-4">
            <div class="col-md-12">
                <label class="form-label fw-semibold">Catatan</label>
                <input type="text" name="catatan" class="form-control form-control-sm"
                    value="{{ $data->catatan }}" placeholder="Opsional">
            </div>
        </div>
    </div>

    <!-- DETAIL BARANG -->
    <div class="border rounded p-5 bg-light">
        <label class="fw-bold fs-5 mb-3 d-block">Daftar Barang</label>

        <div id="kt_repeater_edit_penjualan">
            <div data-repeater-list="barang_list">
                @foreach($data->detail as $detail)
<div data-repeater-item class="border rounded p-3 mb-3 bg-light-subtle">
    {{-- 🔹 penting: identifikasi baris lama --}}
    <input type="hidden" name="detail_id" value="{{ $detail->id }}">

    <div class="row g-3 align-items-center">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Barang</label>
            <select name="barang_id"
                class="form-select form-select-sm edit-barang-select" data-dropdown-parent="#Modal_Edit_Data" data-dropdown-parent="body"
                data-placeholder="Cari barang...">
                <option value="{{ $detail->barang_id }}" selected>
                    {{ $detail->barang->kode_barang }} — {{ $detail->barang->nama }} • Size: {{ $detail->barang->size }}
                </option>
            </select>
            <span class="text-danger error-text barang_list_{{ $loop->index }}_barang_id_error_edit"></span>
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold">Harga Jual</label>
            <input type="text" name="harga_jual"
                class="form-control form-control-sm harga-jual"
                value="{{ number_format($detail->harga_jual, 0, ',', '.') }}" readonly>
        </div>

        <div class="col-md-1">
            <label class="form-label fw-semibold">Qty</label>
            <input type="number" name="qty"
                class="form-control form-control-sm qty-input"
                value="{{ $detail->qty }}" min="1">
            <span class="text-danger error-text barang_list_{{ $loop->index }}_qty_error_edit"></span>
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold">Subtotal</label>
            <input type="text" name="subtotal"
                class="form-control form-control-sm subtotal-field"
                value="{{ number_format($detail->subtotal, 0, ',', '.') }}" readonly>
        </div>

        <div class="col-md-1 d-flex align-items-end">
            <button type="button" data-repeater-delete
                class="btn btn-icon btn-sm btn-light-danger">
                <i class="ki-outline ki-trash fs-2"></i>
            </button>
        </div>
    </div>
</div>
@endforeach

            </div>

            <button type="button" data-repeater-create
                class="btn btn-sm btn-light-primary mt-3">
                <i class="ki-outline ki-plus fs-2"></i> Tambah Barang
            </button>
        </div>
    </div>

    <!-- TOTAL -->
    <div class="border rounded p-5 mt-5 bg-light-subtle">
        <div class="row">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Total Harga</label>
                <input type="text" name="total_harga"
                    class="form-control form-control-sm edit-total-harga" readonly
                    value="{{ number_format($data->total_harga, 0, ',', '.') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Potongan</label>
                <input type="text" name="potongan"
                    class="form-control form-control-sm edit-potongan-input"
                    value="{{ number_format($data->potongan, 0, ',', '.') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Grand Total</label>
                <input type="text" name="grand_total"
                    class="form-control form-control-sm edit-grand-total" readonly
                    value="{{ number_format($data->grand_total, 0, ',', '.') }}">
            </div>
        </div>
    </div>
{{-- <script>
$(document).ready(function () {
    // helper
    const clean = s => parseInt(String(s).replace(/\D/g, '')) || 0;
    const format = n => n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // init repeater
    $('#kt_repeater_edit_penjualan').repeater({
        show: function () {
            $(this).slideDown();
            initSelect2BarangEdit();
            updateAllTotalsEdit();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
            setTimeout(updateAllTotalsEdit, 300);
        }
    });

    // init select2 barang (stok aware)
    function initSelect2BarangEdit() {
        $('.edit-barang-select').each(function () {
            if ($(this).data('select2')) $(this).select2('destroy');
            $(this).select2({
                dropdownParent: $('#Modal_Edit_Data'),
                placeholder: 'Cari barang (kode / nama)...',
                ajax: {
                    url: "{{ route('barang.select') }}",
                    dataType: 'json',
                    delay: 300,
                    data: params => ({ q: params.term }),
                    processResults: data => ({
                        results: data.map(item => ({
                            id: item.id,
                            text: `${item.kode_barang} — ${item.nama}`,
                            stok: item.stok,
                            harga_jual: item.harga_jual,
                            disabled: item.stok <= 0
                        }))
                    }),
                },
                templateResult: function (data) {
                    if (data.loading) return data.text;
                    const warna = data.stok <= 0 ? 'text-danger' : 'text-muted';
                    return $(`
                        <div class="d-flex flex-column py-1">
                            <span class="fw-bold text-gray-800 ${data.stok <= 0 ? 'opacity-50' : ''}">
                                ${data.text}
                            </span>
                            <small class="${warna}">
                                Stok: ${data.stok} • Harga: Rp ${format(data.harga_jual ?? 0)}
                            </small>
                        </div>
                    `);
                },
                templateSelection: d => d.text,
                width: '100%'
            });
        });
    }

    // init select2 jenis pembayaran
    function initSelectJenisPembayaranEdit() {
        $('.edit-jenis-pembayaran-select').each(function () {
            if ($(this).data('select2')) $(this).select2('destroy');
            $(this).select2({
                dropdownParent: $('#Modal_Edit_Data'),
                placeholder: 'Pilih jenis pembayaran...',
                ajax: {
                    url: "{{ route('jenis-pembayaran.select') }}",
                    dataType: 'json',
                    delay: 300,
                    data: params => ({ q: params.term }),
                    processResults: data => ({
                        results: data.map(i => ({ id: i.id, text: i.nama }))
                    }),
                },
                width: '100%'
            });
        });
    }

    initSelect2BarangEdit();
    initSelectJenisPembayaranEdit();

    // qty atau barang berubah
    $(document).on('select2:select input', '.edit-barang-select, .qty-input', function () {
        const row = $(this).closest('[data-repeater-item]');
        const harga = clean(row.find('.harga-jual').val());
        const qty = parseInt(row.find('.qty-input').val()) || 0;
        row.find('.subtotal-field').val(format(harga * qty));
        updateAllTotalsEdit();
    });

    // isi harga otomatis saat pilih barang
    $(document).on('select2:select', '.edit-barang-select', function (e) {
        const data = e.params.data;
        const row = $(this).closest('[data-repeater-item]');
        row.find('.harga-jual').val(format(data.harga_jual));
        row.find('.qty-input').val(1);
        row.find('.subtotal-field').val(format(data.harga_jual));
        updateAllTotalsEdit();
    });

    // potongan input
    $(document).on('input', '.edit-potongan-input', function () {
        const angka = clean($(this).val());
        $(this).val(format(angka));
        updateAllTotalsEdit();
    });

    // total & grand total
    function updateAllTotalsEdit() {
        let total = 0;
        $('.subtotal-field').each(function () {
            total += clean($(this).val());
        });
        $('.edit-total-harga').val(format(total));

        const potongan = clean($('.edit-potongan-input').val());
        const grand = Math.max(total - potongan, 0);
        $('.edit-grand-total').val(format(grand));


        // 🔹 Pastikan fungsi total langsung jalan saat modal dibuka
    $('#Modal_Edit_Data').on('shown.bs.modal', function () {
        setTimeout(() => {
            updateAllTotalsEdit();
        }, 200);
    });
    }
});

    </script> --}}