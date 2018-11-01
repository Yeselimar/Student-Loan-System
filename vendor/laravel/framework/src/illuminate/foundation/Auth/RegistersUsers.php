<?php

namespace Illuminate\Foundation\Auth;

use avaa\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

      //  $this->guard()->login($user);


        $file= $request->file('image_perfil');
        if(!is_null($file)) {
            $name = 'img-user_' . $user->cedula . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/images/perfil/';
            $file->move($path, $name);
            $img_perfil = new Imagen();
            $img_perfil->titulo = 'img_perfil';
            $img_perfil->url = '/images/perfil/' . $name;
            $img_perfil->verificado = true;
            $img_perfil->user_id = $user->id;
            $img_perfil->save();
        }
 
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
   
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
