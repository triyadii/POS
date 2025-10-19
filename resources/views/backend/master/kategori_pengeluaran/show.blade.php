<!---->
<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nama Kategori Pengeluaran</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="nama" id="Editnama"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Brand" value="{{$data->nama}}" readonly/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Deskripsi</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="keterangan" id="Editketerangan"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="keterangan Brand" value="{{$data->keterangan}}" readonly/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->



