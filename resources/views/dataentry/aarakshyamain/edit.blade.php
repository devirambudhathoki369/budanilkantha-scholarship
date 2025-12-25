@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">आरक्षण सम्पादन</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('aarakshyamain.index') }}">आरक्षण प्रविष्टि</a></li>
                        <li class="breadcrumb-item active">आरक्षण सम्पादन</li>
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
                                    <form action="{{ route('aarakshyamain.update', ['id' => $aarakshyaMain->id, 'hash' => generate_hash($aarakshyaMain)]) }}" method="POST">
                                        @csrf
                                        <div class="row justify-content-center">

                                            <div class="col-md-6 mb-1">
                                                <div class="form-floating">
                                                    <input id="title" type="text"
                                                        class="form-control @error('title') is-invalid @enderror"
                                                        name="title" value="{{ old('title', $aarakshyaMain->title) }}" required
                                                        autocomplete="off" placeholder="शीर्षक">
                                                    <label class="form-label" for="title">शीर्षक</label>

                                                    @error('title')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-1">
                                                <div class="form-floating">
                                                    <input id="percentage" type="text"
                                                        class="form-control @error('percentage') is-invalid @enderror"
                                                        name="percentage" value="{{ old('percentage', $aarakshyaMain->percentage) }}" required
                                                        autocomplete="off" placeholder="प्रतिशत">
                                                    <label class="form-label" for="percentage">प्रतिशत</label>

                                                    @error('percentage')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 text-center mb-3">
                                                <label for="">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                    Update </button>
                                                <a href="{{ route('aarakshyamain.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>
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
