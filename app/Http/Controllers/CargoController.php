<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;

class CargoController extends Controller
{
    // Función para cuando aun no te has logueado, no se pueda acceder a las demás páginas.
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
        $cargos = Cargo::all();
        return view('cargo.index')->with('cargos', $cargos);
    }

    // Función para añadir cargo
    public function create() {
        return view('cargo.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nombreCargo' => 'required|unique:cargos'
        ]);
        $cargos = new Cargo();

        $cargos-> nombreCargo = $request->get('nombreCargo');

        $cargos->save();

        return redirect('/cargos');
    }


    // Función para el botón de editar del dataTables
    public function edit($id) {
        $cargo = Cargo::find($id);
        return view('cargo.edit')->with('cargo',$cargo);
    }

    public function update(Request $request, $id) {
        $cargo = Cargo::find($id);

        $cargo-> nombreCargo = $request->get('nombreCargo');

        $cargo->save();

        return redirect('/cargos');
    }

    // Función para el botón de eliminar del dataTables
    public function destroy($id) {
        $cargo = Cargo::find($id);
        $cargo->delete();
        return redirect('/cargos');
    }
}
