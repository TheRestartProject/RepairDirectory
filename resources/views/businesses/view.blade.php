@extends('map')

@section('scripts')

    <script async defer onload="loadBusiness('{{ $business->getUid() }}')"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqzOdSRgPAZO6wC_oxOOkb7lkarq0PjT8"></script>

@endsection