<div class="card mb-3">
    <div class="card-header">
        <h6 class="p-0 m-0">Program Status</h6>
    </div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3 text-center">
                <a href="{{ url('program/client?start_date=' . Request::get('start') . '&end_date=' . Request::get('end') . '&program_status[]=' . encrypt('0')) }}"
                    class="text-decoration-none" target="_blank">
                    <div class="border p-2 shadow-sm rounded text-warning">
                        <h3>{{ $countClientProgram['pending'] }}</h3>
                        <h6 class="m-0 p-0">Pending</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3 text-center">
                <a href="{{ url('program/client?start_date=' . Request::get('start') . '&end_date=' . Request::get('end') . '&program_status[]=' . encrypt('2')) }}"
                    class="text-decoration-none" target="_blank">
                    <div class="border p-2 shadow-sm rounded text-danger">
                        <h3>{{ $countClientProgram['failed'] }}</h3>
                        <h6 class="m-0 p-0">Failed</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3 text-center">
                <a href="{{ url('program/client?start_date=' . Request::get('start') . '&end_date=' . Request::get('end') . '&program_status[]=' . encrypt('3')) }}"
                    class="text-decoration-none" target="_blank">
                    <div class="border p-2 shadow-sm rounded text-info">
                        <h3>{{ $countClientProgram['refund'] }}</h3>
                        <h6 class="m-0 p-0">Refund</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3 text-center">
                <a href="{{ url('program/client?start_date=' . Request::get('start') . '&end_date=' . Request::get('end') . '&program_status[]=' . encrypt('1')) }}"
                    class="text-decoration-none" target="_blank">
                    <div class="border p-2 shadow-sm rounded text-success">
                        <h3>{{ $countClientProgram['success'] }}</h3>
                        <h6 class="m-0 p-0">Success</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>