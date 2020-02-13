<?php

namespace App\Http\Controllers;

use App\Exceptions\FriendRequestNotFroundException;
use App\Exceptions\ValidationErrorException;
use App\Friend;
use App\Http\Resources\Friend as FriendResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class FriendRequestResponseController extends Controller
{
    public function store()
    {
        try {
            $data = request()->validate([
                'user_id' => 'required',
                'status' => 'required',
            ]);
        } catch (ValidationException $exception) {
            throw new ValidationErrorException(json_encode($exception->errors()));
        }
        try {
            $friendRequest = Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->id())->firstOrFail();
        } catch (ModelNotFoundException $error) {
            throw new FriendRequestNotFroundException();
        }



        $friendRequest->update(array_merge($data, ['confirmed_at' => now()]));

        return new FriendResource($friendRequest);
    }

    public function destroy()
    {

        $data = request()->validate([
            'user_id' => 'required',
        ]);
        try {
            Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->id())->firstOrFail()->delete();
        } catch (ModelNotFoundException $error) {
            throw new FriendRequestNotFroundException();
        }
        return response()->json([], 204);
    }
}
