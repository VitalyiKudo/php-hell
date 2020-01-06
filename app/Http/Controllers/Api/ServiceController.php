<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Service as ServiceResource;

class ServiceController extends Controller
{
    /**
     * Get the services list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getServicesList()
    {
        $services = Service::all();

        return ServiceResource::collection($services);
    }
}
