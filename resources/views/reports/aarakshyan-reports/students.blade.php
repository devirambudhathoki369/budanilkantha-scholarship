@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $schoolYear->school->school_name }} - {{ $aarakshyaMain->title }} - विद्यार्थी सूची</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.aarakshyan-reports.index') }}">आरक्षण अनुसार प्रतिवेदन</a></li>
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
        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">आरक्षण प्रकार</p>
                            <h5 class="mb-0">{{ $aarakshyaMain->title }}</h5>
                        </div>
                        <div class="avatar-sm rounded-circle bg-success align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-success">
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
                            <p class="text-muted fw-medium">आरक्षण प्रतिशत</p>
                            <h4 class="mb-0">{{ $aarakshyaMain->percentage }}%</h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-warning align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-warning">
                                <i class="bx bx-chart font-size-24"></i>
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

                    <div class="table-responsive">
                        <table class="table align-middle table-bordered table-hover nowrap" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">क्रम</th>
                                    <th width="20%">विद्यार्थीको नाम</th>
                                    <th width="15%">ठेगाना</th>
                                    <th width="10%">अभिभावक</th>
                                    <th width="12%">सम्पर्क नं.</th>
                                    <th width="15%">इमेल</th>
                                    <th width="10%">EMIS नं.</th>
                                    <th width="13%">आरक्षण प्रकार</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($students as $sn => $student)
                                    <tr>
                                        <td>{{ ++$sn }}</td>
                                        <td>{{ $student->student_name }}</td>
                                        <td>{{ $student->address }}</td>
                                        <td>{{ $student->parent_name }}</td>
                                        <td>{{ $student->contact_no }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->emis_no }}</td>
                                        <td>
                                            <span class="badge bg-warning">{{ $student->aarakshyaMain->title }}</span>
                                        </td>
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
