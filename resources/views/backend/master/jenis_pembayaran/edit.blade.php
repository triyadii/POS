<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nama Pembayaran</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="nama" id="Editnama"
                                    class="form-control mb-3 mb-lg-0" placeholder="Nama Pembayaran" value="{{$data->nama}}"/>
                                <span class="text-danger error-text nama_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                          

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">No. Rekening</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="no_rekening" id="Editno_rekening"
                                    class="form-control mb-3 mb-lg-0" placeholder="No. Rekening" value="{{$data->no_rekening}}"/>
                                <span class="text-danger error-text no_rekening_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nama Pemilik</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="nama_pemilik" id="Editnama_pemilik"
                                    class="form-control mb-3 mb-lg-0" placeholder="Nama Pemilik" value="{{$data->nama_pemilik}}"/>
                                <span class="text-danger error-text nama_pemilik_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->



