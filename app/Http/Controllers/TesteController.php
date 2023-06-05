<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class TesteController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return $this->response('Autorizado', 200);
    }
}
