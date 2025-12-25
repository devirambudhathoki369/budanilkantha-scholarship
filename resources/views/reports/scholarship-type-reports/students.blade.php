@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">
                    {{ $schoolYear->school->school_name }} -
                    @if($scholarship_type == 'from_aarakshyan')
                        आरक्षणबाट
                    @else
                        परीक्षाबाट
                    @endif
                    छात्रवृत्ति - विद्यार्थी सूची
                </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.scholarship-type-reports.index') }}">छात्रवृत्ति प्रकार अनुसार प्रतिवेदन</a></li>
                        <li class="breadcrumb-item active">विद्यार्थी सूची</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">शैक्षिक सत्र</p>
                            <h5 class="mb-0">{{ $schoolYear->academicYear->academic_year }}</h5>
                        </div>
                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-calendar font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">छात्रवृत्ति प्रकार</p>
                            <h5 class="mb-0">
                                @if($scholarship_type == 'from_aarakshyan')
                                    आरक्षणबाट
                                @else
                                    परीक्षाबाट
                                @endif
                            </h5>
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
        <div class="col-md-4">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">कुल विद्यार्थी</p>
                            <h4 class="mb-0">{{ $students->count() }}</h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-info align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-info">
                                <i class="bx bx-user font-size-24"></i>
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

                    @if($scholarship_type == 'from_aarakshyan')
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('reports.scholarship-type-reports.students', ['school_year_id' => $schoolYear->id, 'scholarship_type' => $scholarship_type]) }}" class="row g-3">
                                <div class="col-md-6">
                                    <select name="aarakshya_main_id" class="form-select">
                                        <option value="">आरक्षण प्रकार छान्नुहोस्</option>
                                        @foreach($aarakshyaMains as $aarakshyaMain)
                                            <option value="{{ $aarakshyaMain->id }}" {{ request('aarakshya_main_id') == $aarakshyaMain->id ? 'selected' : '' }}>
                                                {{ $aarakshyaMain->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-search-alt"></i> फिल्टर गर्नुहोस्</button>
                                    <a href="{{ route('reports.scholarship-type-reports.students', ['school_year_id' => $schoolYear->id, 'scholarship_type' => $scholarship_type]) }}" class="btn btn-secondary"><i class="bx bx-reset"></i> रिसेट</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table align-middle table-bordered table-hover nowrap" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th width="3%">क्रम</th>
                                    <th width="15%">विद्यार्थीको नाम</th>
                                    <th width="10%">ठेगाना</th>
                                    <th width="10%">सम्पर्क नं.</th>
                                    <th width="8%">EMIS नं.</th>
                                    @if($scholarship_type == 'from_aarakshyan')
                                        <th width="12%">आरक्षण प्रकार</th>
                                    @else
                                        <th width="10%">विद्यालय प्रकार</th>
                                        <th width="8%">GPA</th>
                                        <th width="10%">प्रवेश परीक्षा</th>
                                        <th width="8%">कुल अंक</th>
                                        <th width="5%">रैंक</th>
                                    @endif
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
                                        @if($scholarship_type == 'from_aarakshyan')
                                            <td>
                                                <span class="badge bg-warning">
                                                    {{ $student->aarakshyaMain ? $student->aarakshyaMain->title : '-' }}
                                                </span>
                                            </td>
                                        @else
                                            <td>
                                                @if($student->school_type == 'public')
                                                    <span class="badge bg-success">सार्वजनिक</span>
                                                @else
                                                    <span class="badge bg-secondary">निजी</span>
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
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
