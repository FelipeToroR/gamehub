<?php

namespace App\Imports;

use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;


class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = [
            'name'     => trim(ucwords(strtolower($row['nombres']))),
            'first_surname'     => trim(ucwords(mb_strtolower($row['apellido_paterno']))),
            'second_surname'     => ucwords(mb_strtolower(trim($row['apellido_materno']))),
            'course' => trim($row['curso']),
            'course_letter' => trim($row['letra']),
            'college' => trim($row['colegio']),
            'email_verified_at' => Carbon::now()->toDateTimeString()
        ];

        // Genera email
        if (!isset($row['correo']) || $row['correo'] == null) {
            $names = explode(' ', trim($row['nombres']));
            $user['email'] = strtolower(str_replace(' ', '.', $names[0] . ' ' . $row['apellido_paterno']) . '@gh.cl');
        } else {
            $user['email'] = strtolower($row['correo']);
        }

        // Genera password
        if (!isset($row['contrasena']) || $row['contrasena'] == null) {
            $user['password'] = Hash::make(mb_strtolower(trim($row['apellido_paterno'])));
        } else {
            $user['password'] = Hash::make(trim($row['contrasena']));
        }

        return new User($user);
    }

    public function rules(): array
    {
        return [
            'nombres' => ['required'],
            'apellido_paterno' => ['required'],
            'apellido_materno' => ['required'],
            'curso' => ['required'],
            'letra' => ['required'],
            'colegio' => ['required'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:users,email']

            /* 'name' => ['required', 'string', 'max:255'], */
            //'correo' => [ 'string', 'email', 'max:255', 'unique:users,email']
        ];

        // Validar si apellidos mas cortos, sirven como contraseña
    }


    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
        echo 'fallas';
    }
}
