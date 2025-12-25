@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">आरक्षण अनुसार प्रतिवेदन</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">आरक्षण अनुसार प्रतिवेदन</li>
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
                    <h4 class="card-title mb-4">आरक्षण प्रकार र शैक्षिक सत्र छान्नुहोस्</h4>

                    <form method="GET" action="{{ route('reports.aarakshyan-reports.index') }}">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-floating mb-3">
                                    <select name="academic_year_id" class="form-select" required>
                                        <option value="">शैक्षिक सत्र छान्नुहोस्</option>
                                        @foreach($academicYears as $academicYear)
                                            <option value="{{ $academicYear->id }}"
                                                {{ request('academic_year_id') == $academicYear->id ? 'selected' : '' }}>
                                                {{ $academicYear->academic_year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>शैक्षिक सत्र <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-floating mb-3">
                                    <select name="aarakshya_main_id" class="form-select" required>
                                        <option value="">आरक्षण प्रकार छान्नुहोस्</option>
                                        @foreach($aarakshyaMains as $aarakshyaMain)
                                            <option value="{{ $aarakshyaMain->id }}"
                                                {{ request('aarakshya_main_id') == $aarakshyaMain->id ? 'selected' : '' }}>
                                                {{ $aarakshyaMain->title }} ({{ $aarakshyaMain->percentage }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>आरक्षण प्रकार <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-search-alt"></i> प्रतिवेदन हेर्नुहोस्
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($schools)
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $selectedAcademicYear->academic_year }} - {{ $selectedAarakshyaMain->title }} - विद्यालयहरूको प्रतिवेदन
                    </h4>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">क्रम</th>
                                    <th width="12%">EMIS नं.</th>
                                    <th width="30%">विद्यालयको नाम</th>
                                    <th width="15%">ठेगाना</th>
                                    <th width="10%">वडा</th>
                                    <th width="10%">कुल विद्यार्थी</th>
                                    <th width="10%">छात्रवृत्ति संख्या</th>
                                    <th width="8%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalSchoolStudents = 0;
                                    $totalAarakshyanStudents = 0;
                                @endphp
                                @foreach($schools as $sn => $school)
                                    @php
                                        $totalSchoolStudents += $school->total_students;
                                        $totalAarakshyanStudents += $school->aarakshyan_student_count;
                                    @endphp
                                    <tr>
                                        <td>{{ ++$sn }}</td>
                                        <td>{{ $school->school->emis_no }}</td>
                                        <td>
                                            <a href="{{ route('reports.aarakshyan-reports.students', ['school_year_id' => $school->id, 'aarakshya_main_id' => $selectedAarakshyaMain->id]) }}"
                                               class="text-primary fw-bold">
                                                {{ $school->school->school_name }}
                                            </a>
                                        </td>
                                        <td>{{ $school->school->address }}</td>
                                        <td>{{ $school->school->ward->ward }}</td>
                                        <td>{{ number_format($school->total_students) }}</td>
                                        <td>{{ number_format($school->aarakshyan_student_count) }}</td>
                                        <td>
                                            <a href="{{ route('reports.aarakshyan-reports.students', ['school_year_id' => $school->id, 'aarakshya_main_id' => $selectedAarakshyaMain->id]) }}"
                                               class="btn btn-sm btn-primary">
                                                <i class="bx bx-detail"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-active fw-bold">
                                    <td colspan="5" class="text-end">जम्मा:</td>
                                    <td>{{ number_format($totalSchoolStudents) }}</td>
                                    <td>{{ number_format($totalAarakshyanStudents) }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
