@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">प्रयोगकर्ता सम्पादन</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">प्रयोगकर्ता प्रविष्टि</a></li>
                        <li class="breadcrumb-item active">प्रयोगकर्ता सम्पादन</li>
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
                                    <form action="{{ route('user.update', ['id' => $user->id, 'hash' => generate_hash($user)]) }}" method="POST">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="name" type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" value="{{ old('name', $user->name) }}" required
                                                        autocomplete="off" placeholder="पूरा नाम">
                                                    <label for="name">पूरा नाम <span class="text-danger">*</span></label>
                                                    @error('name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="email" type="text"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email', $user->email) }}" required
                                                        autocomplete="off" placeholder="प्रयोगकर्ता नाम">
                                                    <label for="email">प्रयोगकर्ता नाम <span class="text-danger">*</span></label>
                                                    @error('email')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password"
                                                        autocomplete="off" placeholder="पासवर्ड">
                                                    <label for="password">पासवर्ड (खाली छोड्नुहोस् यदि परिवर्तन गर्न चाहनुहुन्न भने)</label>
                                                    @error('password')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="password_confirmation" type="password"
                                                        class="form-control"
                                                        name="password_confirmation"
                                                        autocomplete="off" placeholder="पासवर्ड पुष्टि गर्नुहोस्">
                                                    <label for="password_confirmation">पासवर्ड पुष्टि गर्नुहोस्</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <select id="usertype" name="usertype"
                                                        class="form-select @error('usertype') is-invalid @enderror" required
                                                        onchange="toggleSchoolField(this.value)">
                                                        <option value="">प्रयोगकर्ता प्रकार छान्नुहोस्</option>
                                                        <option value="admin" {{ old('usertype', $user->usertype) == 'admin' ? 'selected' : '' }}>एडमिन</option>
                                                        <option value="office_user" {{ old('usertype', $user->usertype) == 'office_user' ? 'selected' : '' }}>कार्यालय प्रयोगकर्ता</option>
                                                        <option value="school_user" {{ old('usertype', $user->usertype) == 'school_user' ? 'selected' : '' }}>विद्यालय प्रयोगकर्ता</option>
                                                    </select>
                                                    <label for="usertype">प्रयोगकर्ता प्रकार <span class="text-danger">*</span></label>
                                                    @error('usertype')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3" id="schoolFieldDiv" style="display: {{ old('usertype', $user->usertype) == 'school_user' ? 'block' : 'none' }};">
                                                <div class="form-floating">
                                                    <select id="school_id" name="school_id"
                                                        class="form-select @error('school_id') is-invalid @enderror">
                                                        <option value="">विद्यालय छान्नुहोस्</option>
                                                        @foreach($schools as $school)
                                                            <option value="{{ $school->id }}"
                                                                {{ old('school_id', $user->school_id) == $school->id ? 'selected' : '' }}>
                                                                {{ $school->school_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="school_id">विद्यालय <span class="text-danger">*</span></label>
                                                    @error('school_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center mb-3">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                    Update </button>
                                                <a href="{{ route('user.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>
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

@section('scripts')
<script>
    function toggleSchoolField(usertype) {
        const schoolFieldDiv = document.getElementById('schoolFieldDiv');
        const schoolSelect = document.getElementById('school_id');

        if (usertype === 'school_user') {
            schoolFieldDiv.style.display = 'block';
            schoolSelect.setAttribute('required', 'required');
        } else {
            schoolFieldDiv.style.display = 'none';
            schoolSelect.removeAttribute('required');
            schoolSelect.value = '';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const usertypeSelect = document.getElementById('usertype');
        if (usertypeSelect.value) {
            toggleSchoolField(usertypeSelect.value);
        }
    });
</script>
@endsection
