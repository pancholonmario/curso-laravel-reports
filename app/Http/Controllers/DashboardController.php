<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    //Para proteger nuestras rutas vamos agregar lo siguiente:
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
       // dd($request->query('title')); 
        // echo $request->path();
        //echo '<br>';
       
        return view('test', [
            'title' => 'pancholon prueba'
        ]);
    }
}
