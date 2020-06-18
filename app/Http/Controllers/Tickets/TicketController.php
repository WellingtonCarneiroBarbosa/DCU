<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketResponse;

class TicketController extends Controller
{
    private $ticket, $ticketResponse;

    public function __construct(Ticket $ticket, TicketResponse $ticketResponse)
    {
        $this->ticket = $ticket;
        $this->ticketResponse = $ticketResponse;
    }

    public function makeResponse($id)
    {
        $ticket = $this->ticket->findOrFail($id);

        return view('app.tickets.response', [
            'ticket' => $ticket
        ]);
    }


    /**
     * Return form to response
     * a ticket
     * 
     */
    public function response(Request $request, $id) {
        try {
            $ticket = $this->ticket->findOrFail($id);

            $data = $request->all();
    
            $reponse = $this->ticketResponse->create($data);
    
            return "ticket respondido com sucesso.";
        } catch (\Exception $e) {
            if(config('app.debug')) {
                return $e->getMessage();
            }

            return "erro ao responder ticket :v";
        }
    }
}
