<?php

namespace App\Http\Controllers\Api;

use App\Events\Chat\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{

    public function listMessages(User $user) {
        $userFrom = Auth::user()->id;
        $userTo = $user->id;


        /**
         * [from = $userFrom && to = $userTo]
         * OR
         * [From = $userTo && to = $userFrom ]
         *
         */

         $messages = Message::where(
                function ($query) use ($userFrom, $userTo){
                    $query->where([
                        'from' => $userFrom,
                        'to' => $userTo
                    ]);
                }
            )
            ->orWhere(
                function ($query) use ($userFrom, $userTo){
                    $query->where([
                        'from' => $userTo,
                        'to' => $userFrom
                    ]);
                }
            )
            ->orderBy('created_at', 'ASC')
            ->get();

            return response()->json([
                'messages' => $messages
            ], Response::HTTP_OK);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        // dd($request->all());
        $message = new Message();
        $message->from = Auth::id();
        $message->to = $request->to;
        $message->content = $request->content;
        $message->save();

        Event::dispatch(new SendMessage($message, $request->to));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
