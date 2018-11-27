<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Messages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Business\UserBusiness;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User as UserResource;

class UsersController extends Controller
{
    private $business;

    public function __construct(UserBusiness $business)
    {
        $this->business = $business;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->business->index();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = $this->business->store($request);

        return response()->json([
            "message" => Messages::SUCCESS,
            "data" => $user
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->business->update($request, $user);

        return response()->json([
            "message" => Messages::UPDATE,
            "data" => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->business->destroy($user);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
