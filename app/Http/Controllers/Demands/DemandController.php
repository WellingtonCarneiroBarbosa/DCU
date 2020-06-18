<?php

namespace App\Http\Controllers\Demands;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Demands\Demand;
use App\Models\Tickets\Ticket;

class DemandController extends Controller
{
    /**
     * @var Demand
     * 
     */
    private $demand;

    public function __construct(Demand $demand)
    {
        $this->demand = $demand;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demands = $this->demand->latest()->get();

        return view('app.demands.index', [
            'demands' => $demands
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.demands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $data = $this->demand->create($data);

            return redirect()->route('demands.index')->with(['success' => 'Demanda cadastrada com sucesso']);

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }

            return redirect()->back()->with(['error' => 'Erro ao cadastrar demanda']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $demand = $this->demand->findOrFail($id);

        return view('app.demands.show', [
            'demand' => $demand
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $demand = $this->demand->findOrFail($id);

        return view('app.demands.edit', [
            'demand' => $demand
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $data = $request->all();

            $data = $this->demand->findOrFail($id)->update($data);

            return redirect()->back()->with(['success' => 'Demanda editada com sucesso']);

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }

            return redirect()->back()->with(['error' => 'Erro ao editar demanda']);

        }
    }

    public function confirmDelete($id)
    {
        $demand = $this->demand->findOrFail($id);

        $howManyTicketsWithThisDemand = Ticket::where('demand_id', $demand['id'])->count();

        return view('app.demands.confirmDelete', [
            'demand' => $demand, 'howManyTicketsWithThisDemand' => $howManyTicketsWithThisDemand
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $this->demand->destroy($id);

            return redirect()->route('demands.index')->with(['success' => 'Demanda deletada com sucesso']);

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }

            return redirect()->back()->with(['error' => 'Erro ao deletar demanda']);

        }
    }
}
