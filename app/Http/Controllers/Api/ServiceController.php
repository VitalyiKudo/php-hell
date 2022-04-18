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
    
    /**
     * @OA\Info(title="Jet on Set API", version="0.1")
     * 
     * @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      in="header",
     *      name="bearerAuth",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="JWT",
     * )
     * 
     */
    
    public function getServicesList()
    {
        $services = Service::all();

        return ServiceResource::collection($services);
    }
}
