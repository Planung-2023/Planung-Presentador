<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresentadorController extends Controller
{
    public function presentador(){
        return view("presentador.presentador");
    }

    

}
