@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">शैक्षिक सत्र सम्पादन</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('academicyear.index') }}">शैक्षिक सत्र प्रविष्टि</a></li>
                        <li class="breadcrumb-item active">शैक्षिक सत्र सम्पादन</li>
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
                                    <form action="{{ route('academicyear.update', ['id' => $academicYear->id, 'hash' => generate_hash($academicYear)]) }}" method="POST">
                                        @csrf
                                        <div class="row justify-content-center">

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="academic_year" type="text"
                                                        class="form-control @error('academic_year') is-invalid @enderror"
                                                        name="academic_year" value="{{ old('academic_year', $academicYear->academic_year) }}" required
                                                        autocomplete="off" placeholder="शैक्षिक सत्र">
                                                    <label class="form-label" for="academic_year">शैक्षिक सत्र <span class="text-danger">*</span></label>

                                                    @error('academic_year')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="start_date" type="text"
                                                        class="form-control date nepcal @error('start_date') is-invalid @enderror"
                                                        name="start_date" value="{{ old('start_date', $academicYear->start_date) }}" required
                                                        autocomplete="off" placeholder="शुरु मिति">
                                                    <label for="start_date">शुरु मिति <span class="text-danger">*</span></label>
                                                    @error('start_date')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="end_date" type="text"
                                                        class="form-control date nepcal @error('end_date') is-invalid @enderror"
                                                        name="end_date" value="{{ old('end_date', $academicYear->end_date) }}" required
                                                        autocomplete="off" placeholder="अन्त्य मिति">
                                                    <label for="end_date">अन्त्य मिति <span class="text-danger">*</span></label>
                                                    @error('end_date')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 text-center mb-3">
                                                <label for="">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                    Update </button>
                                                <a href="{{ route('academicyear.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>
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
