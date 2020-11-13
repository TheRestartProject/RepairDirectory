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

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>@lang('admin.name')</th>
            <th>@lang('admin.website')</th>
            <th>@lang('admin.local_area')</th>
            <th>@lang('admin.submission_date')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($submissions as $submission)
            <tr onclick="window.document.location='{{ route('admin.submissions.view', ['id' => $submission->getExternalId()]) }}'">
                <td>{{ $submission->getBusinessName() }}</td>
                <td>{{ $submission->getBusinessWebsite() }}</td>
                <td>{{ $submission->getBusinessBorough() }}</td>
                <td>{{ $submission->getCreatedAt() }}</td>
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
    </script>
@endpush
