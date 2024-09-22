<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id','amount', 'date', 'description'];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
