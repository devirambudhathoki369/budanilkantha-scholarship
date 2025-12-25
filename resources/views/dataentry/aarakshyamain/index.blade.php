@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">आरक्षण प्रविष्टि</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">आरक्षण प्रविष्टि</li>
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
                                    <form action="{{ route('aarakshyamain.store') }}" method="POST">
                                        @csrf
                                        <div class="row justify-content-center">

                                            <div class="col-md-6 mb-1">
                                                <div class="form-floating">
                                                    <input id="title" type="text"
                                                        class="form-control @error('title') is-invalid @enderror"
                                                        name="title" value="{{ old('title') }}" required
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
                                                        name="percentage" value="{{ old('percentage') }}" required
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
                                                    Save </button>
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
                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                        style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="5%">क्रम</th>
                                <th width="50%">शीर्षक</th>
                                <th width="30%">प्रतिशत</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($aarakshyaMains as $sn => $aarakshyaMain)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $aarakshyaMain->title }}</td>
                                    <td>{{ $aarakshyaMain->percentage }}</td>

                                    <td>
                                        <a href="{{ route('aarakshyamain.edit', ['id' => $aarakshyaMain->id, 'hash' => generate_hash($aarakshyaMain)]) }}"
                                            class="btn btn-success"><i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{ route('aarakshyamain.delete', ['id' => $aarakshyaMain->id, 'hash' => generate_hash($aarakshyaMain)]) }}"
                                            onclick="return confirm('के तपाई यो डेटा हटाउन चाहनुहुन्छ?')"
                                            class="btn btn-xs btn-danger" title="delete"><span><i
                                                    class="fa fa-trash"></i></span></a>
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
