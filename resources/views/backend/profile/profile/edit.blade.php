<input type="hidden" name="hidden_id" id="hidden_id" value="{{ $user->id }}" />



<!--begin::Input group for Nama Lengkap (User)-->
<div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="required fs-5 fw-bold mb-2">Nama Lengkap</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="name" id="editName" class="form-control form-control-solid mb-3 mb-lg-0"
        placeholder="Nama Lengkap" value="{{ $user->name }}" />
    <span class="text-danger error-text name_error_edit"></span>
    <!--end::Input-->
</div>
<!--end::Input group-->
