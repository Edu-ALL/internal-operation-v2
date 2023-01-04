@extends('layout.main')

@section('title', 'Parent - Bigdata Platform')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="{{ route('parent.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-2"></i> Parent
        </a>
    </div>


    <div class="card">
        <div class="card-header">
            <h5 class="my-1 p-0">
                <i class="bi bi-info-circle me-1"></i>
                Parents Detail
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($parent) ? route('parent.update', ['parent' => $parent->id]) : route('parent.store') }}" method="post">
                @csrf
                @if (isset($parent))
                    @method('PUT')
                @endif
                <div class="row align-items-center">
                    <div class="col-4 text-center">
                        <img src="{{ asset('img/parent.jpeg') }}" class="w-50">
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>First Name <i class="text-danger font-weight-bold">*</i>
                                    </label>
                                    <input name="pr_firstname" type="text" class="form-control form-control-sm"
                                        placeholder="First name" value="{{ isset($parent->first_name) ? $parent->first_name : old('first_name') }}">
                                    @error('pr_firstname')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>Last Name</label>
                                    <input name="pr_lastname" type="text" class="form-control form-control-sm"
                                        placeholder="Last name" value="{{ isset($parent->last_name) ? $parent->last_name : old('last_name') }}">
                                    @error('pr_lastname')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>E-mail <i class="text-danger font-weight-bold">*</i></label>
                                    <input name="pr_mail" type="text" class="form-control form-control-sm"
                                        placeholder="E-mail" value="{{ isset($parent->mail) ? $parent->mail : old('mail') }}">
                                    @error('pr_mail')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>Phone Number <i class="text-danger font-weight-bold">*</i></label>
                                    <input name="pr_phone" type="text" class="form-control form-control-sm"
                                        placeholder="Phone Number" value="{{ isset($parent->phone) ? $parent->phone : old('phone') }}">
                                    @error('pr_phone')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>Date of Birth <i class="text-danger font-weight-bold">*</i></label>
                                    <input name="pr_dob" type="date" class="form-control form-control-sm" value="{{ isset($parent->dob) ? $parent->dob : old('dob') }}">
                                    @error('pr_dob')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>Instagram</label>
                                    <input name="pr_insta" type="text" class="form-control form-control-sm"
                                        placeholder="Instagram" value="{{ isset($parent->insta) ? $parent->insta : old('insta') }}">
                                    @error('pr_insta')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label>State / Region <i class="text-danger font-weight-bold">*</i></label>
                                    <input name="state" type="text" class="form-control form-control-sm"
                                        placeholder="State / Region" id="state" value="{{ isset($parent->state) ? $parent->state : old('state') }}{{ isset($student->state) ? $student->state : null }}">
                                    @error('pr_state')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label>City</label>
                                    <input name="city" type="text" class="form-control form-control-sm"
                                        placeholder="City" id="city" value="{{ isset($parent->city) ? $parent->city : old('city') }}{{ isset($student->city) ? $student->city : null }}">
                                    @error('pr_city')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label>Postal Code</label>
                                    <input name="postal_code" type="text" class="form-control form-control-sm"
                                        placeholder="Postal Code" value="{{ isset($parent->postal_code) ? $parent->postal_code : old('postal_code') }}{{ isset($student->postal_code) ? $student->postal_code : null }}">
                                    @error('pr_postal_code')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label>Address</label>
                            <textarea name="address" class="form-control form-control-sm" placeholder="Address" rows="5">{{ isset($parent->address) ? $parent->address : old('address') }}{{ isset($student->address) ? $student->address : null }}</textarea>
                            @error('pr_address')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Lead  --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label>Lead Source <i class="text-danger font-weight-bold">*</i></label>
                            <select class="select w-100" id="leadSource" name="lead_id">
                                <option data-placeholder="true"></option>
                                @if (isset($leads) && count($leads) > 0)
                                @foreach ($leads as $lead)
                                    <option data-lead="{{ $lead->main_lead }}" value="{{ $lead->lead_id }}"
                                            {{ old('lead_id') == $lead->lead_id ? "selected" : null }}
                                            {{ isset($student->lead) && $student->lead->lead_id == $lead->lead_id ? "selected" : null }}
                                        >{{ $lead->main_lead }}</option>
                                @endforeach
                                {{-- <option value="program">ALL-in Event</option>
                                <option value="edufair">Edufair External</option> --}}
                                <option data-lead="KOL" value="kol" {{ old('lead_id') == "kol" ? "selected" : null }}>KOL</option>
                                @endif
                            </select>
                            @error('lead_id')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 program d-none">
                        <div class="mb-2">
                            <label>Event Name<i class="text-danger font-weight-bold">*</i>
                            </label>
                            <select class="select w-100" name="event_id">
                                <option data-placeholder="true"></option>
                                @if (isset($events) && count($events) > 0)
                                    @foreach ($events as $event)
                                        <option value="{{ $event->event_id }}"
                                            @if (isset($parent->event->event_id))
                                                {{ $parent->event->event_id == $event->event_id ? "selected" : null }}
                                            @else
                                                {{ old('event_id') == $event->event_id ? "selected" : null }}
                                            @endif
                                            >{{ $event->event_title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('event_id')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 edufair d-none">
                        <div class="mb-2">
                            <label>Edufair Name<i class="text-danger font-weight-bold">*</i>
                            </label>
                            <select class="select w-100" name="eduf_id">
                                <option data-placeholder="true"></option>
                                @if (isset($ext_edufair) && count($ext_edufair) > 0)
                                    @foreach ($ext_edufair as $edufair)
                                        <option value="{{ $edufair->id }}"
                                            @if (isset($teacher_counselor->external_edufair->id))
                                                {{ $teacher_counselor->external_edufair->id == $edufair->id ? "selected" : null }}
                                            @else
                                                {{ old('eduf_id') == $edufair->id ? "selected" : null }}
                                            @endif
                                            >{{ $edufair->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('eduf_id')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 kol d-none">
                        <div class="mb-2">
                            <label>KOL Name<i class="text-danger font-weight-bold">*</i>
                            </label>
                            <select class="select w-100" name="kol_lead_id">
                                <option data-placeholder="true"></option>
                                @if (isset($kols) && count($kols) > 0)
                                    @foreach ($kols as $kol)
                                        <option value="{{ $kol->lead_id }}"
                                            @if (isset($parent->lead_id) && $parent->lead_id == "LS017")
                                                {{ $parent->lead_id == $kol->lead_id ? "selected" : null }}
                                            @else
                                                {{ old('kol_lead_id') == $kol->lead_id ? "selected" : null }}
                                            @endif
                                            >{{ $kol->sub_lead }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('kol_lead_id')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-2">
                            <label>Level of Interest <i class="text-danger font-weight-bold">*</i></label>
                            <select class="select w-100" id="levelInterest" name="st_levelinterest">
                                <option data-placeholder="true"></option>
                                <option value="High" 
                                    @if (isset($parent->st_levelinterest))
                                        {{ $parent->st_levelinterest == "High" ? "selected" : null }}
                                    @elseif (isset($student->st_levelinterest))
                                        {{ $student->st_levelinterest == "High" ? "selected" : null }}
                                    @else
                                        {{ old('st_levelinterest') == "High" ? "selected" : null }}
                                    @endif
                                    >High</option>
                                <option value="Medium" 
                                    @if (isset($parent->st_levelinterest))
                                        {{ $parent->st_levelinterest == "Medium" ? "selected" : null }}
                                    @elseif (isset($student->st_levelinterest))
                                        {{ $student->st_levelinterest == "Medium" ? "selected" : null }}
                                    @else
                                        {{ old('st_levelinterest') == "Medium" ? "selected" : null }}
                                    @endif
                                    >Medium</option>
                                <option value="Low" 
                                    @if (isset($parent->st_levelinterest))
                                        {{ $parent->st_levelinterest == "Low" ? "selected" : null }}
                                    @elseif (isset($student->st_levelinterest))
                                        {{ $student->st_levelinterest == "Low" ? "selected" : null }}
                                    @else
                                    {{ old('st_levelinterest') == "Low" ? "selected" : null }}
                                    @endif
                                    >Low</option>
                            </select>
                            @error('st_levelinterest')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label>Interested Program</label>
                            <select class="select w-100" id="interestedProgram" name="prog_id[]" multiple>
                                <option data-placeholder="true"></option>
                                @if (isset($programs))
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->prog_id }}"
                                                {{ old('prog_id') == $program->prog_id ? "selected" : null }}
                                                {{ isset($student->interestPrograms) && in_array($program->prog_id, $student->interestPrograms()->pluck('tbl_interest_prog.prog_id')->toArray()) ? "selected" : null }}
                                            >{{ $program->prog_program }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('prog_id')
                                <small class="text-danger fw-light">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card my-3">
                    <div class="card-header">
                        <h6 class="my-1 p-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Mentee Detail
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Childs  --}}
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label>Children's Name</label>
                                    <select class="select w-100" name="child_id[]" id="chName" multiple
                                        onchange="addChildren()">
                                        <option data-placeholder="true"></option>
                                        @if (isset($childrens))
                                            @foreach ($childrens as $children)
                                                <option value="{{ $children->id }}"
                                                        {{ isset($student) && $student->id == $children->id ? "selected" : null }}
                                                        {{ old('child_id') == $children->id ? "selected" : null }}
                                                    >{{ $children->first_name.' '.$children->last_name }}</option>
                                            @endforeach
                                        @endif
                                        {{-- <option value="add-new" {{ old('child_id') == "add-new" ? "selected" : null }}>Add New Children</option> --}}
                                    </select>
                                    @error('pr_id')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="row children d-none align-items-start">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <small>First Name <i class="text-danger font-weight-bold">*</i></small>
                                                <input name="first_name" type="text" class="form-control form-control-sm"
                                                    placeholder="First name" value="{{ old('first_name') }}">
                                                @error('first_name')
                                                    <small class="text-danger fw-light">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small>Last Name </small>
                                                <input name="last_name" type="text" class="form-control form-control-sm"
                                                    placeholder="Last name" value="{{ old('last_name') }}">
                                                @error('last_name')
                                                    <small class="text-danger fw-light">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small>E-mail <i class="text-danger font-weight-bold">*</i></small>
                                                <input name="mail" type="text" class="form-control form-control-sm"
                                                    placeholder="E-mail" value="{{ old('mail') }}">
                                                @error('mail')
                                                    <small class="text-danger fw-light">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small>Phone Number <i class="text-danger font-weight-bold">*</i></small>
                                                <input name="phone" type="text" class="form-control form-control-sm"
                                                    placeholder="Phone Number" value="{{ old('phone') }}">
                                                @error('phone')
                                                    <small class="text-danger fw-light">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- School  --}}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>School Name <i class="text-danger font-weight-bold">*</i></label>
                                                    <select class="select w-100" id="schoolName" name="sch_id" onChange="addSchool();">
                                                        <option data-placeholder="true"></option>
                                                        @if (isset($schools) && count($schools) > 0)
                                                            @foreach ($schools as $school)
                                                                <option value="{{ $school->sch_id }}"
                                                                        {{ old('sch_id') == $school->sch_id ? "selected" : null }}
                                                                    >{{ $school->sch_name }}</option>
                                                            @endforeach
                                                        @endif
                                                        <option value="add-new" {{ old('sch_id') == "add-new" ? "selected" : null }}>Add New School</option>
                                                    </select>
                                                    @error('sch_id')
                                                        <small class="text-danger fw-light">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 school d-none">
                                                <div class="mb-2">
                                                    <label>Other School Name <i class="text-danger font-weight-bold">*</i></label>
                                                    <input name="sch_name" type="text" class="form-control form-control-sm"
                                                        placeholder="Other School Name" autofocus value="{{ old('sch_name') }}">
                                                    @error('sch_name')
                                                        <small class="text-danger fw-light">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 school d-none">
                                                <div class="mb-2">
                                                    <label>School Type <i class="text-danger font-weight-bold">*</i></label>
                                                    <select class="select w-100" name="sch_type">
                                                        <option data-placeholder="true"></option>
                                                        <option value="International" {{ old('sch_type') == "International" ? "selected" : null }}>International</option>
                                                        <option value="National" {{ old('sch_type') == "National" ? "selected" : null }}>National</option>
                                                    </select>
                                                    @error('sch_type')
                                                        <small class="text-danger fw-light">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-8 school d-none">
                                                <div class="mb-2">
                                                    <label>Curriculum <i class="text-danger font-weight-bold">*</i></label>
                                                    <select class="select w-100" name="sch_curriculum[]" multiple id="schCurriculum">
                                                        <option data-placeholder="true"></option>
                                                        @foreach ($curriculums as $curriculum)
                                                            <option value="{{ $curriculum->id }}" 
                                                                    {{ old('sch_curriculum') == $curriculum->name ? "selected" : null }}
                                                                >{{ $curriculum->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('sch_curriculum')
                                                        <small class="text-danger fw-light">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 school d-none">
                                                <div class="mb-2">
                                                    <label>School Market <i class="text-danger font-weight-bold">*</i>                             </label>
                                                    <select class="select w-100" name="sch_score">
                                                        <option data-placeholder="true"></option>
                                                        <option value="2" {{ old('sch_score') == 2 ? "selected" : null }}>Low Market</option>
                                                        <option value="4" {{ old('sch_score') == 4 ? "selected" : null }}>Mid Market</option>
                                                        <option value="5" {{ old('sch_score') == 5 ? "selected" : null }}>Up Market</option>
                                                    </select>
                                                    @error('sch_score')
                                                        <small class="text-danger fw-light">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4" id="studentYear">
                                                <div class="mb-2">
                                                    <label>Student Grade <i class="text-danger font-weight-bold">*</i></label>
                                                    <select class="select w-100" id="grade" name="st_grade">
                                                        <option data-placeholder="true"></option>
                                                        @for ($grade = 1 ; $grade <= 12 ; $grade++)
                                                            <option value="{{ $grade }}"
                                                                    {{ old('st_grade') == $grade ? "selected" : null }}
                                                            >{{ $grade }}</option>
                                                        @endfor
                                                        <option value="13"
                                                                {{ old('st_grade') == 13 ? "selected" : null }}
                                                                >Not High School</option>
                                                            
                                                    </select>
                                                    @error('st_grade')
                                                        <small class="text-danger fw-light">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4" id="studentYear">
                                                <div class="mb-2">
                                                    <label>Graduation Year</label>
                                                    <select class="select w-100" id="graduation_year" name="graduation_year">
                                                        <option data-placeholder="true"></option>
                                                        @for ($year = date('Y')+1 ; $year >= 1998 ; $year--)
                                                            <option value="{{ $year }}"
                                                                    {{ old('graduation_year') == $year ? "selected" : null }}
                                                            >{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                    @error('graduation_year')
                                                        <small class="text-danger fw-light">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <img src="{{ asset('img/mentee.jpg') }}" alt="" class="w-50">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="children d-none line" style="margin-top:15px; margin-bottom:0px;"></div>
                        <small class="children d-none text-info font-weight-bold">Study Abroad</small>

                        <div class="row children d-none mt-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>Year of Going Study Abroad</label>
                                    <select class="select w-100" id="year" name="st_abryear">
                                        <option data-placeholder="true"></option>
                                        @for ($year = date('Y') ; $year <= date('Y')+5 ; $year++)
                                            <option value="{{ $year }}"
                                                {{ old('st_abryear') == $year ? "selected" : null }}
                                            >{{ $year }}</option>
                                        @endfor
                                    </select>
                                    @error('st_abryear')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>Country</label>
                                    <select class="select w-100" id="countryStudy" name="st_abrcountry[]" multiple>
                                        <option data-placeholder="true"></option>
                                        @if (isset($countries))
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('st_abrcountry')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>University Destination</label>
                                    <label for="" id=test></label>
                                    <select class="select w-100" id="univDestination" name="st_abruniv[]" multiple>
                                        <option data-placeholder="true"></option>
                                    </select>
                                    @error('st_abruniv')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>Major</label>
                                    <select class="select w-100" id="major" name="st_abrmajor[]" multiple>
                                        <option data-placeholder="true"></option>
                                        @if (isset($majors))
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}"
                                                            {{ old('st_abrmajor') == $major->id ? "selected" : null }}
                                                    >{{ $major->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('st_abrmajor')
                                        <small class="text-danger fw-light">{{ $message }}</small>
                                    @enderror

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="line" style="margin-top:15px; margin-bottom:15px;"></div>
                <div class="row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="bis bi-save2"></i>&nbsp;
                            Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addChildren() {
            var p = $('#chName').val();

            if (p == 'add-new') {
                $(".children").removeClass("d-none");
            } else {
                $(".children").addClass("d-none");
            }
        }

        function addSchool() {
            var s = $('#schoolName').val();

            if (s == 'add-new') {
                $(".school").removeClass("d-none");
            } else {
                $(".school").addClass("d-none");
            }
        }

        $("#leadSource").on('change', function() {
            var lead = $(this).select2().find(":selected").data('lead')
            if (lead.includes('All-In Event')) {

                $(".program").removeClass("d-none")
                $(".edufair").addClass("d-none")
                $(".kol").addClass("d-none")

            } else if (lead.includes('External Edufair')) {

                $(".program").addClass("d-none")
                $(".edufair").removeClass("d-none")
                $(".kol").addClass("d-none")

            } else  if (lead.includes('KOL')) {

                $(".program").addClass("d-none")
                $(".edufair").addClass("d-none")
                $(".kol").removeClass("d-none")

            }
        })

        $("#grade").on('change', async function() {

            var grade = $(this).val()
            var html = ''
            $("#graduation_year").html('')
            var current_year = new Date().getFullYear()

            if (grade == 13) {
                
                for (var i = current_year ; i > 2009 ; i--) {
                    
                    html += "<option value='"+i+"'>"+i+"</option>"
                }

            } else {
                
                var max = 13
                var min = 1
                for (var i = current_year ; i <= current_year+(max-grade) ; i++) {

                    html += "<option value='"+i+"'>"+i+"</option>"
                }

            }

            $("#graduation_year").append(html)

        })

        const anotherDocument = () => {
            @if (isset($parent->childrens))
                var st_abruniv = new Array();
                @foreach ($parent->childrens()->first()->interestUniversities as $university)
                    st_abruniv.push("{{ $university->univ_id }}")
                @endforeach

                $("#univDestination").select2().val(st_abruniv).trigger('change')
            @elseif (!empty(old('st_abruniv')) && count(old('st_abruniv')) > 0)

                var st_abruniv = new Array();
                @foreach (old('st_abruniv') as $key => $val)
                    st_abruniv.push("{{ $val }}")
                @endforeach

                $("#univDestination").select2().val(st_abruniv).trigger('change')

            @endif
        }

        $("#countryStudy").on('change', async function() {
            var countries = $(this).val()
            if (countries.length == 0) {
                $("#univDestination").html('')
                return
            }

            var get = ""

            countries.forEach(function(currentValue, index, arr) {
                if (index == 0)
                    get += "?country[]=" + currentValue
                else
                    get += "&country[]=" + currentValue
            })

            // reset univ Destination html
            $("#univDestination").html('');

            var html = ""
            var link = "{{ route('student.create') }}" + get
            Swal.showLoading()
            await axios.get(link)
                .then(function(response) {
                    // handle success
                    let data = response.data
                    data.forEach(function(currentValue, index, arr) {
                        html += "<option value='"+arr[index].univ_id+"'>"+arr[index].univ_name+" - "+arr[index].univ_country+"</option>"
                    })
                    
                    $("#univDestination").append(html)
                    initSelect2("#univDestination")
                    Swal.close()
                })
                .catch(function(error) {
                    // handle error
                    Swal.close()
                    notification(error.response.data.success, error.response.data.message)
                })
            
            anotherDocument()
            
        })

        $(document).ready(function() {

            const documentReady = () => {

                @if (old('st_grade') !== NULL)
                    $("#grade").select2().val("{{ old('st_grade') }}").trigger('change')

                    @if (old('graduation_year') !== NULL)
                    $("#graduation_year").select2().val("{{ old('graduation_year') }}").trigger('change')
                    @endif
                @endif

                @if (old('child_id') !== NULL && old('child_id') == "add-new")
                    $("#chName").select2().val("{{ old('child_id') }}").trigger('change')
                @elseif (old('child_id') !== NULL )
                    $("#chName").select2().val("{{ old('child_id') }}").trigger('change')
                @endif

                @if (isset($parent->childrens))
                    var child_id = new Array()
                    @foreach ($parent->childrens as $children)
                        child_id.push("{{ $children->id }}")
                    @endforeach

                    $("#chName").val(child_id).trigger('change')

                @elseif (old('child_id') !== NULL)

                    var child_id = new Array()
                    @foreach (old('child_id') as $key => $val)
                        child_id.push("{{ $val }}")
                    @endforeach

                    $("#chName").val(child_id).trigger('change')
                @endif

                @if (old('sch_id') !== NULL && old('sch_id') == "add-new")
                    $("#schoolName").select2().val("{{ old('sch_id') }}").trigger('change')

                    @if (!empty(old('sch_curriculum')) && count(old('sch_curriculum')) > 0)
                        var sch_curriculum = new Array();
                        @foreach (old('sch_curriculum') as $key => $val)
                            sch_curriculum.push("{{ $val }}")
                        @endforeach

                        $("#schCurriculum").val(sch_curriculum).trigger('change')
                    @endif
                @endif

                @if (isset($parent->childrens))
                    $("#year").select2().val("{{ $parent->childrens()->first()->st_abryear }}").trigger('change')
                @elseif (old('st_abryear') !== NULL)
                    $("#year").select2().val("{{ old('st_abryear') }}").trigger('change')
                @endif
                
                @if (isset($parent->childrens))
                    var st_abrcountry = new Array();
                    @foreach ($parent->childrens()->first()->destinationCountries as $country)
                        st_abrcountry.push("{{ $country->id }}")
                    @endforeach

                    $("#countryStudy").val(st_abrcountry).trigger('change')

                @elseif (!empty(old('st_abrcountry')) && count(old('st_abrcountry')) > 0)
                    var st_abrcountry = new Array();
                    @foreach (old('st_abrcountry') as $key => $val)
                        st_abrcountry.push("{{ $val }}")
                    @endforeach

                    $("#countryStudy").val(st_abrcountry).trigger('change')

                @endif

                @if (isset($parent->childrens))
                    var st_abrmajor = new Array()
                    @foreach ($parent->childrens()->first()->interestMajor as $major)
                        st_abrmajor.push("{{ $major->id }}")
                    @endforeach

                    $("#major").val(st_abrmajor).trigger('change')

                @elseif (!empty(old('st_abrmajor')) && count(old('st_abrmajor')) > 0)

                    var st_abrmajor = new Array()
                    @foreach (old('st_abrmajor') as $key => $val)
                        st_abrmajor.push("{{ $val }}")
                    @endforeach

                    $("#major").val(st_abrmajor).trigger('change')
                @endif

                @if (isset($parent->interestPrograms))
                    var prog_id = new Array();
                    @foreach ($parent->interestPrograms as $program)
                        prog_id.push("{{ $program->prog_id }}")
                    @endforeach
                    
                    $("#interestedProgram").val(prog_id).trigger('change')

                @elseif (old('prog_id') !== NULL && count(old('prog_id')) > 0)
                    var prog_id = new Array();
                    @foreach (old('prog_id') as $key => $val)
                        prog_id.push("{{ $val }}")
                    @endforeach

                    $("#interestedProgram").val(prog_id).trigger('change')
                    anotherDocument()
                @endif

                @if (isset($parent->lead_id))
                    @if ($parent->lead_id == "LS017")
                        $("#leadSource").select2().val("kol").trigger('change')
                    @else
                        $("#leadSource").select2().val("{{ $parent->lead_id }}").trigger('change')
                    @endif
                @elseif (old('lead_id') !== NULL)
                    $("#leadSource").select2().val("{{ old('lead_id') }}").trigger('change')
                @endif
            }

            documentReady()
        })
    </script>

@endsection
