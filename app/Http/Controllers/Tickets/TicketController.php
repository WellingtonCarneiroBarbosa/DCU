<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketResponse;
use SebastianBergmann\Type\ObjectType;

class TicketController extends Controller
{
    /**
     * @var Ticket
     *
     */
    private $ticket;

    /**
     * TicketController constructor.
     * @param Ticket $ticket
     *
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Show opened tickets.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getOpenedTickets()
    {
        $tickets = $this->ticket->where('user_id', null)->orderBy('created_at', 'DESC')->paginate(6);

        $qtd_in_progress_tickets = $this->ticket->where('user_id', auth()->user()->id)->count();
        
        return view('home', [
            'tickets' => $tickets, 'qtd_in_progress_tickets' => $qtd_in_progress_tickets
        ]);
    }

    public function showTicket($ticket_id)
    {
        $ticket = $this->ticket->withTrashed()->findOrFail($ticket_id);

        return view('app.tickets.show', [
            'ticket' => $ticket
        ]);
    }

    public function getTicketMessages($ticket_id)
    {
        $ticket = $this->ticket->withTrashed()->findOrFail($ticket_id);

        $ticket_messages = TicketResponse::latest()->where('ticket_id', $ticket_id)->paginate(5);

        return view('app.tickets.messages', [
            'ticket' => $ticket, 'ticket_messages' => $ticket_messages
        ]);
    }

    public function getInProgressTickets()
    {
        $tickets = $this->ticket->where('user_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(6);

        return view('app.tickets.inProgress', [
            'tickets' => $tickets
        ]);
    }

    public function getClosedTickets()
    {
        $tickets = $this->ticket->onlyTrashed()->where('user_id', auth()->user()->id)->paginate(6);

        return view('app.tickets.solved', [
            'tickets' => $tickets
        ]);
    }

    /**
     * @param $ticket_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function getResponseTicketView($ticket_id)
    {
        $ticket = $this->ticket->findOrFail($ticket_id);

        $responses = TicketResponse::latest()->get();

        return view('app.tickets.response', [
            'ticket' => $ticket, 'responses' => $responses
        ]);
    }

    public function responseTicket(Request $request, $ticket_id)
    {
        $ticket = $this->ticket->findOrFail($ticket_id);

        try {
            $response = TicketResponse::create([
                'client_id' => $ticket['client_id'],
                'responsible_id' => auth()->user()->id,
                'ticket_id' => $ticket_id,
                'message' => $request['message']
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        /**
         * If it does not has
         * a responsible
         *
         */
        $ticket_data = $ticket->getAttributes();
        if(! $ticket_data['user_id']) {
            try {
                $ticket_data['user_id'] = auth()->user()->id;
                $this->ticket->findOrFail($ticket_id)->update($ticket_data);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        return redirect()->route('tickets.messages', [$ticket_id])->with(['success' => 'Resposta enviada com sucesso!']);
    }
}
