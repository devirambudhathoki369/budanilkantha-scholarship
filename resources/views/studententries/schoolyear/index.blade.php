@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $school->school_name }} - शैक्षिक वर्ष</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('schoollist.index') }}">विद्यालय सूची</a></li>
                        <li class="breadcrumb-item active">शैक्षिक वर्ष</li>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchoolYearModal">
                                <i class="fa fa-plus"></i> नयाँ शैक्षिक वर्ष थप्नुहोस्
                            </button>
                        </div>
                    </div>

                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                        style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="5%">क्रम</th>
                                <th width="15%">शैक्षिक सत्र</th>
                                <th width="12%">कुल विद्यार्थी</th>
                                <th width="12%">छात्रवृत्ति संख्या</th>
                                <th width="15%">आरक्षणबाट</th>
                                <th width="15%">परीक्षाबाट</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($schoolYears as $sn => $schoolYear)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $schoolYear->academicYear->academic_year }}</td>
                                    <td>{{ $schoolYear->total_students }}</td>
                                    <td>{{ $schoolYear->scholarship_no }}</td>
                                    <td>{{ $schoolYear->scholarship_by_aarakshyan_no }}</td>
                                    <td>{{ $schoolYear->scholarship_by_exam_no }}</td>
                                    <td>
                                        <a href="{{ route('student.index', $schoolYear->id) }}"
                                            class="btn btn-info">
                                            <i class="bx bx-user"></i> विद्यार्थी
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('schoolyear.edit', ['id' => $schoolYear->id, 'hash' => generate_hash($schoolYear)]) }}"
                                            class="btn btn-success"><i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{ route('schoolyear.delete', ['id' => $schoolYear->id, 'hash' => generate_hash($schoolYear)]) }}"
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

    <!-- Add School Year Modal -->
    <div class="modal fade" id="addSchoolYearModal" tabindex="-1" aria-labelledby="addSchoolYearModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSchoolYearModalLabel">नयाँ शैक्षिक वर्ष थप्नुहोस्</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('schoolyear.store', $school->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select id="academic_year_id" name="academic_year_id"
                                        class="form-select @error('academic_year_id') is-invalid @enderror" required>
                                        <option value="">शैक्षिक सत्र छान्नुहोस्</option>
                                        @foreach($academicYears as $academicYear)
                                            <option value="{{ $academicYear->id }}" {{ old('academic_year_id') == $academicYear->id ? 'selected' : '' }}>
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
                                        name="total_students" value="{{ old('total_students') }}" required
                                        autocomplete="off" placeholder="कुल विद्यार्थी संख्या" min="1">
                                    <label for="total_students">कुल विद्यार्थी संख्या <span class="text-danger">*</span></label>
                                    @error('total_students')
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
        var addSchoolYearModal = new bootstrap.Modal(document.getElementById('addSchoolYearModal'));
        addSchoolYearModal.show();
    @endif
</script>
@endsection
