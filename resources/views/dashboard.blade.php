@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Header with Gradient -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1 fw-bold text-dark">Dashboard</h2>
                            <p class="text-muted mb-0">शैक्षिक वर्षको सम्पूर्ण तथ्यांक एक नजरमा</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-soft-primary text-primary font-size-12 px-3 py-2">
                                <i class="bx bx-calendar me-1"></i> {{ date('Y-m-d') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Academic Years Statistics with Enhanced Design -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h4 class="card-title mb-1 fw-bold">सबै शैक्षिक वर्षको तथ्यांक</h4>
                                <p class="text-muted mb-0 small">ऐतिहासिक डेटा र तुलनात्मक विश्लेषण</p>
                            </div>
                            <div class="avatar-sm bg-soft-primary rounded">
                                <i class="bx bx-bar-chart-alt-2 text-primary font-size-24 d-flex align-items-center justify-content-center h-100"></i>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="border-0 rounded-start" style="padding: 15px;">शैक्षिक वर्ष</th>
                                        <th class="border-0" style="padding: 15px;">विद्यालय संख्या</th>
                                        <th class="border-0" style="padding: 15px;">कुल विद्यार्थी</th>
                                        <th class="border-0 rounded-end" style="padding: 15px;">छात्रवृत्ति प्रदान</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($academicYearsStats as $stat)
                                        <tr class="border-bottom">
                                            <td class="py-3">
                                                <span class="fw-semibold text-dark">{{ $stat->academic_year }}</span>
                                                @if($stat->is_current == '1')
                                                    <span class="badge bg-gradient bg-success ms-2">
                                                        <i class="bx bx-check-circle me-1"></i>चालु
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3">
                                                <a href="{{ route('dashboard.academic-year-schools', $stat->id) }}"
                                                   class="btn btn-sm btn-soft-primary">
                                                    <i class="bx bx-building me-1"></i>
                                                    <strong>{{ $stat->total_schools }}</strong>
                                                </a>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-soft-info text-info font-size-13 px-3 py-2">
                                                    {{ number_format($stat->total_students) }}
                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-soft-warning text-warning font-size-13 px-3 py-2">
                                                    {{ number_format($stat->scholarship_awarded) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <i class="bx bx-data font-size-48 text-muted mb-2 d-block"></i>
                                                <p class="text-muted mb-0">कुनै डेटा उपलब्ध छैन</p>
                                            </td>
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
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h4 class="card-title mb-1 fw-bold">
                                    चालु शैक्षिक वर्षको तथ्यांक
                                </h4>
                                <p class="text-muted mb-0 small">
                                    {{ $currentYearStats['academic_year']->academic_year }} को विस्तृत जानकारी
                                </p>
                            </div>
                            <span class="badge bg-gradient bg-success font-size-12 px-3 py-2">
                                <i class="bx bx-trending-up me-1"></i>Active Year
                            </span>
                        </div>

                        <!-- Enhanced Summary Cards with Gradients -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <div class="card-body p-4 text-white">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="mb-2 opacity-75">कुल विद्यालय</p>
                                                <h2 class="mb-0 fw-bold">
                                                    <a href="{{ route('dashboard.academic-year-schools', $currentYearStats['academic_year']->id) }}"
                                                       class="text-white text-decoration-none">
                                                        {{ number_format($currentYearStats['total_schools']) }}
                                                    </a>
                                                </h2>
                                            </div>
                                            <div class="avatar-sm bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bx bx-building font-size-24"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-up-arrow-alt me-1"></i>
                                            <span class="small opacity-75">Total Schools</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <div class="card-body p-4 text-white">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="mb-2 opacity-75">कुल विद्यार्थी</p>
                                                <h2 class="mb-0 fw-bold">{{ number_format($currentYearStats['total_students']) }}</h2>
                                            </div>
                                            <div class="avatar-sm bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bx bx-user font-size-24"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-group me-1"></i>
                                            <span class="small opacity-75">Total Students</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                    <div class="card-body p-4 text-white">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="mb-2 opacity-75">छात्रवृत्ति प्रदान</p>
                                                <h2 class="mb-0 fw-bold">{{ number_format($currentYearStats['scholarship_awarded']) }}</h2>
                                            </div>
                                            <div class="avatar-sm bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bx bx-award font-size-24"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-medal me-1"></i>
                                            <span class="small opacity-75">Scholarships</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                    <div class="card-body p-4 text-white">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="mb-2 opacity-75">छात्रवृत्ति प्रतिशत</p>
                                                <h2 class="mb-0 fw-bold">
                                                    {{ $currentYearStats['total_students'] > 0 ? number_format(($currentYearStats['scholarship_awarded'] / $currentYearStats['total_students']) * 100, 2) : 0 }}%
                                                </h2>
                                            </div>
                                            <div class="avatar-sm bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bx bx-chart font-size-24"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-line-chart me-1"></i>
                                            <span class="small opacity-75">Percentage</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Scholarship Type Statistics with Modern Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h5 class="mb-3 fw-semibold">
                                    <i class="bx bx-category-alt text-primary me-2"></i>छात्रवृत्ति प्रकार अनुसार
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-lg bg-soft-success rounded-3 d-flex align-items-center justify-content-center me-3">
                                                <i class="bx bx-group font-size-36 text-success"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">आरक्षणबाट छात्रवृत्ति</p>
                                                <h3 class="mb-0 fw-bold text-success">{{ number_format($scholarshipTypeStats['from_aarakshyan']) }}</h3>
                                                <small class="text-muted">From Reservation</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-lg bg-soft-info rounded-3 d-flex align-items-center justify-content-center me-3">
                                                <i class="bx bx-file font-size-36 text-info"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">परीक्षाबाट छात्रवृत्ति</p>
                                                <h3 class="mb-0 fw-bold text-info">{{ number_format($scholarshipTypeStats['from_exam']) }}</h3>
                                                <small class="text-muted">From Examination</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aarakshya Statistics with Enhanced Table -->
                        @if($aarakshyaStats && $aarakshyaStats->count() > 0)
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0 bg-light">
                                    <div class="card-body p-4">
                                        <h5 class="mb-3 fw-semibold">
                                            <i class="bx bx-pie-chart-alt-2 text-primary me-2"></i>आरक्षण प्रकार अनुसार तथ्यांक
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0 bg-white rounded">
                                                <thead>
                                                    <tr class="bg-primary bg-opacity-10">
                                                        <th class="border-0 py-3 rounded-start">आरक्षण प्रकार</th>
                                                        <th class="border-0 py-3 text-center">प्रतिशत</th>
                                                        <th class="border-0 py-3 text-end rounded-end">विद्यार्थी संख्या</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($aarakshyaStats as $aarakshya)
                                                        <tr class="border-bottom">
                                                            <td class="py-3">
                                                                <i class="bx bx-badge-check text-primary me-2"></i>
                                                                <span class="fw-semibold">{{ $aarakshya->title }}</span>
                                                            </td>
                                                            <td class="py-3 text-center">
                                                                <span class="badge bg-soft-warning text-warning font-size-13 px-3 py-2">
                                                                    {{ $aarakshya->percentage }}%
                                                                </span>
                                                            </td>
                                                            <td class="py-3 text-end">
                                                                <span class="badge bg-gradient bg-primary font-size-14 px-3 py-2">
                                                                    <i class="bx bx-user me-1"></i>{{ number_format($aarakshya->student_count) }}
                                                                </span>
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
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bx bx-calendar-x font-size-48 text-muted mb-3 d-block"></i>
                        <h5 class="text-muted mb-2">चालु शैक्षिक वर्ष सेट गरिएको छैन।</h5>
                        <p class="text-muted small">कृपया शैक्षिक वर्ष सेट गर्नुहोस्</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <style>
        .bg-soft-primary {
            background-color: rgba(102, 126, 234, 0.1);
        }
        .bg-soft-success {
            background-color: rgba(16, 185, 129, 0.1);
        }
        .bg-soft-info {
            background-color: rgba(59, 130, 246, 0.1);
        }
        .bg-soft-warning {
            background-color: rgba(251, 191, 36, 0.1);
        }
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }
        .avatar-lg {
            width: 4rem;
            height: 4rem;
        }
        .bg-gradient {
            background-image: linear-gradient(135deg, currentColor 0%, currentColor 100%);
        }
    </style>
@endsection
