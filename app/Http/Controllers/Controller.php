<?php

namespace App\Http\Controllers;

use App\Models\KpiType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public string $database;
    public array $study_levels;
    public array $antiquities;


    public function __construct(Request $request)
    {
        $this->database = $request->header('Database') ?? 'mysql';

        $this->study_levels = [
            1 => 'Educación Media',
            2 => 'Técnico',
            3 => 'Universidad',
            4 => 'Posgrado'
        ];

        $this->antiquities = [
            1 => 'Menos de un año',
            2 => 'Un año',
            3 => 'Dos años',
            4 => 'Tres años',
            5 => 'Cuatro años',
            6 => 'Más de cinco años',
        ];
    }

    public function getKpiType ($alias) {
        return KpiType::on($this->database)->where('alias', $alias)->first();
    }
}
