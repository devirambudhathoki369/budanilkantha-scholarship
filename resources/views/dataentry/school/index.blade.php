@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">विद्यालय प्रविष्टि</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">विद्यालय प्रविष्टि</li>
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

                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                                <i class="fa fa-plus"></i> नयाँ विद्यालय थप्नुहोस्
                            </button>
                        </div>
                    </div>

                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                        style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="3%">क्रम</th>
                                <th width="8%">EMIS नं.</th>
                                <th width="20%">विद्यालयको नाम</th>
                                <th width="12%">ठेगाना</th>
                                <th width="10%">सम्पर्क नं.</th>
                                <th width="12%">सम्पर्क व्यक्ति</th>
                                <th width="12%">इमेल</th>
                                <th width="8%">वडा</th>
                                <th width="8%">प्रकार</th>
                                <th></th>
                                <th></th>
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
                                    <td>{{ $school->contact_person }}</td>
                                    <td>{{ $school->email }}</td>
                                    <td>{{ $school->ward->ward }}</td>
                                    <td>
                                        @if($school->school_type == 'public')
                                            <span class="badge bg-success">सार्वजनिक</span>
                                        @else
                                            <span class="badge bg-info">निजी</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('school.edit', ['id' => $school->id, 'hash' => generate_hash($school)]) }}"
                                            class="btn btn-success"><i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{ route('school.delete', ['id' => $school->id, 'hash' => generate_hash($school)]) }}"
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

    <!-- Add School Modal -->
    <div class="modal fade" id="addSchoolModal" tabindex="-1" aria-labelledby="addSchoolModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSchoolModalLabel">नयाँ विद्यालय थप्नुहोस्</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('school.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="emis_no" type="text"
                                        class="form-control @error('emis_no') is-invalid @enderror"
                                        name="emis_no" value="{{ old('emis_no') }}"
                                        autocomplete="off" placeholder="EMIS नं.">
                                    <label for="emis_no">EMIS नं.</label>
                                    @error('emis_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="school_name" type="text"
                                        class="form-control @error('school_name') is-invalid @enderror"
                                        name="school_name" value="{{ old('school_name') }}" required
                                        autocomplete="off" placeholder="विद्यालयको नाम">
                                    <label for="school_name">विद्यालयको नाम <span class="text-danger">*</span></label>
                                    @error('school_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror"
                                        name="address" value="{{ old('address') }}"
                                        autocomplete="off" placeholder="ठेगाना">
                                    <label for="address">ठेगाना</label>
                                    @error('address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="contact_no" type="text"
                                        class="form-control @error('contact_no') is-invalid @enderror"
                                        name="contact_no" value="{{ old('contact_no') }}"
                                        autocomplete="off" placeholder="सम्पर्क नं.">
                                    <label for="contact_no">सम्पर्क नं.</label>
                                    @error('contact_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="contact_person" type="text"
                                        class="form-control @error('contact_person') is-invalid @enderror"
                                        name="contact_person" value="{{ old('contact_person') }}"
                                        autocomplete="off" placeholder="सम्पर्क व्यक्ति">
                                    <label for="contact_person">सम्पर्क व्यक्ति</label>
                                    @error('contact_person')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}"
                                        autocomplete="off" placeholder="इमेल">
                                    <label for="email">इमेल</label>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select id="ward_id" name="ward_id"
                                        class="form-select @error('ward_id') is-invalid @enderror" required>
                                        <option value="">वडा छान्नुहोस्</option>
                                        @foreach($wards as $ward)
                                            <option value="{{ $ward->id }}" {{ old('ward_id') == $ward->id ? 'selected' : '' }}>
                                                {{ $ward->ward }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="ward_id">वडा <span class="text-danger">*</span></label>
                                    @error('ward_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select id="school_type" name="school_type"
                                        class="form-select @error('school_type') is-invalid @enderror" required>
                                        <option value="">विद्यालय प्रकार छान्नुहोस्</option>
                                        <option value="public" {{ old('school_type') == 'public' ? 'selected' : '' }}>सार्वजनिक</option>
                                        <option value="private" {{ old('school_type') == 'private' ? 'selected' : '' }}>निजी</option>
                                    </select>
                                    <label for="school_type">विद्यालय प्रकार <span class="text-danger">*</span></label>
                                    @error('school_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> बन्द गर्नुहोस्
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Re-open modal if there are validation errors
    @if ($errors->any())
        var addSchoolModal = new bootstrap.Modal(document.getElementById('addSchoolModal'));
        addSchoolModal.show();
    @endif
</script>
@endsection
