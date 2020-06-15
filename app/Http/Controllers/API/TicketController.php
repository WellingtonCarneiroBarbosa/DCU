<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ticket;

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
            return response()->json(['data' => $data]);

        } catch (\Exception $e) {

            if(config('app.debug')) {

            }

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $this->product->create($data);

            return response()->json(['']);

        } catch (\Exception $e) {

            if(config('app.degub')) {

            }
            
        }
    }
}
