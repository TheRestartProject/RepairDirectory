@extends('admin.layout')

@section('content')
    <table>
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
            <tr>
                <td>{{ $business->getName() }}</td>
                <td>{{ $business->getAddress() }}</td>
                <td>{{ $business->getPostcode() }}</td>
                <td>{{ $business->getDescription() }}</td>
                <td><a href="">View</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection