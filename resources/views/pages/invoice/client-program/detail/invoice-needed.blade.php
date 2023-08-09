            <table class="table table-bordered table-hover nowrap align-middle w-100" id="programTable">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th class="bg-info text-white">#</th>
                        <th class="bg-info text-white">Client Name</th>
                        <th>Program Name</th>
                        <th>Program Success Date</th>
                        <th>Conversion Lead</th>
                        <th>PIC</th>
                        <th class="bg-info text-white">Action</th>
                    </tr>
                </thead>
                <tfoot class="bg-light text-white">
                    <tr>
                        <td colspan="7"></td>
                    </tr>
                </tfoot>
            </table>


            {{-- Need Changing --}}
            <script>
                var widthView = $(window).width();
                $(document).ready(function() {
                    var table = $('#programTable').DataTable({
                        dom: 'Bfrtip',
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
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
                                data: 'clientprog_id',
                                className: 'text-center',
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                data: 'fullname',
                            },
                            {
                                data: 'program_name',
                            },
                            {
                                data: 'success_date',
                                className:'text-center',
                                render: function(data, type, row) {
                                    let success_date = data ? moment(data).format("MMMM Do YYYY") : '-'
                                    return success_date
                                }
                            },
                            {
                                data: 'conversion_lead',
                                className:'text-center',
                            },
                            {
                                data: 'pic_name',
                                className:'text-center',
                            },
                            {
                                data: 'clientprog_id',
                                className: 'text-center',
                                render: function(data, type, row) {
                                    var link = "{{ url('invoice/client-program/create') }}?prog=" + row.clientprog_id

                                    return '<a href="' + link + '" class="btn btn-sm btn-outline-warning">' +
                                    '<i class="bi bi-plus"></i> Invoice</a>'
                                }
                            }
                        ]
                    })

                });
            </script>
