<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Models\Avinode;

class AvinodeController extends Controller
{
    protected $avinode;

    public function __construct(Avinode $avinode)
    {
        $this->avinode = $avinode;
    }

    public function index() {

        dd($this->avinode->all());
    }
}
