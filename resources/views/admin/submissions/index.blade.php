@extends('admin.layout')

@section('content')

    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-between align-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">REPAIR DIRECTORY</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('admin.submissions')</li>
                    </ol>
                </nav>
                <div class="btn-group">
                    <a class="btn btn-primary btn-save" href="{{ route('admin.business.edit') }}">Create new business</a>
                </div>
            </div>
        </div>
    </div>

    <h2>@lang('admin.submissions_via_gravity_forms')</h2>

    <table class="table table-bordered table-hover" aria-label="Table of submissions">
        <thead>
        <tr>
            <th scope="col">@lang('admin.name')</th>
            <th scope="col">@lang('admin.website')</th>
            <th scope="col">@lang('admin.local_area')</th>
            <th scope="col">@lang('admin.submission_date')</th>
            <th scope="col">@lang('admin.submission_status')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($submissions as $submission)
            <tr onclick="window.document.location='{{ route('admin.submissions.view', ['id' => $submission->getExternalId()]) }}'">
                <td>{{ $submission->getBusinessName() }}</td>
                <td>{{ $submission->getBusinessWebsite() }}</td>
                <td>{{ $submission->getBusinessBorough() }}</td>
                <td>{{ $submission->getCreatedAt() }}</td>
                <td>
                    <select class='form-control select2 submission-status' name='hobby'>
                        @foreach ((new ReflectionClass("TheRestartProject\RepairDirectory\Domain\Enums\SubmissionStatus"))->getConstants() as $val)
                            <option value="{{$val}}" selected="">{{$val}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@push('scripts')
    <script defer>
     jQuery('table').DataTable({
       "ordering": true,
       "order": [[3, 'desc']]
     });

     jQuery('.submission-status').click(function(e) {
         e.stopPropagation()
         return false
     })

     jQuery('.submission-status').change(function(e) {
         e.stopPropagation()
         return false
     })
    </script>
@endpush
