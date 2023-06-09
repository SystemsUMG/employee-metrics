<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Response\ResponseController;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends ResponseController
{
    protected array $phoneRule = ['phone.*' => 'El teléfono no es válido o ya ha sido registrado.'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::on($this->database)
                ->with('department')
                ->get()
                ->map(function($user){
                    $user->date = $user->updated_at->format('d/m/Y');
                    return $user;
                });
            $this->records = $users;
            $this->result = true;
            $this->message = 'Usuarios consultados correctamente';
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
        $request->merge(['phone' => $this->formatPhone($request->phone)]);
        $validate = $request->validate([
            'name'          => ['required'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required'],
            'age'           => ['required', 'integer'],
            'phone'         => ['required', 'min:12', 'max:12', 'unique:users,phone'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
        ], $this->phoneRule);
        try {
            $validate['password'] = Hash::make($request->password);
            User::on($this->database)->create($validate);
            $this->result = true;
            $this->message = 'Usuario creado correctamente';
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
            $user = User::on($this->database)->with('department')->findOrFail($id);
            $this->records = $user;
            $this->result = true;
            $this->message = 'Usuario consultado correctamente';
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
        $request->merge(['phone' => $this->formatPhone($request->phone)]);
        $validate = $request->validate([
            'name'          => ['required'],
            'email'         => ['required', 'email', 'unique:users,email,'.$id],
            'age'           => ['required', 'integer'],
            'phone'         => ['required', 'min:12', 'max:12', 'unique:users,phone,'.$id],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
        ], $this->phoneRule);
        try {
            if ($request->password) {
                $validate['password'] = Hash::make($request->password);
            }
            $user = User::on($this->database)->find($id);
            $user->update($validate);
            $this->result = true;
            $this->message = 'Usuario actualizado correctamente';
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
            $user = User::on($this->database)->find($id);
            $user->delete();
            $this->result = true;
            $this->message = 'Usuario eliminado correctamente';
            $this->statusCode = 200;
        } catch (Exception $exception) {
            $this->message = $exception->getMessage();
        } finally {
            return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
        }
    }
}
