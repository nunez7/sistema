@extends('layouts.app')

@section('content')
<div class="container">

    Mostrar las listas de empleados
    <br />
    <!-- mensajes de session -->
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <br />
    <a href="{{ url('empleado/create') }}" class="btn btn-primary">Registrar nuevo empleado</a>
    <br />
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Segundo apellido</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
            <tr>
                <td>{{ $empleado->id }}</td>
                <td>
                    <img class="img-thumbnail img-fluid" width="100" src="{{ asset('storage/'.$empleado->foto) }}" alt="">
                </td>
                <td>{{ $empleado->nombre }}</td>
                <td>{{ $empleado->primer_apellido }}</td>
                <td>{{ $empleado->segundo_apellido }}</td>
                <td>{{ $empleado->correo }}</td>
                <td>
                    <div class="d-inline">
                        <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}" class="btn btn-warning">Editar</a>
                    </div>
                    |
                    <form action="{{ url('/empleado/'.$empleado->id) }}" class="d-inline" method="post">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="button" value="Eliminar" onclick="return confirm('¿Quieres borrar?');" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $empleados->links() !!}
</div>
@endsection