<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Response\ResponseController;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends ResponseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::on($this->database)->with('department')->get();
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'          => ['required'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required'],
            'age'           => ['required', 'integer'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
        ]);
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
            $user = User::on($this->database)->with('department')->find($id);
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name'          => ['required'],
            'email'         => ['required', 'email', 'unique:users,email,'.$id],
            'age'           => ['required', 'integer'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
        ]);
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
