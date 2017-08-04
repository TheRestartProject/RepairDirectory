@extends('admin.layout')

@section('content')

    <h2>All Repairers</h2>
    <a class="btn btn-primary" href="{{ route('admin.business.edit') }}">Add repairer</a>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Postcode</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($businesses as $business)
            <tr onclick="window.document.location='{{ route('admin.business.edit', ['id' => $business->getUid()]) }}'"
                role="button">
                <td>{{ $business->getName() }}</td>
                <td>{{ $business->getAddress() }}</td>
                <td>{{ $business->getPostcode() }}</td>
                <td>{{ $business->getDescription() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection