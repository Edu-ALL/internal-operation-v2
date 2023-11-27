@extends('layout.main')

@section('title', 'Raw Data Teacher')

@push('styles')
    <link rel="stylesheet" href="{{ asset('library/dashboard/css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
    <style>
        .btn-download span,
        .btn-import span {
            display: none;
        }

        .btn-download:hover>span,
        .btn-import:hover>span {
            display: inline-block;
        }

        td.dt-control {
            background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.dt-control {
            background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
@endpush

@section('content')
    <div class="card bg-secondary mb-1 p-2">
        <div class="row align-items-center justify-content-between g-3">
            <div class="col-md-6">
                <h5 class="text-white m-0">
                    <i class="bi bi-tag me-1"></i>
                    Teacher
                </h5>
            </div>
            <div class="col-md-6">
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
                    <a class="nav-link text-nowrap active" aria-current="page" href="{{ url('client/teacher-counselor/raw') }}">Raw
                        Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" aria-current="page" href="{{ url('client/teacher-counselor') }}">Teacher</a>
                </li>
            </ul>


            <style>
                #clientTable tr td.danger {
                    background: rgb(255, 151, 151)
                }
            </style>
            <div class="table-responsive">
                <table class="table table-bordered table-hover nowrap align-middle w-100" id="rawTable">
                    <thead class="bg-secondary text-white">
                        <tr class="text-center" role="row">
                            <th class="bg-info text-white">#</th>
                            <th class="bg-info text-white">No</th>
                            <th class="bg-info text-white">Teacher Name</th>
                            <th class="bg-info text-white">Suggestion</th>
                            <th>Teacher Email</th>
                            <th>Teacher Number</th>
                            <th>From</th>
                            <th>Last Updated</th>
                            <th class="bg-info text-white">Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                <td class="dt-control"></td>
                                <td>{{ $i }}</td>
                                <td>Lorem</td>
                                <td>
                                    <div class="badge badge-warning">
                                        2 Similar Name
                                    </div>
                                </td>
                                <td>Lorem</td>
                                <td>Lorem</td>
                                <td>Lorem</td>
                                <td>Lorem</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger py-1 px-2" onclick="confirmDelete('raw-data', 1)">
                                        <i class="bi bi-eraser"></i>
                                    </button>
                                </td>
                            </tr>
                        @endfor
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var widthView = $(window).width();
        $(document).ready(function() {

            // Formatting function for row details - modify as you need
            function format(d) {
                var similar = '<table class="table w-auto table-hover">'

                if(d.suggestion.length > 0){
                    similar +=
                        '<th colspan=5>Comparison with Similar Names:</th>' +
                        '</tr>' +
                        '<tr>' +
                        '<th>#</th><th>Name</th><th>Email</th><th>Phone Number</th>' +
                        '</tr>';

                    d.suggestion.forEach(function(item, index) {
                        similar += '<tr onclick="comparison(' +
                        d.id + ',' + item.id + ')" class="cursor-pointer">' +
                        '<td><input type="radio" name="similar' + d.id +
                        '" class="form-check-input item-' + item.id + '" onclick="comparison(' +
                        d.id + ',' + item.id + ')" /></td>' +
                        '<td>' + item.first_name + ' ' + item.last_name + '</td>' +
                        '<td>' + (item.mail !== null ? item.mail : '-') + '</td>' +
                        '<td>' + (item.phone !== null ? item.phone : '-') + '</td>' +
                        '</tr>'
                    })
                }


                similar +=
                    '<tr>' +
                    '<th colspan=5>Convert without Comparison</th>' +
                    '</tr>' +
                    '<tr class="cursor-pointer" onclick="newLeads(' +
                    d.id + ')">' +
                    '<td><input type="radio" name="similar' + d.id +
                    '" class="form-check-input item-' + d.id + '" onclick="newLeads(' +
                    d.id + ')" /></td>' +
                    '<td colspan=4>New Teacher</td>' +
                    '</tr>' +
                    '</table>'
                // `d` is the original data object for the row
                return (similar);
            }

            var table = $('#rawTable').DataTable({
                order: [
                    // [20, 'desc'],
                    [1, 'asc']
                ],
                dom: 'Bfrtip',
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
                ajax: {
                    url: '',
                },
                columns: [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: ''
                    },
                    {
                        data: 'id',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'fullname',
                        render: function(data, type, row, meta) {
                            return data
                        }
                    },
                    {
                        data: 'suggestion',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return data.length > 0 ?
                                '<div class="badge badge-warning py-1 px-2 ms-2">' + data
                                .length + ' Similar Names</div>' : '-'
                        }
                    },
                    {
                        data: 'mail',
                        defaultContent: '-'
                    },
                    {
                        data: 'phone',
                        defaultContent: '-'
                    },
                    {
                        data: 'school_name',
                        defaultContent: '-'
                    },
                    {
                        data: 'updated_at',
                        className: 'text-center',
                        defaultContent: '-'
                    },
                    {
                        data: '',
                        className: 'text-center',
                        defaultContent: '<button type="button" class="btn btn-sm btn-outline-danger ms-1 deleteRawClient"><i class="bi bi-trash2"></i></button>'
                    },
                ],
            });
            // Add a click event listener to each row in the parent DataTable
            table.on('click', 'td.dt-control', function(e) {
                let tr = e.target.closest('tr');
                let row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                }
            });

            $('#rawTable tbody').on('click', '.deleteRawClient ', function() {
                var data = table.row($(this).parents('tr')).data();
                confirmDelete('client/teacher-counselor/raw', data.id)
            });

        });

        function comparison(id, id2) {
            $('input.item-' + id2).prop('checked', true);
            window.open("{{ url('client/teacher-counselor/raw/') }}" + '/' + id + '/comparison/' + id2, "_blank");
        }

        function newLeads(id) {
            $('input.item-' + id).prop('checked', true);
            window.open("{{ url('client/teacher-counselor/raw/') }}" + '/' + id + '/new', "_blank");
        }
    </script>
@endpush
