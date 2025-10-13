<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nama Supplier</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="nama" id="Editnama"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Supplier" value="{{$data->nama}}" readonly/>
                                <span class="text-danger error-text nama_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Kontak</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="no_telp" id="Editno_telp"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="kontak supplier" value="{{$data->no_telp}}" readonly/>
                                <span class="text-danger error-text no_telp_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                          

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Alamat</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="alamat" id="Editalamat"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="alamat supplier" value="{{$data->alamat}}" readonly/>
                                <span class="text-danger error-text alamat_error_edit"></span>
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
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="keterangan supplier" value="{{$data->keterangan}}" readonly/>
                                <span class="text-danger error-text keterangan_error_edit"></span>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->



