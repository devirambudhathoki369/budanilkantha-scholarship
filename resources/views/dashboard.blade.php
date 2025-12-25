@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>
                </div>
            </div>
        </div>

        <!-- All Academic Years Statistics -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">सबै शैक्षिक वर्षको तथ्यांक</h4>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>शैक्षिक वर्ष</th>
                                        <th>विद्यालय संख्या</th>
                                        <th>कुल विद्यार्थी</th>
                                        <th>छात्रवृत्ति प्रदान</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($academicYearsStats as $stat)
                                        <tr>
                                            <td>
                                                {{ $stat->academic_year }}
                                                @if($stat->is_current == '1')
                                                    <span class="badge bg-success">चालु</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('dashboard.academic-year-schools', $stat->id) }}"
                                                   class="text-primary fw-bold">
                                                    {{ $stat->total_schools }}
                                                </a>
                                            </td>
                                            <td>{{ number_format($stat->total_students) }}</td>
                                            <td>{{ number_format($stat->scholarship_awarded) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">कुनै डेटा उपलब्ध छैन</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Academic Year Statistics -->
        @if($currentYearStats)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            चालु शैक्षिक वर्ष ({{ $currentYearStats['academic_year']->academic_year }}) को तथ्यांक
                        </h4>

                        <!-- Summary Cards -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">कुल विद्यालय</p>
                                                <h4 class="mb-0">
                                                    <a href="{{ route('dashboard.academic-year-schools', $currentYearStats['academic_year']->id) }}"
                                                       class="text-dark">
                                                        {{ number_format($currentYearStats['total_schools']) }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-building font-size-24"></i>
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
                                                <h4 class="mb-0">{{ number_format($currentYearStats['total_students']) }}</h4>
                                            </div>
                                            <div class="avatar-sm rounded-circle bg-success align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-success">
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
                                                <p class="text-muted fw-medium">छात्रवृत्ति प्रदान</p>
                                                <h4 class="mb-0">{{ number_format($currentYearStats['scholarship_awarded']) }}</h4>
                                            </div>
                                            <div class="avatar-sm rounded-circle bg-warning align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-warning">
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
                                                <p class="text-muted fw-medium">छात्रवृत्ति प्रतिशत</p>
                                                <h4 class="mb-0">
                                                    {{ $currentYearStats['total_students'] > 0 ? number_format(($currentYearStats['scholarship_awarded'] / $currentYearStats['total_students']) * 100, 2) : 0 }}%
                                                </h4>
                                            </div>
                                            <div class="avatar-sm rounded-circle bg-info align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-info">
                                                    <i class="bx bx-chart font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Scholarship Type Statistics -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5 class="mb-3">छात्रवृत्ति प्रकार अनुसार</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="card border border-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="text-success">आरक्षणबाट छात्रवृत्ति</h5>
                                                <h3 class="mb-0">{{ number_format($scholarshipTypeStats['from_aarakshyan']) }}</h3>
                                            </div>
                                            <div>
                                                <i class="bx bx-group font-size-48 text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border border-info">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="text-info">परीक्षाबाट छात्रवृत्ति</h5>
                                                <h3 class="mb-0">{{ number_format($scholarshipTypeStats['from_exam']) }}</h3>
                                            </div>
                                            <div>
                                                <i class="bx bx-file font-size-48 text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aarakshya Statistics -->
                        @if($aarakshyaStats && $aarakshyaStats->count() > 0)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5 class="mb-3">आरक्षण प्रकार अनुसार तथ्यांक</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>आरक्षण प्रकार</th>
                                                <th>प्रतिशत</th>
                                                <th>विद्यार्थी संख्या</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($aarakshyaStats as $aarakshya)
                                                <tr>
                                                    <td>{{ $aarakshya->title }}</td>
                                                    <td>{{ $aarakshya->percentage }}%</td>
                                                    <td>
                                                        <span class="badge bg-primary font-size-14">
                                                            {{ number_format($aarakshya->student_count) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-muted">चालु शैक्षिक वर्ष सेट गरिएको छैन।</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
