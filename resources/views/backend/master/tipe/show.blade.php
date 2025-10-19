<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />




                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nama Brand</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="brand_id" id="Editbrand_id"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Brand" value="{{$data->brand->nama}}" readonly/>
                                <span class="text-danger error-text brand_id_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Tipe/Jenis Brand</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="nama" id="Editnama"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="nama tipe" value="{{$data->nama}}" readonly/>
                                <span class="text-danger error-text nama_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->






