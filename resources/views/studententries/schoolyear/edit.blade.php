@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">शैक्षिक वर्ष सम्पादन</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('schoollist.index') }}">विद्यालय सूची</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('schoolyear.index', $school->id) }}">शैक्षिक वर्ष</a></li>
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
                                    <form action="{{ route('schoolyear.update', ['id' => $schoolYear->id, 'hash' => generate_hash($schoolYear)]) }}" method="POST">
                                        @csrf
                                        <div class="row justify-content-center">

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <select id="academic_year_id" name="academic_year_id"
                                                        class="form-select @error('academic_year_id') is-invalid @enderror" required>
                                                        <option value="">शैक्षिक सत्र छान्नुहोस्</option>
                                                        @foreach($academicYears as $academicYear)
                                                            <option value="{{ $academicYear->id }}"
                                                                {{ old('academic_year_id', $schoolYear->academic_year_id) == $academicYear->id ? 'selected' : '' }}>
                                                                {{ $academicYear->academic_year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="academic_year_id">शैक्षिक सत्र <span class="text-danger">*</span></label>
                                                    @error('academic_year_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="total_students" type="number"
                                                        class="form-control @error('total_students') is-invalid @enderror"
                                                        name="total_students" value="{{ old('total_students', $schoolYear->total_students) }}" required
                                                        autocomplete="off" placeholder="कुल विद्यार्थी संख्या" min="1">
                                                    <label for="total_students">कुल विद्यार्थी संख्या <span class="text-danger">*</span></label>
                                                    @error('total_students')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 text-center mb-3">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                    Update </button>
                                                <a href="{{ route('schoolyear.index', $school->id) }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>
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
