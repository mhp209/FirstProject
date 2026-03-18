<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance_Enquiry extends Model
{
    use HasFactory;
    protected $fillable = ['generated_by','first_name','last_name','mobile_number','email', 'insurance_alias','message','status'];

    public function adminRole()
    {
        return $this->hasOne(Admin::class, 'id','generated_by');
    }

    public function Insurance()
    {
        return $this->hasOne(Insurance::class, 'alias','insurance_alias');
    }


}
