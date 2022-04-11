<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function requestor()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
