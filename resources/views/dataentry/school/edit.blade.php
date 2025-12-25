@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">विद्यालय सम्पादन</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('school.index') }}">विद्यालय प्रविष्टि</a></li>
                        <li class="breadcrumb-item active">विद्यालय सम्पादन</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('school.update', ['id' => $school->id, 'hash' => generate_hash($school)]) }}" method="POST">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="emis_no" type="text"
                                                        class="form-control @error('emis_no') is-invalid @enderror"
                                                        name="emis_no" value="{{ old('emis_no', $school->emis_no) }}"
                                                        autocomplete="off" placeholder="EMIS नं.">
                                                    <label for="emis_no">EMIS नं.</label>
                                                    @error('emis_no')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="school_name" type="text"
                                                        class="form-control @error('school_name') is-invalid @enderror"
                                                        name="school_name" value="{{ old('school_name', $school->school_name) }}" required
                                                        autocomplete="off" placeholder="विद्यालयको नाम">
                                                    <label for="school_name">विद्यालयको नाम <span class="text-danger">*</span></label>
                                                    @error('school_name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="address" type="text"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        name="address" value="{{ old('address', $school->address) }}"
                                                        autocomplete="off" placeholder="ठेगाना">
                                                    <label for="address">ठेगाना</label>
                                                    @error('address')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="contact_no" type="text"
                                                        class="form-control @error('contact_no') is-invalid @enderror"
                                                        name="contact_no" value="{{ old('contact_no', $school->contact_no) }}"
                                                        autocomplete="off" placeholder="सम्पर्क नं.">
                                                    <label for="contact_no">सम्पर्क नं.</label>
                                                    @error('contact_no')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="contact_person" type="text"
                                                        class="form-control @error('contact_person') is-invalid @enderror"
                                                        name="contact_person" value="{{ old('contact_person', $school->contact_person) }}"
                                                        autocomplete="off" placeholder="सम्पर्क व्यक्ति">
                                                    <label for="contact_person">सम्पर्क व्यक्ति</label>
                                                    @error('contact_person')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email', $school->email) }}"
                                                        autocomplete="off" placeholder="इमेल">
                                                    <label for="email">इमेल</label>
                                                    @error('email')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <select id="ward_id" name="ward_id"
                                                        class="form-select @error('ward_id') is-invalid @enderror" required>
                                                        <option value="">वडा छान्नुहोस्</option>
                                                        @foreach($wards as $ward)
                                                            <option value="{{ $ward->id }}"
                                                                {{ old('ward_id', $school->ward_id) == $ward->id ? 'selected' : '' }}>
                                                                {{ $ward->ward }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="ward_id">वडा <span class="text-danger">*</span></label>
                                                    @error('ward_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <select id="school_type" name="school_type"
                                                        class="form-select @error('school_type') is-invalid @enderror" required>
                                                        <option value="">विद्यालय प्रकार छान्नुहोस्</option>
                                                        <option value="public" {{ old('school_type', $school->school_type) == 'public' ? 'selected' : '' }}>सार्वजनिक</option>
                                                        <option value="private" {{ old('school_type', $school->school_type) == 'private' ? 'selected' : '' }}>निजी</option>
                                                    </select>
                                                    <label for="school_type">विद्यालय प्रकार <span class="text-danger">*</span></label>
                                                    @error('school_type')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center mb-3">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                    Update </button>
                                                <a href="{{ route('school.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>
                                                    Back </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
