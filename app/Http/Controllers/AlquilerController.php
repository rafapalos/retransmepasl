<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alquiler;

class AlquilerController extends Controller
{
   // Función para cuando aun no te has logueado, no se pueda acceder a las demás páginas.
   public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
    $alquileres = Alquiler::all();
        return view('alquiler.index')->with('alquileres', $alquileres);
    }

    // Función para añadir cargo
    public function create() {
        return view('alquiler.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nombreEmpresa' => 'required|unique:alquilers'
        ]);
        $alquileres = new Alquiler();

        $alquileres-> nombreEmpresa = $request->get('nombreEmpresa');
        $alquileres-> localidad = $request->get('localidad');

        $alquileres->save();

        return redirect('/alquileres');
    }


    // Función para el botón de editar del dataTables
    public function edit($id) {
        $alquiler = Alquiler::find($id);
        return view('alquiler.edit')->with('alquiler',$alquiler);
    }

    public function update(Request $request, $id) {
        $alquiler = Alquiler::find($id);

        $alquiler-> nombreEmpresa = $request->get('nombreEmpresa');
        $alquiler-> localidad = $request->get('localidad');

        $alquiler->save();

        return redirect('/alquileres');
    }

    // Función para el botón de eliminar del dataTables
    public function destroy($id) {
        $alquiler = Alquiler::find($id);
        $alquiler->delete();
        return redirect('/alquileres');
    }
}
