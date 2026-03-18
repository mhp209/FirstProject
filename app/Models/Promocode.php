<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function adminRole()
    {
        return $this->hasOne(Admin::class, 'id','assign_to');
    }
}
