@extends('layout.main')

@section('title', 'Student')

@push('styles')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card rounded">
                <div class="card-header">
                    <h5 class="m-0">
                        Confirming Data
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="mb-1">
                                Full Name
                            </div>
                            <div class="mb-2">
                                <input type="text" name="name" id="nameNew" value="{{ $rawClient->fullname }}"
                                    class="form-control form-control-sm" placeholder="Type new full name"
                                    oninput="checkInputText(this, 'name')">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="mb-1">
                                Email
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" id="emailNew" value="{{ $rawClient->mail }}"
                                    class="form-control form-control-sm" placeholder="Type new email"
                                    oninput="checkInputText(this, 'email')">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="mb-1">
                                Phone Number
                            </div>
                            <div class="mb-2">
                                <input type="tel" name="phone" id="phoneNew" value="{{ $rawClient->phone }}"
                                    class="form-control form-control-sm" placeholder="Type new phone number"
                                    oninput="checkInputText(this, 'phone')">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="mb-1">
                                Graduation Year
                            </div>
                            <div class="mb-2">
                                <input type="text" name="graduation" id="graduationNew"
                                    value="{{ $rawClient->graduation_year }}" class="form-control form-control-sm"
                                    placeholder="Type new graduation year" oninput="checkInputText(this, 'graduation')">
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="mb-1">
                                School Name
                            </div>
                            <div class="mb-2">
                                <div class="row g-2">
                                    <div class="col-5 d-flex gap-2">
                                        <div class="w-100">
                                            <input type="text" name="" id="schoolNew"
                                                class="form-control form-control-sm" value="{{ $rawClient->school }}"
                                                oninput="checkInputText(this, 'school')">
                                            <small class="text-danger">
                                                <i class="bi bi-info-circle-fill"></i>
                                                Not Verified School
                                            </small>
                                        </div>
                                        <div class="mt-2">
                                            OR
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <select class="select w-100 school" name="school" id="schoolExist"
                                            onchange="checkInputText(this, 'school', 'select')">
                                            <option value=""></option>
                                        </select>
                                        <small class="text-success">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Verified School
                                        </small>
                                    </div>
                                    <div class="col-1">
                                        <button class="btn btn-sm btn-outline-dark w-100" onclick="syncSchool()">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                    <div class="col-1">
                                        <button class="btn btn-sm btn-outline-dark w-100" type="button"
                                            onclick="addNewData('school')">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">Parent's Name</label>
                                            <input type="text" name="" id="parentName"
                                                class="form-control form-control-sm" value="{{ $rawClient->parent_name }}"
                                                oninput="checkInputText(this, 'parent')">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Parent's Email</label>
                                            <input type="text" name="" id="parentEmail"
                                                class="form-control form-control-sm" value="{{ $rawClient->parent_mail }}"
                                                oninput="checkInputText(this, 'parentEmail')">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Parent's Phone</label>
                                            <input type="text" name="" id="parentPhone"
                                                class="form-control form-control-sm"
                                                value="{{ $rawClient->parent_phone }}"
                                                oninput="checkInputText(this, 'parentPhone')">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-around align-items-center w-100 gap-3">
                                        <hr class="border border-warning border-1 opacity-50 w-100">
                                        <div class="text-nowrap">Or Use Existing Parent</div>
                                        <hr class="border border-warning border-1 opacity-50 w-100">
                                    </div>
                                    <div class="mb-2">
                                        <div class="row g-1">
                                            <div class="col-10">
                                                <select class="select w-100 parent" name="parent" id="parentNew"
                                                    onchange="checkInputText(this, 'parent', 'select')">
                                                    <option value=""></option>
                                                    <option value="Add">Add Parent</option>
                                                </select>
                                            </div>
                                            <div class="col-1">
                                                <button class="btn btn-sm btn-outline-dark w-100" type="button"
                                                    onclick="syncParent()">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </div>
                                            <div class="col-1">
                                                <button class="btn btn-sm btn-outline-dark w-100" type="button"
                                                    onclick="addNewData('parent')">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card rounded position-sticky" style="top:15%;">
                <form action="">
                    @csrf
                    <div class="card-header">
                        <h5>Summarize</h5>
                    </div>
                    <div class="card-body">
                        Preview first before convert this data
                        <hr class="my-1">
                        <input type="hidden" name="id" id="existing_id">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%">Full Name</td>
                                <td width="1%">:</td>
                                <td>
                                    <div id="namePreview">{{ $rawClient->fullname }}</div>
                                    <input type="hidden" name="nameFinal" id="nameInputPreview"
                                        value="{{ $rawClient->fullname }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>
                                    <div id="emailPreview">{{ $rawClient->mail }}</div>
                                    <input type="hidden" name="emailFinal" id="emailInputPreview"
                                        value="{{ $rawClient->mail }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>:</td>
                                <td>
                                    <div id="phonePreview">{{ $rawClient->phone }}</div>
                                    <input type="hidden" name="phoneFinal" id="phoneInputPreview"
                                        value="{{ $rawClient->phone }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Graduation Year</td>
                                <td>:</td>
                                <td>
                                    <div id="graduationPreview">{{ $rawClient->graduation_year }}</div>
                                    <input type="hidden" name="graduationFinal" id="graduationInputPreview"
                                        value="{{ $rawClient->graduation_year }}">
                                </td>
                            </tr>
                            <tr>
                                <td>School Name</td>
                                <td>:</td>
                                <td>
                                    <div id="schoolPreview">{{ $rawClient->school }}</div>
                                    <input type="hidden" name="schoolFinal" id="schoolInputPreview">
                                </td>
                            </tr>
                            <tr>
                                <td>Parent Name</td>
                                <td>:</td>
                                <td>
                                    <div id="parentPreview">{{ $rawClient->parent_name }}</div>
                                    <input type="hidden" name="parentType" id="parentTypeInput" value="exist">
                                    <input type="hidden" name="parentFinal" id="parentInputPreview"
                                        value="{{ $rawClient->parent_id }}">
                                    <input type="hidden" name="parentName" id="parentNameInputPreview"
                                        value="{{ $rawClient->parent_name }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Parent Email</td>
                                <td>:</td>
                                <td>
                                    <div id="parentEmailPreview">{{ $rawClient->parent_mail }}</div>
                                    <input type="hidden" name="parentFinal" id="parentEmailInputPreview">
                                </td>
                            </tr>
                            <tr>
                                <td>Parent Phone</td>
                                <td>:</td>
                                <td>
                                    <div id="parentPhonePreview">{{ $rawClient->parent_phone }}</div>
                                    <input type="hidden" name="parentFinal" id="parentPhoneInputPreview">
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Convert
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#schoolExist').on('select2:unselect', function(e) {
            $('#schoolNew').prop('disabled', false).val('{{ $rawClient->school }}')
            $('#schoolPreview').html('{{ $rawClient->school }}')
            $('#schoolInputPreview').val('{{ $rawClient->school }}')
        });

        $('#parentNew').on('select2:unselect', function(e) {
            $('#parentName').prop('disabled', false).val('{{ $rawClient->parent_name }}')
            $('#parentEmail').prop('disabled', false).val('{{ $rawClient->parent_mail }}')
            $('#parentPhone').prop('disabled', false).val('{{ $rawClient->parent_phone }}')


            $('#parentTypeInput').val('new')
            $('#parentInputPreview').val('')
            $('#parentPreview').html('{{ $rawClient->parent_name }}')
            $('#parentEmailPreview').html('{{ $rawClient->parent_mail }}')
            $('#parentPhonePreview').html('{{ $rawClient->parent_phone }}')
            $('#parentNameInputPreview').val('{{ $rawClient->parent_name }}')
            $('#parentEmailInputPreview').val('{{ $rawClient->parent_mail }}')
            $('#parentPhoneInputPreview').val('{{ $rawClient->parent_phone }}')
        });

        function checkInputText(item, init, type = null) {
            if ($(item).val() != "") {
                $('.' + init).prop('checked', false)
                $('#' + init + 'Preview').html($(item).val())

                if (type == 'select') {
                    if (init == 'school') {
                        $('#' + init + 'New').prop('disabled', true).val('')
                    } else if (init == 'parent') {
                        $('#' + init + 'Name').prop('disabled', true).val('')
                        $('#' + init + 'Email').prop('disabled', true).val('')
                        $('#' + init + 'Phone').prop('disabled', true).val('')

                        $('#' + init + 'Preview').html($(item).find(":selected").data('name'))
                        $('#' + init + 'NameInputPreview').val($(item).find(":selected").data('name'))
                        $('#' + init + 'EmailPreview').html($(item).find(":selected").data('email'))
                        $('#' + init + 'EmailInputPreview').val($(item).find(":selected").data('email'))
                        $('#' + init + 'PhonePreview').html($(item).find(":selected").data('phone'))
                        $('#' + init + 'PhoneInputPreview').val($(item).find(":selected").data('phone'))

                        $('#parentTypeInput').val('exist_select')
                    }
                    $('#' + init + 'InputPreview').val($(item).find(":selected").data('id'))

                } else {
                    if(init=='parent') {
                        $('#' + init + 'NameInputPreview').val($(item).val())
                    } else {
                        $('#' + init + 'InputPreview').val($(item).val())
                    }
                }
            }
        }

        function addNewData(type) {
            if (type == "school") {
                window.open("{{ url('instance/school/create') }}", "_blank");
            } else {
                window.open("{{ url('client/parent/create') }}", "_blank");
            }
        }

        function syncSchool() {
            showLoading();
            axios.get("{{ url('api/instance/school') }}")
                .then(function(response) {
                    const data = response.data.data
                    $('#schoolExist').html('')
                    $('#schoolExist').append('<option value=""></option>')
                    data.forEach(element => {
                        $('#schoolExist').append(
                            '<option data-id="' + element.sch_id + '" value="' + element.sch_name + '">' +
                            element.sch_name + '</option>'
                        )
                    });
                    swal.close()
                })
                .catch(function(error) {
                    swal.close()
                    console.log(error);
                })
        }

        function syncParent() {
            showLoading()
            axios.get("{{ url('api/client/parent') }}")
                .then(function(response) {
                    const data = response.data.data
                    $('#parentNew').html('')
                    $('#parentNew').append('<option value=""></option>')
                    data.forEach(element => {
                        const last_name = element.last_name == null ? '' : ' ' + element.last_name
                        const fullname = element.first_name + last_name
                        $('#parentNew').append(
                            '<option data-id="' + element.id + '" ' +
                            'data-name="' + fullname + '"' +
                            'data-email="' + element.mail + '"' +
                            'data-phone="' + element.phone + '"' +
                            'value="' + fullname + '">' + fullname +
                            '</option>'
                        )
                    });
                    swal.close()
                })
                .catch(function(error) {
                    swal.close()
                    console.log(error);
                })
        }

        syncParent()
        syncSchool()
    </script>
@endpush