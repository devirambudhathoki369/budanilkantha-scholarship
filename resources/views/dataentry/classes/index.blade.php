@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">कक्षा प्रविष्टि</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">कक्षा प्रविष्टि</li>
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
                                    <form action="{{ route('classes.store') }}" method="POST">
                                        @csrf
                                        <div class="row justify-content-center">

                                            <div class="col-md-6 mb-1">
                                                <div class="form-floating">
                                                    <input id="class" type="text"
                                                        class="form-control @error('class') is-invalid @enderror"
                                                        name="class" value="{{ old('class') }}" required
                                                        autocomplete="off" placeholder="कक्षा">
                                                    <label class="form-label" for="class">कक्षा</label>

                                                    @error('class')
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
                                <th width="70%">कक्षा</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($classes as $sn => $class)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $class->class }}</td>

                                    <td>
                                        <a href="{{ route('classes.edit', ['id' => $class->id, 'hash' => generate_hash($class)]) }}"
                                            class="btn btn-success"><i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{ route('classes.delete', ['id' => $class->id, 'hash' => generate_hash($class)]) }}"
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
