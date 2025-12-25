@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">विद्यालय सूची</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
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
                                <th width="30%">विद्यालयको नाम</th>
                                <th width="15%">ठेगाना</th>
                                <th width="10%">सम्पर्क नं.</th>
                                <th width="10%">वडा</th>
                                <th width="10%">प्रकार</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($schools as $sn => $school)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $school->emis_no }}</td>
                                    <td>{{ $school->school_name }}</td>
                                    <td>{{ $school->address }}</td>
                                    <td>{{ $school->contact_no }}</td>
                                    <td>{{ $school->ward->ward }}</td>
                                    <td>
                                        @if($school->school_type == 'public')
                                            <span class="badge bg-success">सार्वजनिक</span>
                                        @else
                                            <span class="badge bg-info">निजी</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('schoolyear.index', $school->id) }}"
                                            class="btn btn-primary">
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
