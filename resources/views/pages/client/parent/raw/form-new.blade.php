@extends('layout.main')

@section('title', 'Student')

@push('styles')
@endpush

@section('content')
    <div class="row justify-content-center mb-3">
        <div class="col-md-5">
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
                        <div class="col-md-12 mb-2">
                            <div class="mb-1">
                                Email
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" id="emailNew" value=""
                                    class="form-control form-control-sm" placeholder="Type new email"
                                    oninput="checkInputText(this, 'email')">
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="mb-1">
                                Phone Number
                            </div>
                            <div class="mb-2">
                                <input type="tel" name="phone" id="phoneNew" value=""
                                    class="form-control form-control-sm" placeholder="Type new phone number"
                                    oninput="checkInputText(this, 'phone')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
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
                                    <input type="text" name="phoneFinal" id="phoneInputPreview" value="">
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
        function checkInputText(item, init, type = null) {
            if ($(item).val() != "") {
                $('#' + init + 'Preview').html($(item).val())
                $('#' + init + 'InputPreview').val($(item).val())
            }
        }
    </script>
@endpush