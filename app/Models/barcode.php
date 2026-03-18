<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barcode extends Model
{
    use HasFactory;

    protected $table = 'barcode';

    protected $fillable = ['barcode','type','wheeler_type','assign_to','customer_id','is_online_product','status','uploaded_by','code'];

    public function customer()
    {
       return $this->hasone(User::class,'id','customer_id');
    }

    public function vehicle()
    {
       return $this->hasone(Vehicle::class,'barcode','barcode');
    }

    public function adminRole()
    {
        return $this->hasOne(Admin::class, 'id','uploaded_by');
    }

    public function adminRoleSeller()
    {
        return $this->hasOne(Admin::class, 'id','assign_to');
    }

}
