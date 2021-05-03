<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Recurs;
use App\Models\Usuari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuariController extends Controller
{

    public function showLogin()
    {
        /* $user = new Usuari();


        $user->username = 'a';
        $user->contrasenya = \bcrypt('a');
        $user->email = 'a';
        $user->nom = 'a';
        $user->cognoms = 'a';
        $user->rols_id = 2;
        $user->recursos_id = 1;

        $user->save(); */


        return view('pages.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $contrasenya = $request->input('contrasenya');

        $user = Usuari::where('username', $username)->first();

        if ($user !=null && Hash::check($contrasenya, $user->contrasenya)) {
            Auth::login($user);
            $response = redirect('/cecos');
        }
        else {
            $request->session()->flash('error', 'Usuari o contrasenya incorrectes');
            $response = redirect('/login')->withInput();
        }

        return $response;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $recursos = Recurs::all();
        $rols = Rol::all();
        return view('pages.cecos.usuaris.index', compact('recursos', 'rols'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuari  $usuari
     * @return \Illuminate\Http\Response
     */
    public function show(Usuari $usuari)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuari  $usuari
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuari $usuari)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuari  $usuari
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuari $usuari)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuari  $usuari
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuari $usuari)
    {
        //
    }
}
