<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nama Customer</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="nama" id="Editnama"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Customer" value="{{$data->nama}}" readonly/>
                                <span class="text-danger error-text nama_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">No. WHatsApp</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="no_wa" id="Editno_wa"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="no. wa Customer" value="{{$data->no_wa}}" readonly/>
                                <span class="text-danger error-text no_wa_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->



