<?php

namespace App\Http\Controllers\Demands;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Demands\Demand;

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

    public function index() 
    {
        return "index";
    }

    public function create()
    {
        return view('app.demands.create');
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $this->demand->create($data);

            return redirect()->back()->with(['success' => 'Demanda salva com sucesso']);

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return redirect()->back()->with(['error' => $e]);
            }

            return redirect()->back()->with(['error' => 'Erro ao salvar demanda']);

        }
    }
}
