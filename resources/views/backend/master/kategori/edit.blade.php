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

                          

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Keterangan</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="keterangan" id="Editketerangan"
                                    class="form-control mb-3 mb-lg-0" placeholder="keterangan brand" value="{{$data->keterangan}}"/>
                                <span class="text-danger error-text keterangan_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->



