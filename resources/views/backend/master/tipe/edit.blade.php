<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nama Brand</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="nama" id="Editnama"
                                    class="form-control mb-3 mb-lg-0" placeholder="Nama Brand" value="{{$data->nama}}"/>
                                <span class="text-danger error-text nama_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                          

                            <!-- Instansi -->
                            <div class="fv-row mb-7">
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




                            <script>
                                $(document).ready(function() {
                            
                                    //  select province:start
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
                            
                            
                            
                                });
                            </script>