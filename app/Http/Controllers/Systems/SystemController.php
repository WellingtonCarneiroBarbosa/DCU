<?php

namespace App\Http\Controllers\Systems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Systems\System;
use Illuminate\Support\Str;

class SystemController extends Controller
{

    private $system;

    public function __construct(System $system) 
    {
        $this->system = $system;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $systems = $this->system->paginate(10);

        return view('app.systems.index', [
            'systems' => $systems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.systems.create');
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

            /**
             * Get all systems in database
             * 
             */
            $systems = $this->system->all();

            /**
             * Get each token system
             * 
             */
            $tokens_list = [];

            foreach($systems as $system) 
            {
                /**
                 * Appends each token 
                 * to tokens_list
                 * 
                 */
                array_push($tokens_list, $system->token);
            }

            /**
             * Generate a unique token from a 
             * tokens list
             * (and attribue the value
             * in $data['token'])
             * 
             */
            $data['token'] = $this->generateUniqueTokenFromTokensList($tokens_list);

            $data = $this->system->create($data);

            return redirect()->route('systems.index')->with(['success' => 'Sistema cadastrado com sucesso']);

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }

            return redirect()->back()->with(['error' => 'Erro ao cadastrar o sistema']);

        }
    }

    public function confirmDestroy($id) 
    {
        $system = $this->system->findOrFail($id);

        return view('app.systems.confirmDestroy', [
            'system' => $system
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

            $this->system->destroy($id);   

            return redirect()->route('systems.index')->with(['success' => 'Sistema deletado com sucesso']);

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }

            return redirect()->back()->with(['error' => 'Erro ao deletar demanda']);

        }
    }

    /**
     * Generate unique token from
     * a tokens list
     * 
     */
    public function generateUniqueTokenFromTokensList($tokens_list)
    {
        do {
            $unique_token = Str::random(80);
        }
        while(\in_array($unique_token, $tokens_list));

        return $unique_token;
    }
}
