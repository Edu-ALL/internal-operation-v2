@extends('app')
@section('title', 'Merge Data')
@section('style')
@endsection
@section('body')
    <section>
        <div class="container-fluid my-3">
            <div class="row justify-content-center align-items-center" style="height: 100vh">
                <div class="col-md-8">
                    <div class="text-center">
                        <h2>Merge Data</h2>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="" method="POST" id="formMerge" enctype="multipart/form-data">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-5">
                                        <input type="file" name="file" class="form-control" required>
                                    </div>
                                    <div class="col-5">
                                        <select id="type" class="form-select" required onchange="checkType()">
                                            <option value=""></option>
                                            <option value="school">School</option>
                                        </select>
                                    </div>
                                    <div class="col-2 d-grid">
                                        <button class="btn btn-sm btn-primary">Merge</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function checkType(){
            let type = $('#type').val()
            $('#formMerge').attr('action', '{{url("merge")}}/' + type + '/import');
                   
        }
    </script>
@endsection
