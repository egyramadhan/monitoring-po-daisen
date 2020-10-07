@extends('main')

@section('title', 'Material Receipt  - Daisen')

@section('content')
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Register At</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($datas['data'] as $dt)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $dt['name'] }}</td>
            <td>{{ $dt->code }}</td>
            <td>{{ $dt->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection