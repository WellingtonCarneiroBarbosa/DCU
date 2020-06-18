<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketResponseFromSupport;

class TicketController extends Controller
{
    private $ticket, $ticketResponse;

    public function __construct(Ticket $ticket, TicketResponseFromSupport $ticketResponse)
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

            $data['ticket_id'] = $id;
    
            $reponse = $this->ticketResponse->create($data);

            $ticket->update(['user_id' => auth()->user()->id]);
    
            return "ticket respondido com sucesso.";
        } catch (\Exception $e) {
            if(config('app.debug')) {
                return $e->getMessage();
            }

            return "erro ao responder ticket :v";
        }
    }

    /**
     * Return tickets in processing
     * of the auth user
     * 
     */
    public function processing ()
    {
        $tickets = $this->ticket->where('user_id', auth()->user()->id)->orderBy('created_at', 'ASC')->paginate(9);

        return view('app.tickets.processing', [
            'tickets' => $tickets
        ]);
    }
}
