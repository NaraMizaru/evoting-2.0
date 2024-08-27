<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;

    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }

    public function pemilu()
    {
        return $this->belongsTo(Pemilu::class);
    }
}
