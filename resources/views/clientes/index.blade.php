@extends('layouts.app')

@section('title', 'CLIENTES')

@section('content')
<h1>Lista de Clientes</h1>

@if ($message = Session::get('success'))
<p style="text-align: center;">{{ $message }}</p>
@endif
<div class="table-wrapper">
    <table>
        <tr>
            <th>NOMBRE</th>
            <th>TELEFONO</th>
            <th>EMAIL</th>
            <th>NIT</th>
        </tr>
        @foreach ($clientes as $cl)
        <tr>
            <td>{{ $cl->nombre }}</td>
            <td>{{ $cl->telefono }}</td>
            <td>{{ $cl->email }}</td>
            <td>{{ $cl->NIT }}</td>
        </tr>
        @endforeach
    </table>
    </BR>
</div>
@endsection