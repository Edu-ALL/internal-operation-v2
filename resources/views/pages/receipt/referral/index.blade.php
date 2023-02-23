@extends('layout.main')

@section('title', 'Receipt - Referral - Bigdata Platform')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="{{ url('dashboard') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-2"></i> Receipt
        </a>
    </div>


    <div class="card rounded">
        <div class="card-body">
            <table class="table table-bordered table-hover nowrap align-middle w-100" id="receiptTable">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="bg-info text-white">#</th>
                        <th class="bg-info text-white">Partner Name</th>
                        <th>Program Name</th>
                        <th>Receipt ID</th>
                        <th>Invoice ID</th>
                        <th>Payment Method</th>
                        <th>Receipt Date</th>
                        <th>Total Price Other</th>
                        <th>Total Price IDR</th>
                        <th class="bg-info text-white">Action</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>#</td>
                            <td>Partner Name</td>
                            <td>Program Name</td>
                            <td>Receipt ID</td>
                            <td>Invoice ID</td>
                            <td>Payment Method</td>
                            <td>Receipt Date</td>
                            <td>Total Price</td>
                            <td class="text-center">
                                <a href="{{ url('receipt/referral/1') }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endfor
                </tbody> --}}
                <tfoot class="bg-light text-white">
                    <tr>
                        <td colspan="9"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Need Changing --}}
    <script>
        $(document).ready(function() {
           
            var table = $('#receiptTable').DataTable({
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
                    left: 2,
                    right: 1
                },
                processing: true,
                serverSide: true,
                ajax: '',
                columns: [{
                        data: 'increment_receipt',
                        name: 'tbl_receipt.id',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'corp_name',
                        name: 'tbl_corp.sch_name' 

                    },
                    {
                        data: 'program_name',
                        name: 'tbl_referral.additional_prog_name'
                    },
                    {
                        data: 'receipt_id',
                        name: 'tbl_receipt.receipt_id',
                    },
                    {
                        data: 'invb2b_id',
                    },
                    {
                        data: 'receipt_method',
                        name: 'tbl_receipt.receipt_method',
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            let receipt_date = row.created_at ? moment(row
                                .created_at).format("MMMM Do YYYY HH:mm:ss") : '-'
                            return receipt_date
                        }
                    },
                    {
                        data: 'total_price_other',
                        name: 'tbl_receipt.receipt_amount',
                        render: function(data, type, row, meta) {
                            var currency;
                            var totprice = new Intl.NumberFormat().format(row.total_price_other);
                                switch (row.currency) {
                                    case 'usd':
                                        currency = '$. ';
                                    break;
                                    case 'sgd':
                                        currency = 'S$. ';
                                    break;
                                    case 'gbp':
                                        currency = '£. ';
                                    break;
                                    default:
                                        currency = '';
                                        totprice = '-'
                                        break;
                                    }
                                    return currency + totprice;   
                        }
                        
                    },
                     {
                        data: 'total_price_idr',
                        name: 'tbl_receipt.receipt_amount_idr',
                        render: function(data, type, row, meta) {
                            var totprice = new Intl.NumberFormat().format(row.total_price_idr);
                                    return 'Rp. ' + totprice;   
                        }
                        
                    },
                    {
                        data: '',
                        className: 'text-center',
                        defaultContent: '<button type="button" class="btn btn-sm btn-outline-warning showReceipt"><i class="bi bi-eye"></i></button>'
                    }
                ]
            });

            realtimeData(table)

            $('#receiptTable tbody').on('click', '.showReceipt ', function() {
                var data = table.row($(this).parents('tr')).data();
                window.location.href = "{{ url('receipt/referral/') }}/" + data.increment_receipt;
            });

        });
    </script>
@endsection
