<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nama Satuan</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="nama" id="Editnama"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Satuan" value="{{$data->nama}}" readonly/>
                                <span class="text-danger error-text nama_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Singkatan</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="singkatan" id="Editsingkatan"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="singkatan satuan" value="{{$data->singkatan}}" readonly/>
                                <span class="text-danger error-text singkatan_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->



