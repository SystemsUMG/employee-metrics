<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Response\ResponseController;
use App\Models\Department;
use App\Models\Kpi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class KpiController extends ResponseController
{
    /**
     * Display a listing of kpis per user.
     */
    public function index()
    {
        try {
            $records = [
                'totals'       => $this->totals(),
                'users'        => $this->userKpis(),
                'departments'  => $this->departments(),
                'study_levels' => $this->studyLevels(),
                'antiquities'  => $this->antiquities(),
            ];

            $this->records = $records;
            $this->result = true;
            $this->message = 'Registros consultados exitosamente';
            $this->statusCode = 200;
        } catch (Exception $exception) {
            $this->message = $exception->getMessage();
        } finally {
            return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
        }
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
            $user = 1; //TODO: set user from auth
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
        } catch (Exception $exception) {
            $this->message = $exception->getMessage();
        } finally {
            return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
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
     * Return a listing of kpis totals.
     */
    private function totals()
    {
        $kpis = Kpi::all();
        $users = User::all();
        $form = $kpis->where('kpi_type_id', 1)->sum('value');
        $absents = $kpis->where('kpi_type_id', 4)->sum('value');
        $update = $users->max('updated_at')->format('d/m/Y');
        $total = $users->count();

        return [
            [
                'title'          => 'Planilla',
                'value'          => "Q$form",
                'iconClass'      => 'ni ni-money-coins',
                'iconBackground' => 'bg-gradient-primary',
            ],
            [
                'title'          => 'Ausencias',
                'value'          => $absents,
                'iconClass'      => 'ni ni-fat-remove',
                'iconBackground' => 'bg-gradient-danger',
            ],
            [
                'title'          => 'Empleados',
                'value'          => $total,
                'iconClass'      => 'ni ni-badge',
                'iconBackground' => 'bg-gradient-success',
            ],
            [
                'title'          => 'Actualización',
                'value'          => $update,
                'iconClass'      => 'ni ni-calendar-grid-58',
                'iconBackground' => 'bg-gradient-warning',
            ],
        ];
    }

    /**
     * Return a listing of kpis per user.
     */
    public function userKpis()
    {
        return User::on($this->database)
            ->select('id', 'name', 'email', 'age', 'department_id', 'updated_at')
            ->with([
                'kpis' => function ($query) {
                    $query->select('id', 'user_id', 'kpi_type_id', 'value');
                },
                'kpis.kpiType',
                'department' => function ($query) {
                    $query->select('id', 'name');
                }
            ])
            ->get()
            ->map(function($user){
                $user->kpis = $user->kpis->map(function($kpi){
                    //Obtener dynamic values y setear coincidencia
                    if($kpi->kpiType->alias == 'study_level') {
                        $kpi->value = $this->study_levels[$kpi->value] ?? $kpi->value;
                    } else if($kpi->kpiType->alias == 'antiquity') {
                        $kpi->value = $this->antiquities[$kpi->value] ?? $kpi->value;
                    }
                    $kpi->type = $kpi->kpiType->alias; //Retornar unicamente alias y value
                    unset($kpi->id);
                    unset($kpi->user_id);
                    unset($kpi->kpi_type_id);
                    unset($kpi->kpiType);

                    return $kpi;
                });
                $user->date = $user->updated_at->format('d/m/Y');
                unset($user->updated_at);
                unset($user->department_id);

                return $user;
            });
    }

    /**
     * Return number of users per department.
     */
    public function departments()
    {
        $departments = Department::withCount('users')->get()->pluck('users_count', 'name');

        return [
            'labels' => $departments->keys()->all(),
            'values' => $departments->values()->all(),
        ];
    }

    /**
     * Return number of users per study level.
     */
    private function studyLevels()
    {
        $studyLevels = $this->dynamicKpis('study_level', $this->study_levels);
        $values = $studyLevels['values'];

        //Porcentajes
        $total = array_sum($values);
        $percentages = array_reduce($values, function ($result, $value) use ($total) {
            $percentage = round(($value / $total) * 100, 1);
            $result[] = $percentage;
            return $result;
        }, []);

        $studyLevels['percentages'] = $percentages;

        return $studyLevels;
    }

    /**
     * Return number of users per antiquity.
     */
    private function antiquities()
    {
        return $this->dynamicKpis('antiquity', $this->antiquities);
    }

    private function dynamicKpis($alias, $dynamic)
    {
        $kpis = Kpi::whereRelation('kpiType', function ($query) use ($alias) {
            $query->where('alias', $alias);
        })->get()->pluck('value')->countBy();

        $labels = array_values($dynamic);
        //Obtener key de study_level y retornar valor del modelo
        $values = array_map(function ($value) use ($kpis, $dynamic) {
            return $kpis->get(array_search($value, $dynamic), 0);
        }, $labels);

        return [
            'labels'      => $labels,
            'values'      => $values
        ];
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
