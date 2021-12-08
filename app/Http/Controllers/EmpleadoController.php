<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['empleados'] = Empleado::paginate(1);
        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validar datos con validate, reglas
        $campos = [
            'nombre'=>'required|string|max:60',
            'primer_apellido'=>'required|string|max:40',
            'segundo_apellido'=>'required|string|max:40',
            'correo'=>'required|email',
            'foto'=>'required|max:10000|mimes:jpeg,png,jpg',
        ];
        //Mensajes de validate
        $mensaje=[
            'required'=>'El :attribute es requerido',
            'foto.required'=>'La foto es requerida',
            'foto.mimes'=>'La foto debe ser: jpeg,png,jpg'
        ];
        //Uniendo mensaje y validacion
        $this->validate($request, $campos, $mensaje);

        //$datosEmpleado = request()->all();
        $datosEmpleado = request()->except('_token');

        if($request->hasFile('foto')){
            $datosEmpleado['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        Empleado::insert($datosEmpleado);
        //return response()->json($datosEmpleado);
        return redirect('empleado')->with('mensaje', 'Empleado agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos = [
            'nombre'=>'required|string|max:60',
            'primer_apellido'=>'required|string|max:40',
            'segundo_apellido'=>'required|string|max:40',
            'correo'=>'required|email',
        ];
        //Mensajes de validate
        $mensaje=[
            'required'=>'El :attribute es requerido',
        ];
        //validamos cuando la foto venga de nuevo
        if($request->hasFile('foto')){
            $campos = [
                'foto'=>'required|max:10000|mimes:jpeg,png,jpg',
            ];
            $mensaje=[
                'foto.required'=>'La foto es requerida',
                'foto.mimes'=>'La foto debe ser: jpeg,png,jpg'
            ];
        }
        //Uniendo mensaje y validacion
        $this->validate($request, $campos, $mensaje);

        //Quitamos el method y el token
        $datosEmpleado = request()->except(['_token', '_method']);
        //Si hay una foto se va a reemplazar
        if($request->hasFile('foto')){
            //Se elimina la foto existente buscando el registro
            $empleado = Empleado::findOrFail($id);
            Storage::delete('public/'.$empleado->foto);
            //Se agrega la nueva foto al los datos recibidos
            $datosEmpleado['foto'] = $request->file('foto')->store('uploads', 'public');
        }
       
        //Buscamos el empleado y si lo encuentra lo actualiza
        Empleado::where('id','=',$id)->update($datosEmpleado);
        //Retornamos al form
        $empleado = Empleado::findOrFail($id);
        //return view('empleado.edit', compact('empleado'));
        return redirect('empleado')->with('mensaje', 'Empleado actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el empleado
        $empleado = Empleado::findOrFail($id);
        //Si hay una fto borramos el registro
        if(Storage::delete('public/'.$empleado->foto)){
            Empleado::destroy($id);
        }
        return redirect('empleado')->with('mensaje', 'Empleado borrado');
    }
}
