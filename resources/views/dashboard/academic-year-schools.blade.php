@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $academicYear->academic_year }} - विद्यालय सूची</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">विद्यालय सूची</li>
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

                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                        style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="5%">क्रम</th>
                                <th width="10%">EMIS नं.</th>
                                <th width="25%">विद्यालयको नाम</th>
                                <th width="12%">ठेगाना</th>
                                <th width="10%">सम्पर्क नं.</th>
                                <th width="8%">वडा</th>
                                <th width="10%">कुल विद्यार्थी</th>
                                <th width="10%">छात्रवृत्ति संख्या</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($schools as $sn => $schoolYear)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $schoolYear->school->emis_no }}</td>
                                    <td>{{ $schoolYear->school->school_name }}</td>
                                    <td>{{ $schoolYear->school->address }}</td>
                                    <td>{{ $schoolYear->school->contact_no }}</td>
                                    <td>{{ $schoolYear->school->ward->ward }}</td>
                                    <td>{{ number_format($schoolYear->total_students) }}</td>
                                    <td>{{ number_format($schoolYear->scholarship_no) }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.school-students', $schoolYear->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bx bx-detail"></i> विवरण
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <!-- end table responsive -->
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
