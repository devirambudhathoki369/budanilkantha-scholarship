@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">पासवर्ड परिवर्तन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="#">प्रयोगकर्ता</a></li>
                        <li class="breadcrumb-item active">पासवर्ड परिवर्तन</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">{{ $user->fullname }} को पासवर्ड परिवर्तन गर्नुहोस्</h5>

                                    <form action="{{ route('user.change-password-update', ['id' => $user->id, 'hash' => generate_hash($user)]) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input id="old_password" type="password"
                                                        class="form-control @error('old_password') is-invalid @enderror"
                                                        name="old_password" required
                                                        autocomplete="off" placeholder="पुरानो पासवर्ड">
                                                    <label class="form-label" for="old_password">पुरानो पासवर्ड</label>

                                                    @error('old_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" required
                                                        autocomplete="off" placeholder="नयाँ पासवर्ड">
                                                    <label class="form-label" for="password">नयाँ पासवर्ड</label>

                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input id="password_confirmation" type="password"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        name="password_confirmation" required
                                                        autocomplete="off" placeholder="नयाँ पासवर्ड पुष्टि गर्नुहोस्">
                                                    <label class="form-label" for="password_confirmation">नयाँ पासवर्ड पुष्टि गर्नुहोस्</label>

                                                    @error('password_confirmation')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center mb-3">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                    पासवर्ड परिवर्तन गर्नुहोस् </button>
                                                {{-- <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                                    <i class="fa fa-arrow-left"></i> फिर्ता
                                                </a> --}}
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
