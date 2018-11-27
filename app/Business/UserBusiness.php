<?php

namespace App\Business;

use App\Models\User;

class UserBusiness {

    public function index()
    {
        return User::all();
    }

    public function store($request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->remember_token = str_random(10);

        $user->save();

        return $user;
    }

    public function update($request, $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
    }

    public function destroy($user)
    {
        $user->delete();
    }
}
