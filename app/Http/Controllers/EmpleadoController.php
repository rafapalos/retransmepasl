<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    // Función para cuando aun no te has logueado, no se pueda acceder a las demás páginas.
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $empleados = Empleado::all();
        return view('empleado.index')->with('empleados', $empleados);
    }

    // Función para añadir empleado
    public function create() {
        $delegacionesEmpleados = DB::select("SELECT id, nombreEmpresa FROM delegacions");
        $cargosEmpleados = DB::select("SELECT id, nombreCargo FROM cargos");

        return view('empleado.create', ['delegacionesEmpleados' => $delegacionesEmpleados, 'cargosEmpleados' => $cargosEmpleados]);
    }

    public function store(Request $request) {
        $request->validate([
            'num_documento' => 'required|unique:empleados'
        ]);

        $empleados = new Empleado();

        $IdDelegacionAsignado = $request->get('empresa');
        $idDelegacion = stristr($IdDelegacionAsignado, "-", true );
        $delegacionA = stristr($IdDelegacionAsignado, "-", false );
        $delegacion = substr($delegacionA, 1);

        $IdCargoAsignado = $request->get('cargo');
        $idCargo = stristr($IdCargoAsignado, "-", true );
        $cargoA = stristr($IdCargoAsignado, "-", false );
        $cargo = substr($cargoA, 1);

        $empleados-> nombre = $request->get('nombre');
        $empleados-> apellidos = $request->get('apellidos');
        $empleados-> documento = $request->get('documento');
        $empleados-> num_documento = $request->get('num_documento');
        $empleados-> fechaNacimiento = $request->get('fechaNacimiento');
        $empleados-> estado = $request->get('estado');
        $empleados-> empresa = $delegacion;
        $empleados-> cargo = $cargo;
        $empleados-> id_delegacion = $idDelegacion;
        $empleados-> id_cargo = $idCargo;

        $empleados->save();

        return redirect('/empleados');
    }

    // Función para el botón de editar del dataTables
    public function edit($id) {
        $empleado = Empleado::find($id);

        $delegacionesEdit = DB::select("SELECT id, nombreEmpresa FROM delegacions");
        $cargosEdit = DB::select("SELECT id, nombreCargo FROM cargos");

        return view('empleado.edit', ['delegacionesEdit' => $delegacionesEdit, 'cargosEdit' => $cargosEdit])->with('empleado',$empleado);
    }

    public function update(Request $request, $id) {
        $empleado = Empleado::find($id);

        $IdDelegacionAsignado = $request->get('empresa');
        $idDelegacion = stristr($IdDelegacionAsignado, "-", true );
        $delegacionA = stristr($IdDelegacionAsignado, "-", false );
        $delegacion = substr($delegacionA, 1);

        $IdCargoAsignado = $request->get('cargo');
        $idCargo = stristr($IdCargoAsignado, "-", true );
        $cargoA = stristr($IdCargoAsignado, "-", false );
        $cargo = substr($cargoA, 1);

        $empleado-> nombre = $request->get('nombre');
        $empleado-> apellidos = $request->get('apellidos');
        $empleado-> documento = $request->get('documento');
        $empleado-> num_documento = $request->get('num_documento');
        $empleado-> fechaNacimiento = $request->get('fechaNacimiento');
        $empleado-> estado = $request->get('estado');
        $empleado-> empresa = $delegacion;
        $empleado-> cargo = $cargo;
        $empleado-> id_delegacion = $idDelegacion;
        $empleado-> id_cargo = $idCargo;

        $empleado->save();

        return redirect('/empleados');
    }

    // Función para el botón de eliminar del dataTables
    public function destroy($id) {
        $empleado = Empleado::find($id);
        $empleado->delete();
        return redirect('/empleados');
    }
}
