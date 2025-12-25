@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">प्रयोगकर्ता प्रविष्टि</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">प्रयोगकर्ता प्रविष्टि</li>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="fa fa-plus"></i> नयाँ प्रयोगकर्ता थप्नुहोस्
                            </button>
                        </div>
                    </div>

                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                        style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="5%">क्रम</th>
                                <th width="25%">पूरा नाम</th>
                                <th width="25%">प्रयोगकर्ता नाम</th>
                                <th width="15%">प्रयोगकर्ता प्रकार</th>
                                <th width="20%">विद्यालय</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $sn => $user)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->usertype == 'admin')
                                            <span class="badge bg-danger">एडमिन</span>
                                        @elseif($user->usertype == 'office_user')
                                            <span class="badge bg-success">कार्यालय प्रयोगकर्ता</span>
                                        @else
                                            <span class="badge bg-info">विद्यालय प्रयोगकर्ता</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->school ? $user->school->school_name : '-' }}</td>

                                    <td>
                                        <a href="{{ route('user.edit', ['id' => $user->id, 'hash' => generate_hash($user)]) }}"
                                            class="btn btn-success"><i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{ route('user.delete', ['id' => $user->id, 'hash' => generate_hash($user)]) }}"
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">नयाँ प्रयोगकर्ता थप्नुहोस्</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required
                                        autocomplete="off" placeholder="पूरा नाम">
                                    <label for="name">पूरा नाम <span class="text-danger">*</span></label>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required
                                        autocomplete="off" placeholder="प्रयोगकर्ता नाम">
                                    <label for="email">प्रयोगकर्ता नाम <span class="text-danger">*</span></label>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password" required
                                        autocomplete="off" placeholder="पासवर्ड">
                                    <label for="password">पासवर्ड <span class="text-danger">*</span></label>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="password_confirmation" type="password"
                                        class="form-control"
                                        name="password_confirmation" required
                                        autocomplete="off" placeholder="पासवर्ड पुष्टि गर्नुहोस्">
                                    <label for="password_confirmation">पासवर्ड पुष्टि गर्नुहोस् <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select id="usertype" name="usertype"
                                        class="form-select @error('usertype') is-invalid @enderror" required
                                        onchange="toggleSchoolField(this.value)">
                                        <option value="">प्रयोगकर्ता प्रकार छान्नुहोस्</option>
                                        <option value="admin" {{ old('usertype') == 'admin' ? 'selected' : '' }}>एडमिन</option>
                                        <option value="office_user" {{ old('usertype') == 'office_user' ? 'selected' : '' }}>कार्यालय प्रयोगकर्ता</option>
                                        <option value="school_user" {{ old('usertype') == 'school_user' ? 'selected' : '' }}>विद्यालय प्रयोगकर्ता</option>
                                    </select>
                                    <label for="usertype">प्रयोगकर्ता प्रकार <span class="text-danger">*</span></label>
                                    @error('usertype')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3" id="schoolFieldDiv" style="display: none;">
                                <div class="form-floating">
                                    <select id="school_id" name="school_id"
                                        class="form-select @error('school_id') is-invalid @enderror">
                                        <option value="">विद्यालय छान्नुहोस्</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                                {{ $school->school_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="school_id">विद्यालय <span class="text-danger">*</span></label>
                                    @error('school_id')
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
    function toggleSchoolField(usertype) {
        const schoolFieldDiv = document.getElementById('schoolFieldDiv');
        const schoolSelect = document.getElementById('school_id');

        if (usertype === 'school_user') {
            schoolFieldDiv.style.display = 'block';
            schoolSelect.setAttribute('required', 'required');
        } else {
            schoolFieldDiv.style.display = 'none';
            schoolSelect.removeAttribute('required');
            schoolSelect.value = '';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const usertypeSelect = document.getElementById('usertype');
        if (usertypeSelect.value) {
            toggleSchoolField(usertypeSelect.value);
        }
    });

    // Re-open modal if there are validation errors
    @if ($errors->any())
        var addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        addUserModal.show();

        // Show school field if school_user was selected
        const usertypeValue = document.getElementById('usertype').value;
        if (usertypeValue) {
            toggleSchoolField(usertypeValue);
        }
    @endif
</script>
@endsection
