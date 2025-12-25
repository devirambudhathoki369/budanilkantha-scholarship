@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">विद्यार्थी सम्पादन</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('schoollist.index') }}">विद्यालय सूची</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('schoolyear.index', $schoolYear->school_id) }}">शैक्षिक वर्ष</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student.index', $schoolYear->id) }}">विद्यार्थी सूची</a></li>
                        <li class="breadcrumb-item active">सम्पादन</li>
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
                                    <form action="{{ route('student.update', ['id' => $student->id, 'hash' => generate_hash($student)]) }}" method="POST">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input id="student_name" type="text"
                                                        class="form-control @error('student_name') is-invalid @enderror"
                                                        name="student_name" value="{{ old('student_name', $student->student_name) }}" required
                                                        autocomplete="off" placeholder="विद्यार्थीको नाम">
                                                    <label for="student_name">विद्यार्थीको नाम <span class="text-danger">*</span></label>
                                                    @error('student_name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <select id="class_id" name="class_id"
                                                        class="form-select @error('class_id') is-invalid @enderror" required>
                                                        <option value="">कक्षा छान्नुहोस्</option>
                                                        @foreach($classes as $class)
                                                            <option value="{{ $class->id }}"
                                                                {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                                {{ $class->class }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="class_id">कक्षा <span class="text-danger">*</span></label>
                                                    @error('class_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input id="address" type="text"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        name="address" value="{{ old('address', $student->address) }}"
                                                        autocomplete="off" placeholder="ठेगाना">
                                                    <label for="address">ठेगाना</label>
                                                    @error('address')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="parent_name" type="text"
                                                        class="form-control @error('parent_name') is-invalid @enderror"
                                                        name="parent_name" value="{{ old('parent_name', $student->parent_name) }}"
                                                        autocomplete="off" placeholder="अभिभावकको नाम">
                                                    <label for="parent_name">अभिभावकको नाम</label>
                                                    @error('parent_name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="contact_no" type="text"
                                                        class="form-control @error('contact_no') is-invalid @enderror"
                                                        name="contact_no" value="{{ old('contact_no', $student->contact_no) }}"
                                                        autocomplete="off" placeholder="सम्पर्क नं.">
                                                    <label for="contact_no">सम्पर्क नं.</label>
                                                    @error('contact_no')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email', $student->email) }}"
                                                        autocomplete="off" placeholder="इमेल">
                                                    <label for="email">इमेल</label>
                                                    @error('email')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="emis_no" type="text"
                                                        class="form-control @error('emis_no') is-invalid @enderror"
                                                        name="emis_no" value="{{ old('emis_no', $student->emis_no) }}"
                                                        autocomplete="off" placeholder="EMIS नं.">
                                                    <label for="emis_no">EMIS नं.</label>
                                                    @error('emis_no')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <select id="scholarship_type" name="scholarship_type"
                                                        class="form-select @error('scholarship_type') is-invalid @enderror" required
                                                        onchange="toggleScholarshipFields(this.value)">
                                                        <option value="">छात्रवृत्ति प्रकार छान्नुहोस्</option>
                                                        <option value="from_aarakshyan" {{ old('scholarship_type', $student->scholarship_type) == 'from_aarakshyan' ? 'selected' : '' }}>आरक्षणबाट</option>
                                                        <option value="from_exam" {{ old('scholarship_type', $student->scholarship_type) == 'from_exam' ? 'selected' : '' }}>परीक्षाबाट</option>
                                                    </select>
                                                    <label for="scholarship_type">छात्रवृत्ति प्रकार <span class="text-danger">*</span></label>
                                                    @error('scholarship_type')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Aarakshyan Fields -->
                                            <div class="col-md-6 mb-3" id="aarakshyanFieldDiv" style="display: {{ old('scholarship_type', $student->scholarship_type) == 'from_aarakshyan' ? 'block' : 'none' }};">
                                                <div class="form-floating">
                                                    <select id="aarakshya_main_id" name="aarakshya_main_id"
                                                        class="form-select @error('aarakshya_main_id') is-invalid @enderror">
                                                        <option value="">आरक्षण प्रकार छान्नुहोस्</option>
                                                        @foreach($aarakshyaMains as $aarakshyaMain)
                                                            <option value="{{ $aarakshyaMain->id }}"
                                                                {{ old('aarakshya_main_id', $student->aarakshya_main_id) == $aarakshyaMain->id ? 'selected' : '' }}>
                                                                {{ $aarakshyaMain->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="aarakshya_main_id">आरक्षण प्रकार <span class="text-danger">*</span></label>
                                                    @error('aarakshya_main_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Exam Fields -->
                                            <div class="col-md-6 mb-3" id="schoolTypeFieldDiv" style="display: {{ old('scholarship_type', $student->scholarship_type) == 'from_exam' ? 'block' : 'none' }};">
                                                <div class="form-floating">
                                                    <select id="school_type" name="school_type"
                                                        class="form-select @error('school_type') is-invalid @enderror">
                                                        <option value="">विद्यालय प्रकार छान्नुहोस्</option>
                                                        <option value="public" {{ old('school_type', $student->school_type) == 'public' ? 'selected' : '' }}>सार्वजनिक (20 अंक)</option>
                                                        <option value="private" {{ old('school_type', $student->school_type) == 'private' ? 'selected' : '' }}>निजी (0 अंक)</option>
                                                    </select>
                                                    <label for="school_type">विद्यालय प्रकार <span class="text-danger">*</span></label>
                                                    @error('school_type')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3" id="gpaFieldDiv" style="display: {{ old('scholarship_type', $student->scholarship_type) == 'from_exam' ? 'block' : 'none' }};">
                                                <div class="form-floating">
                                                    <input id="gpa" type="number" step="0.01" min="0" max="4"
                                                        class="form-control @error('gpa') is-invalid @enderror"
                                                        name="gpa" value="{{ old('gpa', $student->gpa) }}"
                                                        autocomplete="off" placeholder="GPA">
                                                    <label for="gpa">GPA <span class="text-danger">*</span></label>
                                                    <small class="text-muted">4.0=20, 3.6-3.9=16, 3.2-3.5=12, 2.8-3.1=8, 2.4-2.7=6, 2.0-2.3=5</small>
                                                    @error('gpa')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3" id="entranceExamFieldDiv" style="display: {{ old('scholarship_type', $student->scholarship_type) == 'from_exam' ? 'block' : 'none' }};">
                                                <div class="form-floating">
                                                    <input id="entrance_exam_marks" type="number" min="0"
                                                        class="form-control @error('entrance_exam_marks') is-invalid @enderror"
                                                        name="entrance_exam_marks" value="{{ old('entrance_exam_marks', $student->entrance_exam_marks) }}"
                                                        autocomplete="off" placeholder="प्रवेश परीक्षा अंक">
                                                    <label for="entrance_exam_marks">प्रवेश परीक्षा अंक (अधिकतम 60 मा रूपान्तरण हुनेछ) <span class="text-danger">*</span></label>
                                                    @error('entrance_exam_marks')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center mb-3">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                    Update </button>
                                                <a href="{{ route('student.index', $student->school_year_id) }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>
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
    function toggleScholarshipFields(scholarshipType) {
        const aarakshyanDiv = document.getElementById('aarakshyanFieldDiv');
        const aarakshyanSelect = document.getElementById('aarakshya_main_id');
        const schoolTypeDiv = document.getElementById('schoolTypeFieldDiv');
        const schoolTypeSelect = document.getElementById('school_type');
        const gpaDiv = document.getElementById('gpaFieldDiv');
        const gpaInput = document.getElementById('gpa');
        const entranceExamDiv = document.getElementById('entranceExamFieldDiv');
        const entranceExamInput = document.getElementById('entrance_exam_marks');

        if (scholarshipType === 'from_aarakshyan') {
            aarakshyanDiv.style.display = 'block';
            aarakshyanSelect.setAttribute('required', 'required');

            schoolTypeDiv.style.display = 'none';
            schoolTypeSelect.removeAttribute('required');
            schoolTypeSelect.value = '';

            gpaDiv.style.display = 'none';
            gpaInput.removeAttribute('required');
            gpaInput.value = '';

            entranceExamDiv.style.display = 'none';
            entranceExamInput.removeAttribute('required');
            entranceExamInput.value = '';
        } else if (scholarshipType === 'from_exam') {
            aarakshyanDiv.style.display = 'none';
            aarakshyanSelect.removeAttribute('required');
            aarakshyanSelect.value = '';

            schoolTypeDiv.style.display = 'block';
            schoolTypeSelect.setAttribute('required', 'required');

            gpaDiv.style.display = 'block';
            gpaInput.setAttribute('required', 'required');

            entranceExamDiv.style.display = 'block';
            entranceExamInput.setAttribute('required', 'required');
        } else {
            aarakshyanDiv.style.display = 'none';
            aarakshyanSelect.removeAttribute('required');
            aarakshyanSelect.value = '';

            schoolTypeDiv.style.display = 'none';
            schoolTypeSelect.removeAttribute('required');
            schoolTypeSelect.value = '';

            gpaDiv.style.display = 'none';
            gpaInput.removeAttribute('required');
            gpaInput.value = '';

            entranceExamDiv.style.display = 'none';
            entranceExamInput.removeAttribute('required');
            entranceExamInput.value = '';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const scholarshipTypeSelect = document.getElementById('scholarship_type');
        if (scholarshipTypeSelect.value) {
            toggleScholarshipFields(scholarshipTypeSelect.value);
        }
    });
</script>
@endsection
