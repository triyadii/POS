<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $data->id }}" />
<!--begin::Input group-->
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fs-6 fw-semibold mb-2">Nama Perubahan</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="nama" id="Editnama" value="{{ $data->nama }}"
        class="form-control border border-1 border-dark rounded mb-3 mb-lg-0" placeholder="Nama Perubahan" />
    <span class="text-danger error-text nama_error_edit"></span>
    <!--end::Input-->
</div>
<!--end::Input group-->
<!--begin::Input group-->
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fs-6 fw-semibold mb-2">Deskripsi Perubahan</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="deskripsi" id="Editdeskripsi" value="{{ $data->deskripsi }}"
        class="form-control border border-1 border-dark rounded mb-3 mb-lg-0" placeholder="Deskripsi Perubahan" />
    <span class="text-danger error-text deskripsi_error_edit"></span>
    <!--end::Input-->
</div>
<!--end::Input group-->
<label class="required fs-6 fw-semibold mb-2">Logs</label>
<span class="text-danger error-text logs_error_edit"></span>
<!--begin::Repeater-->
<!-- Fitur Baru -->
<div class="border border-gray-500 rounded border-active active p-4 mb-2">
    <label class="required fs-6 fw-semibold mb-2">Fitur Baru</label>
    <div id="edit-new-repeater">
        <div class="form-group">
            <div data-repeater-list="logs[new]">
                @if (!empty(json_decode($data->logs)->New))
                    @foreach (json_decode($data->logs)->New as $index => $new)
                        <div data-repeater-item>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" value="{{ $new->nama }}"
                                        class="form-control mb-2 mb-md-0" placeholder="nama fitur" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control mb-2 mb-md-0" placeholder="deskripsi fitur">{{ $new->deskripsi }}</textarea>
                                </div>
                                <div class="col-md-2">
                                    <a href="javascript:;" data-repeater-delete
                                        class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                        <i class="ki-duotone ki-trash fs-5"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div data-repeater-item>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control mb-2 mb-md-0"
                                    placeholder="nama fitur" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control mb-2 mb-md-0" placeholder="deskripsi fitur"></textarea>
                            </div>
                            <div class="col-md-2">
                                <a href="javascript:;" data-repeater-delete
                                    class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                    <i class="ki-duotone ki-trash fs-5"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group mt-5">
            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                <i class="ki-duotone ki-plus fs-3"></i> Add
            </a>
        </div>
    </div>
</div>

<!-- Pembaharuan -->
<div class="border border-gray-500 rounded border-active active p-4 mb-2">
    <label class="required fs-6 fw-semibold mb-2">Pembaharuan</label>
    <div id="edit-update-repeater">
        <div class="form-group">
            <div data-repeater-list="logs[update]">
                @if (!empty(json_decode($data->logs)->Update))
                    @foreach (json_decode($data->logs)->Update as $update)
                        <div data-repeater-item>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" value="{{ $update->nama }}"
                                        class="form-control mb-2 mb-md-0" placeholder="nama pembaharuan" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control mb-2 mb-md-0" placeholder="deskripsi pembaharuan">{{ $update->deskripsi }}</textarea>
                                </div>
                                <div class="col-md-2">
                                    <a href="javascript:;" data-repeater-delete
                                        class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                        <i class="ki-duotone ki-trash fs-5"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div data-repeater-item>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control mb-2 mb-md-0"
                                    placeholder="nama pembaharuan" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control mb-2 mb-md-0" placeholder="deskripsi pembaharuan"></textarea>
                            </div>
                            <div class="col-md-2">
                                <a href="javascript:;" data-repeater-delete
                                    class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                    <i class="ki-duotone ki-trash fs-5"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group mt-5">
            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                <i class="ki-duotone ki-plus fs-3"></i> Add
            </a>
        </div>
    </div>
</div>

<!-- Perbaikan -->
<div class="border border-gray-500 rounded border-active active p-4 mb-2">
    <label class="required fs-6 fw-semibold mb-2">Perbaikan</label>
    <div id="edit-fix-repeater">
        <div class="form-group">
            <div data-repeater-list="logs[fix]">
                @if (!empty(json_decode($data->logs)->Fix))
                    @foreach (json_decode($data->logs)->Fix as $fix)
                        <div data-repeater-item>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" value="{{ $fix->nama }}"
                                        class="form-control mb-2 mb-md-0" placeholder="nama perbaikan" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control mb-2 mb-md-0" placeholder="deskripsi perbaikan">{{ $fix->deskripsi }}</textarea>
                                </div>
                                <div class="col-md-2">
                                    <a href="javascript:;" data-repeater-delete
                                        class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                        <i class="ki-duotone ki-trash fs-5"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div data-repeater-item>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control mb-2 mb-md-0"
                                    placeholder="nama perbaikan" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control mb-2 mb-md-0" placeholder="deskripsi perbaikan"></textarea>
                            </div>
                            <div class="col-md-2">
                                <a href="javascript:;" data-repeater-delete
                                    class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                    <i class="ki-duotone ki-trash fs-5"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group mt-5">
            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                <i class="ki-duotone ki-plus fs-3"></i> Add
            </a>
        </div>
    </div>
</div>

<!--end::Repeater-->

<script src="{{ URL::to('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>

<script>
    $('#edit-new-repeater').repeater({
        initEmpty: false,

        defaultValues: {
            'text-input': 'foo'
        },

        show: function() {
            $(this).slideDown();
        },

        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });

    $('#edit-update-repeater').repeater({
        initEmpty: false,

        defaultValues: {
            'text-input': 'foo'
        },

        show: function() {
            $(this).slideDown();
        },

        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });

    $('#edit-fix-repeater').repeater({
        initEmpty: false,

        defaultValues: {
            'text-input': 'foo'
        },

        show: function() {
            $(this).slideDown();
        },

        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });
</script>
