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

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Welcome to {{ env('APP_OFFICE') }} Dashboard</h4>
                        <p class="card-title-desc">You are logged in as

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
