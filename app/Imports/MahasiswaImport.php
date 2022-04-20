<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithValidation;

HeadingRowFormatter::default('none');

class MahasiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $user = new User;
        $user->email = $row['Email'];
        $user->password = Hash::make($row['Password']);
        $user->save();
        $user->mahasiswa()->create([
            'nim' => $row['NIM'],
            'nama' => $row['Nama'],
            'alamat' => $row['Alamat'],
            'jurusan' => $row['Jurusan'],
            'tanggal_lahir' => Carbon::parse($row['Tanggal Lahir']),
        ]);

        return $user;
    }

    public function rules(): array
    {
        return [
            'Nama' => 'required|string|min:2|max:100',
            '*.Nama' => 'required|string|min:2|max:100',
            'NIM' => 'required|min:2|max:15',
            '*.NIM' => 'required|min:2|max:15',
            'Email' => 'required|string|email|max:100|unique:users',
            '*.Email' => 'required|string|email|max:100|unique:users',
            'Password' => 'required|min:6',
            '*.Password' => 'required|min:6',
            'Alamat' => 'required|string|min:2|max:100',
            '*.Alamat' => 'required|string|min:2|max:100',
            'Tanggal Lahir' => 'required|date',
            '*.Tanggal Lahir' => 'required|date',
            'Jurusan' => 'required|string|min:2|max:100',
            '*.Jurusan' => 'required|string|min:2|max:100',
        ];
    }
}
