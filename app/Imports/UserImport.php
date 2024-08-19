<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $kelas_id;

    public function __construct($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }

    public function model(array $row)
    {
        return new User([
            'fullname' => $row[1],
            'username' => $row[2] ?? Str::random(8),
            'email' => $row[3],
            'password' => bcrypt($row[4]) ?? Str::random(8),
            'unencrypted_password' => $row[4] ?? Str::random(8),
            'role' => $row[5],
            'kelas_id' => $this->kelas_id,
        ]);
    }
}
