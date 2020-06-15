<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tickets\Ticket;
use App\API\ApiResponses;

class TicketController extends Controller
{
    /**
     * @var Ticket
     * 
     */
    private $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function index()
    {
        try {

            return response()->json(ApiResponses::responseData($this->ticket->paginate(5), 200));

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(['data' => ApiResponses::responseMessage($e->getMessage(), 1010)]);
            }

            return response()->json(['data' => ApiResponses::responseMessage('Error listing ticket', 1010)]);

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $this->product->create($data);
            
            return response()->json(['data' => ApiMessage::responseMessage('Ticket opened successfully', 201)]);

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(['data' => ApiResponses::responseMessage($data, $e->getMessage(), 1010)]);
            }

            return response()->json(['data' => ApiResponses::responseMessage($data, 'Error saving ticket', 1010)]);
        }
    }
}
