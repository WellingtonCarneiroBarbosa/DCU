<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * @var Demand
     * 
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->withTrashed()->where('id', '!=', auth()->user()->id)->latest()->paginate();

        return view('app.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.users.create');
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

            $defaultPassword = bcrypt(12345678);

            $data['password'] = $defaultPassword;

            $this->user->create($data);

            return redirect()->route('users.index')->with(['success' => 'Usuário cadastrado com sucesso']);
        
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }

            return redirect()->back()->with(['error' => 'Erro ao cadastrar usuário']);
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
        $user = $this->user->findOrFail($id);

        return view('app.users.show', [
            'user' => $user
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
        $user = $this->user->findOrFail($id);

        return view('app.users.edit', [
            'user' => $user
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

            $this->user->findOrFail($id)->update($data);

            return redirect()->route('users.index')->with(['success' => 'Usuário editado com sucesso']);
        
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }

            return redirect()->back()->with(['error' => 'Erro ao editar usuário']);
        }
    }

    /**
     * Disable user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $this->user->destroy($id);

            return redirect()->route('users.index')->with(['success' => 'Usuário desativado com sucesso']);
        
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }

            return redirect()->back()->with(['error' => 'Erro ao desativar usuário']);
        }
    }

    public function confirmDelete($id) 
    {
        $user = $this->user->findOrFail($id);

        return view('app.users.confirmDelete', [
            'user' => $user
        ]);
    }

    /**
     * Enable user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {

            $this->user->onlyTrashed()->findOrFail($id)->restore();

            return redirect()->route('users.index')->with(['success' => 'Usuário ativado com sucesso']);
        
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }

            return redirect()->back()->with(['error' => 'Erro ao ativar usuário']);
        }
    }

    public function confirmRestore($id) 
    {
        $user = $this->user->onlyTrashed()->findOrFail($id);

        return view('app.users.confirmRestore', [
            'user' => $user
        ]);
    }
}
