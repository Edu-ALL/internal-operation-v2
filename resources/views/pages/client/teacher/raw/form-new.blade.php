@extends('layout.main')

@section('title', 'Student')

@push('styles')
@endpush

@section('content')
    <div class="row justify-content-center mb-3">
        <div class="col-md-7">
            <div class="card rounded">
                <div class="card-header">
                    <h5 class="m-0">
                        Confirming Data
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="mb-1">
                                Full Name
                            </div>
                            <div class="mb-2">
                                <input type="text" name="name" id="nameNew" value=""
                                    class="form-control form-control-sm" placeholder="Type new full name"
                                    oninput="checkInputText(this, 'name')">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="mb-1">
                                Email
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" id="emailNew" value=""
                                    class="form-control form-control-sm" placeholder="Type new email"
                                    oninput="checkInputText(this, 'email')">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="mb-1">
                                Phone Number
                            </div>
                            <div class="mb-2">
                                <input type="tel" name="phone" id="phoneNew" value=""
                                    class="form-control form-control-sm" placeholder="Type new phone number"
                                    oninput="checkInputText(this, 'phone')">
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
                                                class="form-control form-control-sm" value="New School"
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
                                    <div id="namePreview"></div>
                                    <input type="hidden" name="nameFinal" id="nameInputPreview" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>
                                    <div id="emailPreview"></div>
                                    <input type="hidden" name="emailFinal" id="emailInputPreview" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>:</td>
                                <td>
                                    <div id="phonePreview"></div>
                                    <input type="hidden" name="phoneFinal" id="phoneInputPreview" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>School Name</td>
                                <td>:</td>
                                <td>
                                    <div id="schoolPreview">New School</div>
                                    <input type="hidden" name="schoolFinal" id="schoolInputPreview">
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
            $('#schoolNew').prop('disabled', false).val('New School')
            $('#schoolPreview').html('New School')
            $('#schoolInputPreview').val('New School')
        });

        function checkInputText(item, init, type = null) {
            if ($(item).val() != "") {
                $('#' + init + 'Preview').html($(item).val())

                if (type == 'select') {
                    if (init == 'school') {
                        $('#' + init + 'New').prop('disabled', true).val('')
                    }
                    $('#' + init + 'InputPreview').val($(item).find(":selected").data('id'))
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

        syncSchool()
    </script>
@endpush