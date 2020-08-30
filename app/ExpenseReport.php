<?php

namespace App;

use App\User;
use App\Expense;
use Illuminate\Database\Eloquent\Model;

class ExpenseReport extends Model
{
    //relaciones de muchos 

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    //aqui muchos Reportes a 1 Solo usuario

    public function user(){
        return $this->belongsTo(User::class);
    }

    //aqui no
    
}
