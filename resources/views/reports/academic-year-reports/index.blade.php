@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">शैक्षिक सत्रअनुसार प्रतिवेदन</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">शैक्षिक सत्रअनुसार प्रतिवेदन</li>
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
                    <h4 class="card-title mb-4">शैक्षिक सत्र छान्नुहोस्</h4>

                    <form method="GET" action="{{ route('reports.academic-year-reports.index') }}">
                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                        {{ $selectedAcademicYear->academic_year }} - विद्यालयहरूको प्रतिवेदन
                    </h4>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">क्रम</th>
                                    <th width="10%">EMIS नं.</th>
                                    <th width="25%">विद्यालयको नाम</th>
                                    <th width="10%">वडा</th>
                                    <th width="10%">कुल विद्यार्थी</th>
                                    <th width="12%">छात्रवृत्ति प्रदान</th>
                                    <th width="10%">परीक्षाबाट</th>
                                    <th width="10%">आरक्षणबाट</th>
                                    <th width="8%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalStudents = 0;
                                    $totalScholarships = 0;
                                    $totalByExam = 0;
                                    $totalByAarakshyan = 0;
                                @endphp
                                @foreach($schools as $sn => $school)
                                    @php
                                        $totalStudents += $school->total_students;
                                        $totalScholarships += $school->total_scholarships;
                                        $totalByExam += $school->by_exam;
                                        $totalByAarakshyan += $school->by_aarakshyan;
                                    @endphp
                                    <tr>
                                        <td>{{ ++$sn }}</td>
                                        <td>{{ $school->school->emis_no }}</td>
                                        <td>
                                            <a href="{{ route('reports.academic-year-reports.students', $school->id) }}"
                                               class="text-primary fw-bold">
                                                {{ $school->school->school_name }}
                                            </a>
                                        </td>
                                        <td>{{ $school->school->ward->ward }}</td>
                                        <td>{{ number_format($school->total_students) }}</td>
                                        <td>{{ number_format($school->total_scholarships) }}</td>
                                        <td>{{ number_format($school->by_exam) }}</td>
                                        <td>{{ number_format($school->by_aarakshyan) }}</td>
                                        <td>
                                            <a href="{{ route('reports.academic-year-reports.students', $school->id) }}"
                                               class="btn btn-sm btn-primary">
                                                <i class="bx bx-detail"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-active fw-bold">
                                    <td colspan="4" class="text-end">जम्मा:</td>
                                    <td>{{ number_format($totalStudents) }}</td>
                                    <td>{{ number_format($totalScholarships) }}</td>
                                    <td>{{ number_format($totalByExam) }}</td>
                                    <td>{{ number_format($totalByAarakshyan) }}</td>
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
