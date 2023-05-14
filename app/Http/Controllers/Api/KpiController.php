<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Response\ResponseController;
use App\Models\Kpi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class KpiController extends ResponseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kpiModel =  Kpi::on($this->database)->with(['kpiType', 'user'])->get();
        $this->records = $kpiModel;
        $this->result = true;
        $this->message = 'Registros consultados exitosamente';
        $this->statusCode = 200;
        return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'salary'      => ['required', 'string'],
            'study_level' => ['required', 'string'],
            'antiquity'   => ['required', 'string'],
            'absences'    => ['required', 'string'],
            'age'         => ['required', 'string'],
        ]);
        try {
            $user = 2; //TODO: set user from auth
            foreach ($validate as $key => $value) {
                $kpiType = $this->getKpiType($key);
                //Kpi de edad en tabla usuarios
                if ($kpiType->alias == 'age') {
                    User::on($this->database)->where('id', 1)->update(['age' => $value]);
                } else {
                     Kpi::on($this->database)->updateOrCreate(
                        ['kpi_type_id' => $kpiType->id, 'user_id' => $user],
                        ['value' => $value]
                    );
                }
            }

            $this->result = true;
            $this->message = 'Se almacenó el registro correctamente';
            $this->statusCode = 200;
            return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
        } catch (Exception $exception) {
            return $this->jsonResponse($this->result, $this->records, $this->message = $exception->getMessage(), $this->statusCode);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display a listing of kpis per user.
     */
    public function userKpis()
    {
        $kpis =  User::on($this->database)->with(['kpis.kpiType', 'department'])->get();

        $this->records = $kpis;
        $this->result = true;
        $this->message = 'Registros consultados exitosamente';
        $this->statusCode = 200;
        return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
    }

    /**
     * Display a listing of dynamic values.
     */
    public function dynamicValues()
    {
        $this->records = [
            'study_levels' => $this->study_levels,
            'antiquities'  => $this->antiquities,
        ];
        $this->result = true;
        $this->message = 'Registros consultados exitosamente';
        $this->statusCode = 200;
        return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
    }
}
