<h1>{{$modo}} empleado</h1>

<!-- Errores de validacion de datos -->
@if(count($errors)>0)
<div class="alert alert-danger">
    <ul>
        @foreach($errors -> all() as $error)
        <li> {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row form-group">
    <div class="col-md-4">
        <label for="">Nombre(s)</label>
        <input type="text" class="form-control" value="{{ isset($empleado->nombre) ? $empleado->nombre: old('nombre') }}" name="nombre" >
    </div>
    <div class="col-md-4">
        <label for="">Primer apellido</label>
        <input type="text" class="form-control" value="{{ isset($empleado->primer_apellido) ? $empleado->primer_apellido: old('primer_apellido') }}" name="primer_apellido" >
    </div>
    <div class="col-md-4">
        <label for="">Segundo apellido</label>
        <input type="text" class="form-control" value="{{ isset($empleado->segundo_apellido) ? $empleado->segundo_apellido: old('segundo_apellido') }}" name="segundo_apellido" >
    </div>
</div>
<div class="row form-group">
    <div class="col-md-4">
        <label for="">Correo</label>
        <input type="email" class="form-control" value="{{ isset($empleado->correo) ? $empleado->correo: old('correo') }}" name="correo" >
    </div>
    <div class="col-md-4">
        <label for="">Foto</label>
        @if(isset($empleado->foto))
        <br />
        <img class="img-thumbnail img-fluid" width="100" src="{{ asset('storage').'/'.$empleado->foto }}" alt="" /><br /><br />
        @endif
        <input type="file" value="" class="form-control" name="foto">
        <input type="hidden" value="1" name="activo">
    </div>
    <div class="col-md-4 d-flex align-items-end mt-3">
        <input type="submit" class="btn btn-success" value="{{$modo}} datos" />
    </div>
</div>
<br />
<a href="{{ url('empleado') }}" class="btn btn-primary">Regresar</a>
<br />