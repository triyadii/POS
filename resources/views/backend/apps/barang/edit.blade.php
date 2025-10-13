<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />


<!--begin::Row-->
<div class="row mb-7">
    <!--begin::Col Kode Barang-->
    <div class="col-md-6 fv-row">
        <label class="required fw-semibold fs-6 mb-2">Kategori Item</label>
        <select id="Editkategori_id" name="kategori_id"
        class="form-select b-3 mb-lg-0" data-control="select2"
        data-placeholder="pilih kategori" data-dropdown-parent="#Modal_Edit_Data">
        @if (empty($data->kategori_id))
        @else
            <option value="{{ $kategoriSelected->id }}" selected>{{ $kategoriSelected->nama }}</option>
        @endif
    </select>
        <span class="text-danger error-text kategori_id_error_edit"></span>
    </div>
    <!--end::Col-->

    <!--begin::Col Nama Item-->
    <div class="col-md-6 fv-row">
        <label class="required fw-semibold fs-6 mb-2">Brand</label>
        <select id="Editbrand_id" name="brand_id"
        class="form-select b-3 mb-lg-0" data-control="select2"
        data-placeholder="pilih brand" data-dropdown-parent="#Modal_Edit_Data">
        @if (empty($data->brand_id))
        @else
            <option value="{{ $brandSelected->id }}" selected>{{ $brandSelected->nama }}</option>
        @endif
    </select>
        <span class="text-danger error-text brand_id_error_edit"></span>
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->


                            
                          

                            <!--begin::Row-->
<div class="row mb-7">
    <!--begin::Col Kode Barang-->
    <div class="col-md-6 fv-row">
        <label class="required fw-semibold fs-6 mb-2">Tipe/Jenis Brand</label>
        <select id="Edittipe_id" name="tipe_id"
        class="form-select b-3 mb-lg-0" data-control="select2"
        data-placeholder="pilih brand" data-dropdown-parent="#Modal_Edit_Data">
        @if (empty($data->tipe_id))
        @else
            <option value="{{ $tipeSelected->id }}" selected>{{ $tipeSelected->nama }}</option>
        @endif
    </select>
        <span class="text-danger error-text tipe_id_error_edit"></span>
    </div>
    <!--end::Col-->

    <!--begin::Col Nama Item-->
    <div class="col-md-6 fv-row">
        <label class="required fw-semibold fs-6 mb-2">Satuan</label>
        <select id="Editsatuan_id" name="satuan_id"
        class="form-select b-3 mb-lg-0" data-control="select2"
        data-placeholder="pilih brand" data-dropdown-parent="#Modal_Edit_Data">
        @if (empty($data->satuan_id))
        @else
            <option value="{{ $satuanSelected->id }}" selected>{{ $satuanSelected->nama }}</option>
        @endif
    </select>
        <span class="text-danger error-text satuan_id_error_edit"></span>
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row-->
<div class="row mb-7">
    <!--begin::Col Kode Barang-->
    <div class="col-md-6 fv-row">
        <label class="required fw-semibold fs-6 mb-2">Kode Barang</label>
        <input type="text" name="kode_barang" id="Editkode_barang"
            class="form-control mb-3 mb-lg-0" placeholder="Kode Barang" value="{{ $data->kode_barang }}" />
        <span class="text-danger error-text kode_barang_error_edit"></span>
    </div>
    <!--end::Col-->

    <!--begin::Col Nama Item-->
    <div class="col-md-6 fv-row">
        <label class="required fw-semibold fs-6 mb-2">Nama Item</label>
        <input type="text" name="nama" id="Editnama"
            class="form-control mb-3 mb-lg-0" placeholder="Nama Item" value="{{ $data->nama }}" />
        <span class="text-danger error-text nama_error_edit"></span>
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row-->
<div class="row mb-7">
    <!--begin::Col Kode Barang-->
    <div class="col-md-6 fv-row">
        <label class="required fw-semibold fs-6 mb-2">Harga Jual</label>
        <input type="text" name="harga_jual" id="Editharga_jual"
            class="form-control mb-3 mb-lg-0" placeholder="harga_jual" value="{{ $data->harga_jual }}" />
        <span class="text-danger error-text harga_jual_error_edit"></span>
    </div>
    <!--end::Col-->

    <!--begin::Col Nama Item-->
    <div class="col-md-6 fv-row">
        <label class="required fw-semibold fs-6 mb-2">Harga Beli</label>
        <input type="text" name="harga_beli" id="Editharga_beli"
            class="form-control mb-3 mb-lg-0" placeholder="harga beli" value="{{ $data->harga_beli }}" />
        <span class="text-danger error-text harga_beli_error_edit"></span>
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->


<script>
    $(document).ready(function() {

        $('#Editkategori_id').select2({
          
          ajax: {
              url: "{{ route('kategori.select') }}",
              dataType: 'json',
              delay: 250,
              processResults: function(data) {
                  return {
                      results: $.map(data, function(item) {
                          return {
                              text: item.nama,
                              id: item.id
                          }
                      })
                  };
              }
          }
      });


        $('#Editbrand_id').select2({
          
            ajax: {
                url: "{{ route('brand.select') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nama,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });


        $('#Edittipe_id').select2({
          
          ajax: {
              url: "{{ route('tipe.select') }}",
              dataType: 'json',
              delay: 250,
              processResults: function(data) {
                  return {
                      results: $.map(data, function(item) {
                          return {
                              text: item.nama,
                              id: item.id
                          }
                      })
                  };
              }
          }
      });


      $('#Editsatuan_id').select2({
          
          ajax: {
              url: "{{ route('satuan.select') }}",
              dataType: 'json',
              delay: 250,
              processResults: function(data) {
                  return {
                      results: $.map(data, function(item) {
                          return {
                              text: item.nama,
                              id: item.id
                          }
                      })
                  };
              }
          }
      });



    });
</script>