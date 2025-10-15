<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />


<div class="row mb-7">
    <div class="col-md-6 fv-row">
        <!--begin::Label-->
        <label class="required fw-semibold fs-6 mb-2">Tanggal</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" name="tanggal_masuk" id="Edittanggal_masuk"
            class="form-control mb-3 mb-lg-0" placeholder="Tanggal" value="{{$data->tanggal_masuk}}"/>
        <span class="text-danger error-text tanggal_masuk_error_edit"></span>
        <!--end::Input-->
    </div>
    <!--end::Input group-->



    <div class="col-md-6 fv-row">
        <!--begin::Label-->
        <label class="required fw-semibold fs-6 mb-2">Supplier</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select id="Editsupplier_id" name="supplier_id"
        class="form-select b-3 mb-lg-0" data-control="select2"
        data-placeholder="pilih supplier" data-dropdown-parent="#Modal_Edit_Data">

        @if (empty($data->supplier_id))
        @else
            <option value="{{ $supplierSelected->id }}" selected>{{ $supplierSelected->nama }}</option>
        @endif
    </select>
        <span class="text-danger error-text supplier_id_error_edit"></span>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end::Input group-->



<div class="row mb-7 fv-row">
        <!--begin::Label-->
        <label for="Editcatatantextarea" fw-semibold fs-6 mb-2">Catatan</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control" name="catatan" id="Editcatatantextarea" rows="2">{{$data->catatan}}</textarea>
        <span class="text-danger error-text catatan_error_edit"></span>
        <!--end::Input-->
</div>
    <!--end::Input group-->
                          

                          



                            <script>
                                $(document).ready(function() {
                            
                                    //  select province:start
                                    $('#Editsupplier_id').select2({
                                      
                                        ajax: {
                                            url: "{{ route('supplier.select') }}",
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