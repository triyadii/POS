<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />

<div class="row">
    <div class="col-md-4">
        <div class="fv-row mb-7">
            <label class="required fw-semibold fs-6 mb-2">Tanggal</label>
            <input type="text" name="tanggal" id="edit_tanggal" 
                   class="form-control form-control-sm flatpickr" 
                   value="{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}">
            <span class="text-danger error-text tanggal_error_edit"></span>
        </div>
    </div>

    <div class="col-md-8">
        <div class="fv-row mb-7">
            <label class="fw-semibold fs-6 mb-2">Catatan</label>
            <input type="text" name="catatan" id="edit_catatan" 
                   class="form-control form-control-sm" 
                   value="{{ $data->catatan }}">
        </div>
    </div>
</div>

<hr class="my-4">

<div id="edit_repeater_pengeluaran">
    <div data-repeater-list="detail_pengeluaran">
        @foreach($data->details as $detail)
            <div data-repeater-item class="row mb-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Nama Item</label>
                    <input type="text" name="nama" class="form-control form-control-sm"
                           value="{{ $detail->nama }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_pengeluaran_id" class="form-select form-select-sm kategori_pengeluaran">
                        @if($detail->kategori)
                            <option value="{{ $detail->kategori_pengeluaran_id }}" selected>
                                {{ $detail->kategori->nama }}
                            </option>
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah</label>
                    <input type="text" name="jumlah" class="form-control form-control-sm text-end jumlah"
                           value="Rp {{ number_format($detail->jumlah ?? 0, 0, ',', '.') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control form-control-sm"
                           value="{{ $detail->keterangan }}">
                </div>
                <div class="col-md-1 text-center">
                    <a href="javascript:;" data-repeater-delete>
                        <i class="ki-outline ki-trash fs-2 text-danger mt-3"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="form-group mt-3">
        <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
            <i class="ki-duotone ki-plus fs-4"></i> Tambah Item
        </a>
    </div>
</div>

{{-- <hr class="my-4">
<div class="text-end">
    <button type="submit" id="btnUpdatePengeluaran" class="btn btn-primary btn-sm">
        <i class="ki-outline ki-save fs-4 me-1"></i> Simpan Perubahan
    </button>
</div> --}}

<script>
$(function(){
    // Init Flatpickr
    flatpickr('.flatpickr', {dateFormat: 'd-m-Y'});

    // Init Repeater
    $('#edit_repeater_pengeluaran').repeater({
        initEmpty: false,
        show: function() {
            $(this).slideDown();
            initSelect2($(this).find('.kategori_pengeluaran'));
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });

    // Format rupiah
    $(document).on('input', '.jumlah', function() {
        this.value = formatRupiah(this.value);
    });

    // Inisialisasi Select2
    function initSelect2(element) {
        element.select2({
            placeholder: 'Pilih kategori',
            ajax: {
                url: "{{ route('kategori-pengeluaran.select') }}",
                dataType: 'json',
                delay: 250,
                processResults: data => ({
                    results: $.map(data, item => ({
                        id: item.id,
                        text: item.nama
                    }))
                })
            }
        });
    }

    // Format rupiah helper
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            let separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        return "Rp " + rupiah;
    }
});
</script>

