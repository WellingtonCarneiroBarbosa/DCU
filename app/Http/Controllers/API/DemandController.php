<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Demands\Demand;
use App\API\ApiMessages;

class DemandController extends Controller
{
    /**
     * @var Demand
     * 
     */
    protected $demand;

    public function __construct(Demand $demand)
    {
        $this->demand = $demand;
    }

    public function index()
    {
        try {

            return response()->json(['data' => $this->demand->all()], 200);

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiMessages::responseMessage($e->getMessage(), 1010));
            }

            return response()->json(ApiMessages::responseMessage('Error listing demands', 1010));

        }
    }
}
