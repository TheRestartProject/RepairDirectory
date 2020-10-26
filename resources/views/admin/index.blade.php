@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-between align-content-center">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">REPAIR DIRECTORY</a></li>
                <li class="breadcrumb-item active" aria-current="page">Businesses</li>
                </ol>
                </nav>
                <div class="btn-group">
                    <a class="btn btn-primary btn-save" href="{{ route('admin.business.edit') }}">Create new business</a>
                </div>
            </div>
        </div>
    </div>

    @if (!empty(Auth::user()->getRepairDirectoryRole())) 
        <p>Your role is: {{ Auth::user()->getRepairDirectoryRole()->getName() }}.</p>
    @endif

    <h2>{{ __('admin.form_title') }}</h2>

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{ __('admin.name') }}</th>
            <th>{{ __('admin.address') }}</th>
            <th>{{ __('admin.postcode') }}</th>
            <th>{{ __('admin.local_area') }}</th>
            <th>{{ __('admin.categories') }}</th>
            <th>{{ __('admin.average_scores') }}</th>
            <th>{{ __('admin.publishing_status') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($businesses as $business)
            <tr onclick="window.document.location='{{ route('admin.business.edit', ['id' => $business->getUid()]) }}'"
                role="button">
                <td>{{ $business->getName() }}</td>
                <td>{{ $business->getAddress() }}</td>
                <td>{{ $business->getPostcode() }}</td>
                <td>{{ $business->getLocalArea() }}</td>
                <td>{{ implode(', ', $business->getCategories()) }}</td>
                <td>{{ $business->getAverageScore() }}</td>
                <td>{{ $business->getPublishingStatus() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
    <script defer>
        jQuery('table').DataTable();
    </script>
@endpush
