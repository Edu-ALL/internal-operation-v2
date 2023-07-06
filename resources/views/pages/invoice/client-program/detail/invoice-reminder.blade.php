            <table class="table table-bordered table-hover nowrap align-middle w-100" id="programTable">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="bg-info text-white">#</th>
                        <th class="bg-info text-white">Client Name</th>
                        <th>Program Name</th>
                        <th>Invoice ID</th>
                        <th>Payment Method</th>
                        <th>Created At</th>
                        <th>Due Date</th>
                        <th>Total Price</th>
                        <th class="bg-info text-white">Action</th>
                    </tr>
                </thead>
                <tfoot class="bg-light text-white">
                    <tr>
                        <td colspan="7"></td>
                    </tr>
                </tfoot>
            </table>

            <div class="modal fade" id="reminderModal" data-bs-backdrop="static" data-bs-keyboard="false"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span>
                                Reminder
                            </span>
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div class="modal-body w-100 text-start">
                            {{-- <form action="" method="POST" id="reminderForm"> --}}
                                {{-- @method('put') --}}
                                <div class="form-group">

                                    <label for="">Phone Number Parent</label>
                                    <input type="text" name="phone" id="phone" class="form-control w-100">
                                    <input type="hidden" name="client_id" id="client_id">
                                    <input type="hidden" name="clientprog_id" id="clientprog_id">
                                    <input type="hidden" name="parent_fullname" id="fullname">
                                    <input type="hidden" name="program_name" id="program_name">
                                    <input type="hidden" name="invoice_duedate" id="invoice_duedate">
                                    <input type="hidden" name="total_payment" id="total_payment">
                                    <input type="hidden" name="payment_method" id="payment_method">
                                    <input type="hidden" name="parent_id" id="parent_id">
                                </div>
                                {{-- <hr> --}}
                                <div class="d-flex justify-content-between">
                                    <button type="button" href="#" class="btn btn-outline-danger btn-sm"
                                    data-bs-dismiss="modal">
                                        <i class="bi bi-x-square me-1"></i>
                                        Cancel</button>
                                    <button type="button" onclick="sendWhatsapp()" class="btn btn-primary btn-sm">
                                        <i class="bi bi-save2 me-1"></i>
                                        Send</button>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>


            {{-- Need Changing --}}
            <script>
                function sendWhatsapp()
                    {
                        showLoading();
    
                        // $('#reminderModal').modal('show'); 
    
                        var clientprog_id = $('#clientprog_id').val();
                        var parent_fullname = $('#fullname').val();
                        var phone = $('#phone').val();
                        var program_name = $('#program_name').val();
                        var invoice_duedate = $('#invoice_duedate').val();
                        var total_payment = $('#total_payment').val();
                        var payment_method = $('#payment_method').val();
                        var parent_id = $('#parent_id').val();
                        var client_id = $('#client_id').val();

                        
                        var link = '{{ url("/") }}/invoice/client-program/'+clientprog_id+'/remind/by/whatsapp';
                        axios.post(link, {
                                parent_fullname : parent_fullname,
                                phone : phone,
                                program_name : program_name,
                                invoice_duedate : invoice_duedate,
                                total_payment : total_payment,
                                payment_method : payment_method,
                                parent_id : parent_id,
                                client_id : client_id
                            })
                            .then(function(response) {
                                swal.close();
                                $('#reminderModal').modal('hide'); 
                                
                                
                                let obj = response.data;
                                var link = obj.link;
                                window.open(link)
                            })
                            .catch(function(error) {
                                $('#reminderModal').modal('hide'); 
                                swal.close();
                                notification('error', error)
                            })
                    }

                function openModalReminder(params){
                    $('#reminderModal').modal('show'); 

                    var clientprog_id = params[0];
                    var parent_fullname = params[1];
                    var parent_phone = params[2];
                    var program_name = params[3];
                    var invoice_duedate = params[4];
                    var total_payment = params[5];
                    var payment_method = params[6];
                    var parent_id = params[7];
                    var client_id = params[8];
                    var child_phone = params[9];

                    $('#phone').val(parent_id == null ? child_phone : parent_phone)
                    $('#fullname').val(parent_fullname)
                    $('#program_name').val(program_name)
                    $('#invoice_duedate').val(invoice_duedate)
                    $('#total_payment').val(total_payment)
                    $('#clientprog_id').val(clientprog_id)
                    $('#payment_method').val(payment_method)
                    $('#parent_id').val(parent_id)
                    $('#client_id').val(client_id)

                }

                
                var widthView = $(window).width();
                $(document).ready(function() {
                    // $('form :input').val('');
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
                                data: 'inv_id',
                                name: 'tbl_inv.inv_id',
                            },
                            {
                                data: 'inv_paymentmethod',
                                name: 'inv_paymentmethod',
                            },
                            {
                                data: 'show_created_at',
                                name: 'show_created_at',
                                render: function(data, type, row, meta) {
                                    return moment(data).format('MMMM Do YYYY');
                                }
                            },
                            {
                                data: 'inv_duedate',
                                name: 'inv_duedate',
                                render: function(data, type, row, meta) {
                                    return moment(data).format('MMMM Do YYYY');
                                }
                            },
                            {
                                data: 'inv_totalprice_idr',
                                name: 'inv_totalprice_idr',
                                render: function(data, type, row) {
                                    return new Intl.NumberFormat("id-ID", {
                                        style: "currency",
                                        currency: "IDR",
                                        minimumFractionDigits: 0
                                    }).format(data);

                                }
                            },
                            {
                                data: 'clientprog_id',
                                className: 'text-center',
                                render: function(data, type, row) {
                                    var difference = row.date_difference;
                                    var difference = 2;

                                    var link = "{{ url('invoice/client-program') }}/" + row.clientprog_id
                                    var detail_btn = '<a href="' + link + '" class="btn btn-sm btn-outline-warning"><i class="bi bi-eye"></i></a>';

                                    // if (difference > 0 && difference <= 7)
                                    // {
                                    //     let reminder_params = [
                                    //         row.clientprog_id,
                                    //         row.inv_id
                                    //     ];

                                    //     let params = JSON.stringify(reminder_params);
                                        
                                    //     var email_btn = '<a href="#remind_parent" onclick=\'sendReminder('+params+')\' class="btn btn-sm btn-outline-warning mx-1"><i class="bi bi-send"></i></a>';
                                    //     detail_btn += email_btn;
                                    // }
                                    
                                    if ((difference > 0 && difference <= 3))
                                    {
                                        let whatsapp_params = [
                                            row.clientprog_id,
                                            row.parent_fullname,
                                            row.parent_phone,
                                            row.program_name,
                                            row.inv_duedate,
                                            row.inv_totalprice_idr,
                                            row.inv_paymentmethod,
                                            row.parent_id,
                                            row.client_id,
                                            row.child_phone,
                                        ];

                                        var params = JSON.stringify(whatsapp_params);
                                        params = params.replaceAll("\"",  "'");

              

                                        // var whatsapp_btn = '<a href="#remind_parent" onclick=\'openModalReminder('+params+')\' class="mx-1 btn btn-sm btn-outline-success"><i class="bi bi-whatsapp"></i></a>';
                                        var whatsapp_btn = "<a href=\"#remind_parent\" onclick=\"openModalReminder("+params+")\" class=\"mx-1 btn btn-sm btn-outline-success\"><i class=\"bi bi-whatsapp\"></i></a>";
                                        // var whatsapp_btn = '<button data-bs-toggle="modal" data-bs-target="#reminderModal" class="mx-1 btn btn-sm btn-outline-success reminder"><i class="bi bi-whatsapp"></i></button>';

                                        detail_btn += whatsapp_btn;
                                    }
                                    
                                    return detail_btn;
                                }
                            }
                        ],
                        createdRow: function (row, data, index) {
                            var today_month = moment(data).format('MMMM')
                            var today_year = moment(data).format('YYYY');
                            if (today_month == moment(data.inv_duedate).format('MMMM') && today_year == moment(data.inv_duedate).format('YYYY'))
                                $('td', row).addClass('bg-primary text-light');
                        }
                        // createdRow: (row, data, cells) => {
                        //     var difference = data.date_difference;
                        //     if (difference > 3 && difference <= 7)
                        //         $('td', row).addClass("bg-warning-soft");
                        //     else if (difference > 0 && difference <= 3)
                        //         $('td', row).addClass('bg-danger-soft');
                        //     else if (difference == 0)
                        //         $('td', row).addClass('bg-danger');
                        //     else if (difference < 0)
                        //         $('td', row).addClass('bg-primary-soft')
                        // }

                    })

                });
            </script>
            <script>
                function sendReminder(params)
                {
                    showLoading();

                    var clientprog_id = params[0];
                    var invoice_id = params[1];

                    var link = '{{ url("/") }}/invoice/client-program/'+clientprog_id+'/remind/by/email';
                    axios.post(link, {
                            invoice_id : invoice_id
                        })
                        .then(function(response) {
                            swal.close();
                            notification('success', 'Reminder has been sent');
                        })
                        .catch(function (error) {
                            swal.close();
                            notification('error', error.response.data.message);
                        });
                }

                
                
            </script>

            <script>
                
            </script>