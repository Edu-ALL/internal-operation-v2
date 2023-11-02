@php
    $image = isset($event->event_banner) ? asset('storage/uploaded_file/events/' . $event->event_banner) : 'https://picsum.photos/900/200';
@endphp

<div class="min-h-screen flex items-center {{ request()->get('form_type') == 'cta' ? 'bg-form' : 'bg-transparent' }}">
    <div class="max-w-screen-lg w-full mx-auto p-4 relative overflow-hidden">
        @if (request()->get('form_type') == 'cta')
            <div class="w-full flex justify-center my-4">
                <img src="{{ asset('img/logo.png') }}" alt="Form ALL-in Event" class="w-[150px]">
            </div>

            <div class="h-[200px] overflow-hidden mb-2 rounded-lg shadow banner">
                <img src="{{ $image }}" alt="Form ALL-in Event"
                    class="w-full object-cover hover:scale-[1.05] ease-in-out duration-500">
            </div>
        @endif

        {{-- @if ($errors->any())
            <div class="fixed bottom-5 right-5 w-[350px] z-[999]" id="notif">
                <ul class="grid grid-cols-1 gap-2">
                    <li class="p-2 border-2 border-red-800 rounded-lg text-red-800 bg-white">Registration failed. Please
                        fill your data</li>
                </ul>
            </div>
        @endif --}}

        <form wire:submit.prevent="save" id="form-events">
            @csrf
            <input type="text" wire:model="current_page" id="crPage" value="role">
            {{-- Event Name  --}}
            <input type="hidden" name="event_name" value="{{ request()->get('event_name') ? request()->get('event_name') : '' }}">
            {{-- Attend Status  --}}
            <input type="hidden" name="attend_status" id=""
                value="{{ request()->get('attend_status') == 'attend' ? 'attend' : 'join' }}">
            {{-- Event Type  --}}
            <input type="hidden" name="event_type" id=""
                value="{{ request()->get('event_type') == 'offline' ? 'offline' : '' }}">
            {{-- Status  --}}
            <input type="hidden" name="status" id=""
                value="{{ request()->get('status') == 'ots' ? 'ots' : '' }}">
            {{-- Referral  --}}
            <input type="hidden" name="referral" id=""
                value="{{ request()->get('ref') ? request()->get('ref') : '' }}">
            {{-- Notes VIP / VVIP --}}
            <input type="hidden" name="client_type" value="{{ request()->get('type') ?? '' }}">

            <input type="hidden" wire:model="index" id="index">
            <section id="role" class="page step-active">
                <div
                    class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <h2 class="mb-2 md:text-3xl text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Let us know you better by filling out this form!
                    </h2>
                    <hr class="my-5">

                    <p class="mb-3 font-normal md:text-xl text-md text-gray-700 dark:text-gray-400">
                        You are a
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-4">
                        <div class="flex select-box">
                            <input checked id="role-1" type="radio" value="parent" name="role"
                                class="hidden peer" onchange="checkRole(this)">
                            <label for="role-1"
                                class="flex items-center justify-center w-full md:py-4 py-2 border rounded-lg border-1 border-[#bbbbbb] text-md font-medium text-gray-900 cursor-pointer dark:text-gray-300 transition-all duration-700 peer-checked:bg-[#cccccc] dark:peer-checked:text-[#999]">
                                <div class="text-center">
                                    <div class="flex justify-center">

                                        <img src="{{ asset('img/form-embed/parent.webp') }}" alt="Student"
                                            class="md:w-[70px] w-[40px]">
                                    </div>
                                    Parent
                                </div>
                            </label>
                        </div>
                        <div class="flex select-box">
                            <input id="role-2" type="radio" value="student" name="role" class="hidden peer"
                                onchange="checkRole(this)">
                            <label for="role-2"
                                class="flex items-center justify-center w-full md:py-4 py-2 border rounded-lg border-1 border-[#bbbbbb] text-md font-medium text-gray-900 cursor-pointer dark:text-gray-300 transition-all duration-700 peer-checked:bg-[#cccccc] dark:peer-checked:text-[#999]">
                                <div class="text-center">
                                    <div class="flex justify-center">

                                        <img src="{{ asset('img/form-embed/student.webp') }}" alt="Parent"
                                            class="md:w-[70px] w-[40px]">

                                    </div>
                                    Student
                                </div>
                            </label>
                        </div>
                        <div class="flex select-box">
                            <input id="role-3" type="radio" value="teacher/counsellor" name="role"
                                class="hidden peer" onchange="checkRole(this)">
                            <label for="role-3"
                                class="flex items-center justify-center w-full md:py-4 py-2 border rounded-lg border-1 border-[#bbbbbb] text-md font-medium text-gray-900 cursor-pointer dark:text-gray-300 transition-all duration-700 peer-checked:bg-[#cccccc] dark:peer-checked:text-[#999]">
                                <div class="flex flex-col items-center">
                                    <div class="flex justify-center">

                                        <img src="{{ asset('img/form-embed/teacher.webp') }}" alt="Parent"
                                            class="md:w-[70px] w-[40px]">

                                    </div>
                                    Teacher/Counsellor
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="step('role', 'user1','next')"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-blue-700 bg-white border-2 border-blue-700 rounded-lg hover:bg-blue-800 hover:text-white ease-in-out duration-500">
                            Next
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-right ml-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </section>


            <section id="user1" class="page step-inactive">
                <div
                    class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <h2 class="mb-2 md:text-2xl text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Please fill in your information
                    </h2>
                    <hr class="my-5">
                    <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                        <div class="col md:mb-4 mb-2 main-user">
                            <label
                                class="md:mb-3 mb-1 font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400">
                                Full Name <span class="text-red-400">*</span>
                            </label>
                            <input type="text" wire:model.blur="clientEvent.0.fullname"
                                class="w-full md:text-xl text-md border-0 border-b-2 focus:outline-0 focus:ring-0 px-0 required">
                            <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                            @error('clientEvent.0.fullname')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col md:mb-4 mb-2 main-user">
                            <label
                                class="md:mb-3 mb-1 font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400">
                                Email <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="email[]" value="{{ old('email.0') }}"
                                class="w-full md:text-xl text-md border-0 border-b-2 focus:outline-0 focus:ring-0 px-0 required">
                            <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                            @error('email.0')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col md:mb-4 mb-2 main-user">
                            <label class="font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400 block">
                                Phone Number <span class="text-red-400">*</span>
                            </label>
                            <input type="tel" name="phone[]" value="{{ old('phone.0') }}"
                                class="required w-full md:text-xl text-md border-0 border-b-2 focus:outline-0 focus:ring-0 px-0 mx-0"
                                id="phoneUser1">
                            <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                            @error('fullnumber.0')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                            <input type="hidden" name="fullnumber[]" id="phone1"
                                value="{{ old('fullnumber.0') }}">
                        </div>
                        <div class="col md:mb-4 mb-2 user-other">
                            <label
                                class="md:mb-3 mb-1 font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400">
                                Your <span class="role">Child's</span> Name <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="fullname[]" id="other_name" value="{{ old('fullname.1') }}"
                                class="w-full md:text-xl text-md border-0 border-b-2 focus:outline-0 focus:ring-0 px-0 child_info required">
                            <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                            @error('fullname.1')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col md:mb-4 mb-2 user-other">
                            <label
                                class="md:mb-3 mb-1 font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400">
                                Your <span class="role">Child's</span> Email
                                @if (request()->get('status') || request()->get('status') == 'ots')
                                    <span class="text-red-400">*</span>
                                @endif
                            </label>
                            <input type="text" name="email[]" id="other_email" value="{{ old('email.1') }}"
                                class="w-full md:text-xl text-md border-0 border-b-2 focus:outline-0 focus:ring-0 px-0 child_info">
                            <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                            @error('email.1')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col md:mb-4 mb-2 user-other">
                            <label class="font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400 block">
                                <span class="role">Child's</span> Number
                                @if (request()->get('status') || request()->get('status') == 'ots')
                                    <span class="text-red-400">*</span>
                                @endif
                            </label>
                            <input type="tel" name="phone[]" value="{{ old('phone.1') }}"
                                class="w-full md:text-xl text-md border-0 border-b-2 focus:outline-0 focus:ring-0 px-0 mx-0"
                                id="phoneUser2">
                            <input type="hidden" name="fullnumber[]" value="{{ old('fullnumber.1') }}"
                                id="phone2" class="child_info">
                            <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                            @error('fullnumber.1')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-between mt-10">
                        <button type="button" onclick="step('user1','role','prev')"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-red-700 bg-white border-2 border-red-700 rounded-lg hover:bg-red-700 hover:text-white ease-in-out duration-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-left mr-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="step('user1','info','next')"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-blue-700 bg-white border-2 border-blue-700 rounded-lg hover:bg-blue-800 hover:text-white ease-in-out duration-500">
                            Next
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-right ml-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </section>

            <section id="info" class="page step-inactive">
                <div
                    class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <h2 class="mb-2 md:text-3xl text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Please fill in your information
                    </h2>
                    <hr class="my-5">

                    <div class="mb-4" id="school_input">
                        <label class="md:mb-3 mb-1 font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400">
                            School <span class="text-red-400">*</span>
                        </label>
                        <select name="school" id="schoolList"
                            class="w-full md:text-xl text-md border-0 border-b-2 border-gray-500 focus:outline-0 focus:ring-0 px-0"
                            placeholder="Type your school name if your school is not on the list"
                            onChange="addSchool();">
                            <option data-placeholder="true"></option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->sch_id }}"
                                    {{ old('school') == $school->sch_id ? 'selected' : null }}>
                                    {{ $school->sch_name }}</option>
                            @endforeach
                        </select>
                        <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                        @error('school')
                            <small class="text-danger fw-light">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4" id="graduation_input">
                        <label class="md:mb-3 mb-1 font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400">
                            When do you expect to graduate? <span class="text-red-400">*</span>
                        </label>
                        <select name="graduation_year" id="graduation_year"
                            class="w-full md:text-xl text-md border-0 border-b-2 border-gray-500 focus:outline-0 focus:ring-0 px-0"
                            placeholder="">
                            <option value=""></option>
                            @for ($i = date('Y'); $i < date('Y') + 6; $i++)
                                <option value="{{ $i }}"
                                    {{ old('graduation_year') == $i ? 'selected' : null }}>{{ $i }}
                                </option>
                            @endfor
                        </select>
                        <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                        @error('graduation_year')
                            <small class="text-danger fw-light">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4" id="country_input">
                        <label class="md:mb-3 mb-1 font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400">
                            Destination Country
                        </label>
                        <select name="destination_country[]" multiple="multiple" id="destination_country"
                            class="w-full md:text-xl text-md border-0 border-b-2 border-gray-500 focus:outline-0 focus:ring-0 px-0"
                            placeholder="">
                            <option value=""></option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                        @error('destination_country')
                            <small class="text-danger fw-light">{{ $message }}</small>
                        @enderror
                    </div>
                    @if (request()->get('status') || request()->get('status') == 'ots')
                        <div class="mb-4">
                            <label class="mb-3 font-normal text-lg text-gray-700 dark:text-gray-400">
                                Number of Party <span class="text-red-400">*</span>
                            </label>
                            <input type="number" name="attend"
                                class="required w-full md:text-xl text-md border-0 border-b-2 focus:outline-0 focus:ring-0 px-0">
                            <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                            @error('attend')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    @endif

                    @if (!request()->get('ref') && request()->get('ref') === null)
                        <div class="mb-4">
                            <label
                                class="md:mb-3 mb-1 font-normal md:text-lg text-sm text-gray-700 dark:text-gray-400 block">
                                I know this event from <span class="text-red-400">*</span>
                            </label>
                            <small class="alert text-red-500 text-md hidden">Please fill in above field!</small>
                            <select name="leadsource" id="leadSource"
                                class="w-full md:text-xl text-md border-0 border-b-2 border-gray-500 focus:outline-0 focus:ring-0 px-0"
                                placeholder="Pick one item">
                                <option data-placeholder="true"></option>
                                @foreach ($leads as $lead)
                                    <option value="{{ $lead->lead_id }}"
                                        {{ old('leadsource') == $lead->lead_id ? 'selected' : null }}>
                                        {{ $lead->main_lead == 'KOL' ? $lead->sub_lead : $lead->main_lead }}
                                    </option>
                                @endforeach
                            </select>
                            @error('leadsource')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    @endif

                    <div class="flex justify-between mt-10">
                        <button type="button" onclick="step('info','user1','prev')"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-red-700 bg-white border-2 border-red-700 rounded-lg hover:bg-red-700 hover:text-white ease-in-out duration-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-left mr-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            Previous
                        </button>
                        <button type="submit" id="btn-submit"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-blue-700 bg-white border-2 border-blue-700 rounded-lg hover:bg-blue-800 hover:text-white ease-in-out duration-500">
                            Submit
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-right ml-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </section>
        </form>

        {{-- Footer  --}}
        @if (request()->get('form_type') == 'cta')
            <div class="w-full flex justify-center md:my-4 mt-[30px] text-sm text-center text-gray-400">
                Copyright © 2023. ALL-in Eduspace. <br> All rights reserved
            </div>
        @endif
    </div>
</div>


{{-- <form wire:submit="save">
    <input type="text" wire:model.live.debounce.500ms="clientEvent.0.fullname">
    <div>@error('clientEvent.0.fullname') {{ $message }} @enderror</div>
 
    <!-- -->
</form> --}}