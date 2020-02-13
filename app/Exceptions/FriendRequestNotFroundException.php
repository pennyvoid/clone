<?php

namespace App\Exceptions;

use Exception;

class FriendRequestNotFroundException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json([
            'errors' => [
                'code' => 404,
                'title' => 'Friend request not found',
            ]
            ],404);
    }
}
