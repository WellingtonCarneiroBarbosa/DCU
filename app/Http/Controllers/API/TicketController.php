<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tickets\Ticket;
use App\API;

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

            $data = $this->ticket->paginate(5);
            return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {

            if(config('app.degub')) {
                return response()->json(['data' => ApiMessages::responseMessage($e->getMessage(), 1010)]);
            }

            return response()->json(['data' => ApiMessages::responseMessage('Error listing ticket', 1010)]);

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $this->product->create($data);
            
            return response()->json(['data' => ApiMessage::responseMessage('Ticket opened successfully', 201)]);

        } catch (\Exception $e) {

            if(config('app.degub')) {
                return response()->json(['data' => ApiMessages::responseMessage($e->getMessage(), 1010)]);
            }

            return response()->json(['data' => ApiMessages::responseMessage('Error saving ticket', 1010)]);
        }
    }
}
