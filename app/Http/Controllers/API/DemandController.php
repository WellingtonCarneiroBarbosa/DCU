<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Demands\Demand;
use App\API\ApiResponses;

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

            return response()->json(ApiResponses::responseData($this->demand->all(), 200));

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessage($e->getMessage(), 1010));
            }

            return response()->json(ApiResponses::responseMessage('Error listing demands', 1010));

        }
    }
}
