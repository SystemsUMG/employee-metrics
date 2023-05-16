<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Response\ResponseController;
use App\Models\Department;
use Exception;
use Illuminate\Http\Request;

class DepartmentController extends ResponseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $departments = Department::on($this->database)->get();
            $this->records = $departments;
            $this->result = true;
            $this->message = 'Departamentos consultados correctamente';
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
            'name'  => ['required'],
            'alias' => ['required'],
        ]);
        try {
            Department::on($this->database)->create($validate);
            $this->result = true;
            $this->message = 'Departamento creado correctamente';
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
        try {
            $department = Department::on($this->database)->find($id);
            $this->records = $department;
            $this->result = true;
            $this->message = 'Departamento consultado correctamente';
            $this->statusCode = 200;
        } catch (Exception $exception) {
            $this->message = $exception->getMessage();
        } finally {
            return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name'  => ['required'],
            'alias' => ['required'],
        ]);
        try {
            $department = Department::on($this->database)->find($id);
            $department->update($validate);
            $this->result = true;
            $this->message = 'Departamento actualizado correctamente';
            $this->statusCode = 200;
        } catch (Exception $exception) {
            $this->message = $exception->getMessage();
        } finally {
            return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $department = Department::on($this->database)->find($id);
            $department->delete();
            $this->result = true;
            $this->message = 'Departamento eliminado correctamente';
            $this->statusCode = 200;
        } catch (Exception $exception) {
            $this->message = $exception->getMessage();
        } finally {
            return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
        }
    }
}
