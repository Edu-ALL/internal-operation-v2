@extends('layout.main')

@section('title', 'List of Teacher')

@push('styles')
    <style>
        .btn-download span,
        .btn-import span {
            display: none;
        }

        .btn-download:hover>span,
        .btn-import:hover>span {
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="card bg-secondary mb-1 p-2">
        <div class="row align-items-center g-3">
            <div class="col-md-8">
                <h5 class="text-white m-0">
                    <i class="bi bi-tag me-1"></i>
                    Teachers
                </h5>
            </div>
            <div class="col-md-4">
                <div class="row g-1">
                    <div class="col-md-4 col-7">
                        <a href="{{ url('api/download/excel-template/teacher') }}"
                            class="btn btn-sm btn-light text-info btn-download w-100"><i class="bi bi-download"></i> <span
                                class="ms-1">Template</span></a>
                    </div>
                    <div class="col-md-4 col-5">
                        <a href="javascript:void(0)" class="btn btn-sm btn-light text-info btn-import w-100"
                            data-bs-toggle="modal" data-bs-target="#importData"><i class="bi bi-cloud-upload"></i> <span
                                class="ms-1">Import</span></a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ url('client/teacher-counselor/create') }}" class="btn btn-sm btn-info w-100"><i
                                class="bi bi-plus-square me-1"></i> Add
                            Teacher</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card rounded">
        <div class="card-body">
            <ul class="nav nav-tabs flex-nowrap overflow-auto w-100 mb-3" style="overflow-y: hidden !important;">
                <li class="nav-item">
                    <a class="nav-link text-nowrap" aria-current="page" href="{{ url('client/teacher-counselor/raw') }}">Raw
                        Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap active" aria-current="page"
                        href="{{ url('client/teacher-counselor') }}">Teacher</a>
                </li>
            </ul>

            <table class="table table-bordered table-hover nowrap align-middle w-100" id="clientTable">
                <thead class="bg-secondary text-white">
                    <tr class="text-center" role="row">
                        <th class="bg-info text-white">No</th>
                        <th class="bg-info text-white">Teacher Name</th>
                        <th>Teacher Email</th>
                        <th>Teacher Number</th>
                        <th>From</th>
                        <th class="bg-info text-white">Status</th>
                        <th class="bg-info text-white">#</th>
                    </tr>
                </thead>
                {{-- <tfoot class="bg-light text-white">
                    <tr>
                        <td colspan="7"></td>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>

    <div class="modal fade" id="importData" tabindex="-1" aria-labelledby="importDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('teacher-counselor.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="importDataLabel">Import CSV Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">CSV File</label>
                                <input type="file" name="file" id="" class="form-control form-control-sm">
                            </div>
                            <small class="text-warning mt-3">
                                * Please clean the file first, before importing the csv file. <br>
                                You can download the csv template <a
                                    href="{{ url('api/download/excel-template/parent') }}">here</a>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">
                            <i class="bi bi-x"></i>
                            Close</button>
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-upload"></i>
                            Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        var widthView = $(window).width();
        $(document).ready(function() {
            var table = $('#clientTable').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 50, 100, -1],
                    ['10 teachers', '50 teachers', '100 teachers', 'Show all']
                ],
                buttons: [
                    'pageLength', {
                        extend: 'excel',
                        text: 'Export to Excel',
                    }
                ],
                scrollX: true,
                fixedColumns: {
                    left: (widthView < 768) ? 1 : 2,
                    right: 1
                },
                processing: true,
                serverSide: true,
                ajax: '',
                columns: [{
                        data: 'id',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'full_name',
                        render: function(data, type, row, meta) {
                            return data
                        }
                    },
                    {
                        data: 'mail',
                        defaultContent: '-'
                    },
                    {
                        data: 'phone',
                        className: 'text-center',
                        defaultContent: '-'
                    },
                    {
                        data: 'school_name',
                        name: 'school_name',
                        className: 'text-center',
                        defaultContent: '-'
                    },
                    {
                        data: 'st_statusact',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return data == 1 ?
                                "<div class='badge badge-outline-success'>Active</div>" :
                                "<div class='badge badge-outline-danger'>NonActive</div>";
                        }
                    },
                    {
                        data: '',
                        className: 'text-center',
                        defaultContent: '<button type="button" class="btn btn-sm btn-outline-warning editClient" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More Detail"><i class="bi bi-eye"></i></button>'
                    }
                ],
            });

            @php
                $privilage = $menus['Client']->where('submenu_name', 'Teacher/Counselor')->first();
            @endphp

            @if ($privilage['copy'] == 0)
                document.oncontextmenu = new Function("return false");

                $('body').bind('cut copy paste', function(event) {
                    event.preventDefault();
                });
            @endif

            @if ($privilage['export'] == 0)
                table.button(1).disable();
            @endif

            // Tooltip 
            $('#clientTable tbody').on('mouseover', 'tr', function() {
                $('[data-bs-toggle="tooltip"]').tooltip({
                    trigger: 'hover',
                    html: true
                });
            });

            $('#clientTable tbody').on('click', '.editClient ', function() {
                var data = table.row($(this).parents('tr')).data();
                window.open("{{ url('client/teacher-counselor') }}/" + data.id, "_blank");
            });

        });
    </script>
@endpush
