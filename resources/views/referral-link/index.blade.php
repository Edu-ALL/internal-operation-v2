@extends('app')
@section('title', 'Registration Form - STEM + Wonderlab')
@section('css')
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />

    <link type="text/css" rel="stylesheet"
        href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-classic.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
@endsection
@section('body')
    <section>
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center" style="height: 100vh">
                <div class="col-md-4 px-5">
                    {{-- <div class="card" style="background: #233469;">
                        <div class="card-body">
                            <textarea name="" id="bar" class="form-control" rows="15">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fuga itaque voluptas cum ratione ab, quidem laboriosam nulla praesentium atque expedita aut, eius corrupti explicabo vitae repellat deleniti nemo eaque ea. 

                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit voluptatum est deleniti, neque, fugit, ipsam quibusdam laborum fugiat illo rem dolores modi iure quae inventore! Nobis impedit corrupti ducimus officiis.
                                                                
                                https://all-inedu.com
                            </textarea>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-sm text-white" data-clipboard-action="copy" data-clipboard-target="#bar"
                            style="background: #233469;">
                            <i class="bi bi-clipboard-check"></i>
                            Copy & Share
                        </button>
                    </div> --}}

                    <div class="text-center d-flex align-items-center mb-3 justify-content-between">
                        <input type="url" name="" id="url" value="https://all-inedu.com"
                            class="form-control">
                        <div id="share" class="w-50 text-end"></div>
                    </div>

                    {{-- Instruction  --}}
                    <div class="card shadow mb-3">
                        <div class="card-header" style="background: #233469;">
                            <h6 class="p-0 m-0 text-white  d-flex justify-content-between">
                                Instructions
                                <i class="bi bi-info-circle me-2"></i>
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    On the event day, present the QR code to the registration
                                    personnel at the venue to expedite the entry process.
                                </li>
                                <li class="list-group-item">
                                    Enjoy our event and take the opportunity to connect with fellow
                                    peers.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Instruction  --}}
                    <div class="card shadow">
                        <div class="card-header" style="background: #233469;">
                            <h6 class="p-0 m-0 text-white  d-flex justify-content-between">
                                Benefit
                                <i class="bi bi-info-circle me-2"></i>
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    On the event day, present the QR code to the registration
                                    personnel at the venue to expedite the entry process.
                                </li>
                                <li class="list-group-item">
                                    Enjoy our event and take the opportunity to connect with fellow
                                    peers.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#share").jsSocials({
                url: $('#url').val(),
                showLabel: false,
                showCount: false,
                shares: ["whatsapp", "facebook", "linkedin"]
            });

            new ClipboardJS('.btn');
            tinymce.remove('#bar');
        });
    </script>
@endsection
