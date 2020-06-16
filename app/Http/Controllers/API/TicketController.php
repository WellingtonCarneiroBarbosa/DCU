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
                return response()->json(ApiResponses::responseMessage($e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessage('Error listing ticket', 500));

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $this->ticket->create($data);
            
            return response()->json(ApiResponses::responseMessage('Ticket opened successfully', 201));

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($data, $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($data, 'Error saving ticket', 500));
        }
    }
}
