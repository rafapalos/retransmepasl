<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\DB;

class VehiculoController extends Controller {
    // Función para cuando aun no te has logueado, no se pueda acceder a las demás páginas.
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $vehiculos = Vehiculo::all();
        return view('vehiculo.index')->with('vehiculos', $vehiculos);
    }

    // Función para añadir vehiculo
    public function create() {
        $delegacionesVehiculos = DB::select("SELECT id, nombreEmpresa FROM delegacions");
        $alquileresVehiculos = DB::select("SELECT id, nombreEmpresa FROM alquilers");

        return view('vehiculo.create', ['delegacionesVehiculos' => $delegacionesVehiculos, 'alquileresVehiculos' => $alquileresVehiculos]);
    }

    public function store(Request $request) {
        $request->validate([
            'matricula' => 'required|unique:vehiculos'
        ]);

        $vehiculos = new Vehiculo();

        $IdDelegacionAsignado = $request->get('empresa');
        $idDelegacion = stristr($IdDelegacionAsignado, "-", true );
        $delegacionA = stristr($IdDelegacionAsignado, "-", false );
        $delegacion = substr($delegacionA, 1);

        $IdAlquilerAsignado = $request->get('alquiler');
        $idAlquiler = stristr($IdAlquilerAsignado, "-", true );
        $alquilerA = stristr($IdAlquilerAsignado, "-", false );
        $alquiler = substr($alquilerA, 1);

        $vehiculos-> marca                = $request->get('marca');
        $vehiculos-> modelo               = $request->get('modelo');
        $vehiculos-> matricula            = $request->get('matricula');
        $vehiculos-> empresa              = $delegacion;
        $vehiculos-> id_delegacion        = $idDelegacion;
        $vehiculos-> estado               = $request->get('estado');
        $vehiculos-> propiedad            = $request->get('propiedad');
        $vehiculos-> alquiler             = $alquiler;
        $vehiculos-> id_alquiler          = $idAlquiler;
        $vehiculos-> fechaAlquilerDesde   = $request->get('fechaAlquilerDesde');
        $vehiculos-> fechaAlquilerHasta   = $request->get('fechaAlquilerHasta');
        $vehiculos->save();

        return redirect('/vehiculos');
    }

    // Función para el botón de editar del dataTables
    public function edit($id)
    {
        $delegacionesEdit = DB::select("SELECT id, nombreEmpresa FROM delegacions");
        $alquileresEdit = DB::select("SELECT id, nombreEmpresa FROM alquilers");

        $vehiculo = Vehiculo::find($id);
        return view('vehiculo.edit', ['delegacionesEdit' => $delegacionesEdit, 'alquileresEdit' => $alquileresEdit])->with('vehiculo',$vehiculo);
    }

    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::find($id);
       
        $IdDelegacionAsignado = $request->get('empresa');
        $idDelegacion = stristr($IdDelegacionAsignado, "-", true );
        $delegacionA = stristr($IdDelegacionAsignado, "-", false );
        $delegacion = substr($delegacionA, 1);

        $IdAlquilerAsignado = $request->get('alquiler');
        $idAlquiler = stristr($IdAlquilerAsignado, "-", true );
        $alquilerA = stristr($IdAlquilerAsignado, "-", false );
        $alquiler = substr($alquilerA, 1);

        $vehiculo-> marca                = $request->get('marca');
        $vehiculo-> modelo               = $request->get('modelo');
        $vehiculo-> matricula            = $request->get('matricula');
        $vehiculo-> empresa              = $delegacion;
        $vehiculo-> id_delegacion        = $idDelegacion;
        $vehiculo-> estado               = $request->get('estado');
        $vehiculo-> propiedad            = $request->get('propiedad');
        $vehiculo-> alquiler             = $alquiler;
        $vehiculo-> id_alquiler          = $idAlquiler;
        $vehiculo-> fechaAlquilerDesde   = $request->get('fechaAlquilerDesde');
        $vehiculo-> fechaAlquilerHasta   = $request->get('fechaAlquilerHasta');

        $vehiculo->save();

        return redirect('/vehiculos');
    }

    // Función para el botón de eliminar del dataTables
    public function destroy($id)
    {
        $vehiculo = Vehiculo::find($id);
        $vehiculo->delete();
        return redirect('/vehiculos');
    }
}
