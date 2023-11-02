<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Form</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <style>
        .text-danger {
            color: red;
        }

        .iti {
            width: 100% !important;
        }

        .ts-control {
            border: none !important;
            padding: 8px 0 !important;
        }

        .ts-wrapper.single .ts-control,
        .ts-wrapper.single .ts-control input {
            font-size: 1.25rem !important;
        }

        .ts-wrapper.multi .ts-control>div,
        .item {
            cursor: pointer;
            margin: 3px !important;
            padding: 3px 6px;
            background: #a39f9f;
            color: #ffffff;
            border: 0px solid #d0d0d0;
            font-size: 1.25rem !important;
            border-radius: 3px;
        }

        .ts-dropdown {
            font-size: 1.25rem !important;
        }

        .step-active {
            position: relative;
            opacity: 1;
            z-index: 1;
            transition: all 0.4s ease-in-out;
        }

        .step-inactive {
            position: absolute;
            width: 100%;
            z-index: -1;
            opacity: 0;
            transition: all 0.4s ease-in-out;
        }

        .bg-form {
            background-image: url('{{ asset('img/form-embed/bg-form.jpg') }}');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat
        }

        .banner img {
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        @media only screen and (max-width: 600px) {
            .bg-form {
                background: white !important;
            }
        }
    </style>
    <livewire:styles />
</head>

<body>

    @livewire('form-embed.client-events', ['dataClientEvent' => ['leads' => $leads, 'schools' => $schools, 'event' => $event, 'tags' => $tags]])
    <script src="
            https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js
            "></script>
    <link href="
        https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css
        "
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script>
        var user1 = document.querySelector("#phoneUser1");
        var user2 = document.querySelector("#phoneUser2");

        const phoneInput1 = window.intlTelInput(user1, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
            initialCountry: 'id',
            onlyCountries: ["id", "us", "gb", "sg", "au", "my"],
        });

        const phoneInput2 = window.intlTelInput(user2, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
            initialCountry: 'id',
            onlyCountries: ["id", "us", "gb", "sg", "au", "my"],
        });

        new TomSelect('#schoolList', {
            create: true
        });

        new TomSelect('#graduation_year', {
            create: false
        });

        new TomSelect('#destination_country', {
            create: false
        });

        new TomSelect('#leadSource', {
            create: false
        });

        $("#btn-submit").on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                width: 100,
                didOpen: () => {
                    Swal.showLoading()
                },
                allowOutsideClick: () => !Swal.isLoading()
            })

            $('#form-events').submit()
        })

        $(function() {

            $("#role-1").prop('checked', true).trigger('change');
        })

        $(document).ready(function() {
            const currentPage = $("#" + $('#crPage').val())
            $('.page').removeClass('step-active').addClass('step-inactive')
            currentPage.removeClass("step-inactive").addClass("step-active");
            console.log(currentPage)
        })

        function checkRole(element) {


            const input_child_name = $('#input_child_name')
            const graduation_input = $('#graduation_input')
            const country_input = $('#country_input')
            const role = $('.role')
            const main_user = $(".main-user")
            const user_other = $('.user-other')
            const other_name = $('#other_name')

            if (element.value == "student") {

                role.html('Parent\'s')
                user_other.removeClass('hidden')
                other_name.addClass('required')
                graduation_input.removeClass('hidden')
                country_input.removeClass('hidden')

                setAdditionalInputLabel({
                    "school": "Which school are you from? <span class='text-red-400'>*</span>",
                    "graduation": "When do you expect to graduate? <span class='text-red-400'>*</span>",
                    "country": "Which country are you thinking of studying in?",
                });

            } else if (element.value == "parent") {

                role.html('Child\'s')
                user_other.removeClass('hidden')
                other_name.addClass('required')
                graduation_input.removeClass('hidden')
                country_input.removeClass('hidden')

                setAdditionalInputLabel({
                    "school": "What school does your child go to? <span class='text-red-400'>*</span>",
                    "graduation": "When do you expect your child to graduate? <span class='text-red-400'>*</span>",
                    "country": "Which country does your child interest in studying abroad?",
                });

            } else {
                user_other.addClass('hidden')
                other_name.removeClass('required')
                graduation_input.addClass('hidden')
                country_input.addClass('hidden')

                setAdditionalInputLabel({
                    "school": "Which school are you from? <span class='text-red-400'>*</span>",
                    "graduation": null,

                })
            }
        }

        function setAdditionalInputLabel(messages) {
            $("#school_input label").html(messages['school']);
            $("#graduation_input label").html(messages['graduation']);
            $("#country_input label").html(messages['country'])
        }

        function step(current, next, type) {
            const input = $('#' + current + ' input.required')
            const alert = input.siblings('small.alert')
            const page = $('.page')
            const currentPage = $("#" + current)
            const nextPage = $("#" + next)
            $('#index').val(currentPage)

            for (var i = 0; i < page.length; ++i) {
                page.eq(i).addClass('step-inactive');
            }

            if (type === "prev") {
                $('#crPage').val(next)
                nextPage.removeClass("step-inactive").addClass("step-active")
            } else {
                const check_input = [];
                for (var i = 0; i < input.length; ++i) {
                    if (input.eq(i).attr('type') === "text" || input.eq(i).attr('type') === "number") {
                        if (input.eq(i).val() === "") {
                            alert.eq(i).removeClass('hidden').addClass('block')
                            check_input.push(false);
                        } else {
                            alert.eq(i).removeClass('block').addClass('hidden')
                        }
                    }
                }

                var index = check_input.indexOf(false);

                if (index === 0) {
                    $('#crPage').val(current)
                    currentPage.removeClass("step-inactive").addClass("step-active");
                } else {
                    $('#crPage').val(next)
                    nextPage.removeClass("step-inactive").addClass("step-active");
                }
            }
        }
    </script>
    {{-- <script>
        $("#phoneUser1").on('keyup', function(e) {
            var number1 = phoneInput1.getNumber();
            $("#phone1").val(number1);
        });
    
        $("#phoneUser2").on('keyup', function(e) {
            var number2 = phoneInput2.getNumber();
            $("#phone2").val(number2);
        });
    </script>
    <script>
        @if ($errors->any())
            setTimeout(function() {
                $("#notif").fadeOut();
            }, 4000)
        @endif
    </script> --}}
    <livewire:scripts />

</body>

</html>
