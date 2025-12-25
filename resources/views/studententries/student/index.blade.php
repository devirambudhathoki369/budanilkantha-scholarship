@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $schoolYear->school->school_name }} - {{ $schoolYear->academicYear->academic_year }} - विद्यार्थी सूची</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('schoollist.index') }}">विद्यालय सूची</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('schoolyear.index', $schoolYear->school_id) }}">शैक्षिक वर्ष</a></li>
                        <li class="breadcrumb-item active">विद्यार्थी सूची</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">कुल विद्यार्थी</p>
                            <h4 class="mb-0">{{ $schoolYear->total_students }}</h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-user font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">कुल छात्रवृत्ति</p>
                            <h4 class="mb-0">{{ $schoolYear->scholarship_no }}</h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-success align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-success">
                                <i class="bx bx-award font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">आरक्षणबाट ({{ $aarakshyanCount }}/{{ $schoolYear->scholarship_by_aarakshyan_no }})</p>
                            <h4 class="mb-0">{{ $schoolYear->scholarship_by_aarakshyan_no - $aarakshyanCount }} बाँकी</h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-warning align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-warning">
                                <i class="bx bx-group font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">परीक्षाबाट</p>
                            <h4 class="mb-0">{{ $examCount }}/{{ $schoolYear->scholarship_by_exam_no }}</h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-info align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-info">
                                <i class="bx bx-file font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-10">
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('student.index', $schoolYear->id) }}" class="row g-3">
                                <div class="col-md-4">
                                    <select name="scholarship_type" class="form-select">
                                        <option value="">छात्रवृत्ति प्रकार छान्नुहोस्</option>
                                        <option value="from_aarakshyan" {{ request('scholarship_type') == 'from_aarakshyan' ? 'selected' : '' }}>आरक्षणबाट</option>
                                        <option value="from_exam" {{ request('scholarship_type') == 'from_exam' ? 'selected' : '' }}>परीक्षाबाट</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="aarakshya_main_id" class="form-select">
                                        <option value="">आरक्षण प्रकार छान्नुहोस्</option>
                                        @foreach($aarakshyaMains as $aarakshyaMain)
                                            <option value="{{ $aarakshyaMain->id }}" {{ request('aarakshya_main_id') == $aarakshyaMain->id ? 'selected' : '' }}>
                                                {{ $aarakshyaMain->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-search-alt"></i> फिल्टर गर्नुहोस्</button>
                                    <a href="{{ route('student.index', $schoolYear->id) }}" class="btn btn-secondary"><i class="bx bx-reset"></i> रिसेट</a>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                <i class="fa fa-plus"></i> विद्यार्थी थप्नुहोस्
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-bordered table-hover nowrap" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th width="3%">क्रम</th>
                                    <th width="15%">विद्यार्थीको नाम</th>
                                    <th width="10%">ठेगाना</th>
                                    <th width="10%">सम्पर्क नं.</th>
                                    <th width="8%">EMIS नं.</th>
                                    <th width="10%">छात्रवृत्ति प्रकार</th>
                                    <th width="12%">आरक्षण/विद्यालय प्रकार</th>
                                    <th width="8%">GPA</th>
                                    <th width="8%">प्रवेश परीक्षा</th>
                                    <th width="8%">कुल अंक</th>
                                    <th width="5%">रैंक</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($students as $sn => $student)
                                    <tr>
                                        <td>{{ ++$sn }}</td>
                                        <td>{{ $student->student_name }}</td>
                                        <td>{{ $student->address }}</td>
                                        <td>{{ $student->contact_no }}</td>
                                        <td>{{ $student->emis_no }}</td>
                                        <td>
                                            @if($student->scholarship_type == 'from_aarakshyan')
                                                <span class="badge bg-warning">आरक्षणबाट</span>
                                            @else
                                                <span class="badge bg-info">परीक्षाबाट</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($student->scholarship_type == 'from_aarakshyan')
                                                {{ $student->aarakshyaMain ? $student->aarakshyaMain->title : '-' }}
                                            @else
                                                @if($student->school_type == 'public')
                                                    <span class="badge bg-success">सार्वजनिक</span>
                                                @else
                                                    <span class="badge bg-secondary">निजी</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $student->gpa ?? '-' }}</td>
                                        <td>{{ $student->entrance_exam_marks ?? '-' }}</td>
                                        <td>{{ $student->total_marks ? number_format($student->total_marks, 2) : '-' }}</td>
                                        <td>
                                            @if($student->rank)
                                                <span class="badge bg-primary">{{ $student->rank }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('student.edit', ['id' => $student->id, 'hash' => generate_hash($student)]) }}"
                                                class="btn btn-success btn-sm"><i class="bx bx-edit"></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a href="{{ route('student.delete', ['id' => $student->id, 'hash' => generate_hash($student)]) }}"
                                                onclick="return confirm('के तपाई यो डेटा हटाउन चाहनुहुन्छ?')"
                                                class="btn btn-xs btn-danger btn-sm" title="delete"><span><i
                                                        class="fa fa-trash"></i></span></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <!-- end table responsive -->
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">नयाँ विद्यार्थी थप्नुहोस्</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('student.store', $schoolYear->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="student_name" type="text"
                                        class="form-control @error('student_name') is-invalid @enderror"
                                        name="student_name" value="{{ old('student_name') }}" required
                                        autocomplete="off" placeholder="विद्यार्थीको नाम">
                                    <label for="student_name">विद्यार्थीको नाम <span class="text-danger">*</span></label>
                                    @error('student_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror"
                                        name="address" value="{{ old('address') }}"
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
                                        name="parent_name" value="{{ old('parent_name') }}"
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
                                        name="contact_no" value="{{ old('contact_no') }}"
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
                                        name="email" value="{{ old('email') }}"
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
                                        name="emis_no" value="{{ old('emis_no') }}"
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
                                        <option value="from_aarakshyan" {{ old('scholarship_type') == 'from_aarakshyan' ? 'selected' : '' }}>आरक्षणबाट</option>
                                        <option value="from_exam" {{ old('scholarship_type') == 'from_exam' ? 'selected' : '' }}>परीक्षाबाट</option>
                                    </select>
                                    <label for="scholarship_type">छात्रवृत्ति प्रकार <span class="text-danger">*</span></label>
                                    @error('scholarship_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Aarakshyan Fields -->
                            <div class="col-md-6 mb-3" id="aarakshyanFieldDiv" style="display: none;">
                                <div class="form-floating">
                                    <select id="aarakshya_main_id" name="aarakshya_main_id"
                                        class="form-select @error('aarakshya_main_id') is-invalid @enderror">
                                        <option value="">आरक्षण प्रकार छान्नुहोस्</option>
                                        @foreach($aarakshyaMains as $aarakshyaMain)
                                            <option value="{{ $aarakshyaMain->id }}" {{ old('aarakshya_main_id') == $aarakshyaMain->id ? 'selected' : '' }}>
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
                            <div class="col-md-6 mb-3" id="schoolTypeFieldDiv" style="display: none;">
                                <div class="form-floating">
                                    <select id="school_type" name="school_type"
                                        class="form-select @error('school_type') is-invalid @enderror">
                                        <option value="">विद्यालय प्रकार छान्नुहोस्</option>
                                        <option value="public" {{ old('school_type') == 'public' ? 'selected' : '' }}>सार्वजनिक (20 अंक)</option>
                                        <option value="private" {{ old('school_type') == 'private' ? 'selected' : '' }}>निजी (0 अंक)</option>
                                    </select>
                                    <label for="school_type">विद्यालय प्रकार <span class="text-danger">*</span></label>
                                    @error('school_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3" id="gpaFieldDiv" style="display: none;">
                                <div class="form-floating">
                                    <input id="gpa" type="number" step="0.01" min="0" max="4"
                                        class="form-control @error('gpa') is-invalid @enderror"
                                        name="gpa" value="{{ old('gpa') }}"
                                        autocomplete="off" placeholder="GPA">
                                    <label for="gpa">GPA <span class="text-danger">*</span></label>
                                    <small class="text-muted">4.0=20, 3.6-3.9=16, 3.2-3.5=12, 2.8-3.1=8, 2.4-2.7=6, 2.0-2.3=5</small>
                                    @error('gpa')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3" id="entranceExamFieldDiv" style="display: none;">
                                <div class="form-floating">
                                    <input id="entrance_exam_marks" type="number" min="0"
                                        class="form-control @error('entrance_exam_marks') is-invalid @enderror"
                                        name="entrance_exam_marks" value="{{ old('entrance_exam_marks') }}"
                                        autocomplete="off" placeholder="प्रवेश परीक्षा अंक">
                                    <label for="entrance_exam_marks">प्रवेश परीक्षा अंक (अधिकतम 60 मा रूपान्तरण हुनेछ) <span class="text-danger">*</span></label>
                                    @error('entrance_exam_marks')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> बन्द गर्नुहोस्
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

    // Re-open modal if there are validation errors
    @if ($errors->any())
        var addStudentModal = new bootstrap.Modal(document.getElementById('addStudentModal'));
        addStudentModal.show();

        const scholarshipTypeValue = document.getElementById('scholarship_type').value;
        if (scholarshipTypeValue) {
            toggleScholarshipFields(scholarshipTypeValue);
        }
    @endif
</script>
@endsection
