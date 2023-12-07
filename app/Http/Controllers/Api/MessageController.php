<?php

namespace App\Http\Controllers\Api;

use App\Events\Chat\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use \Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function listMessages(User $user) {
        $userFrom = Auth::user()->id;
        $userTo = $user->id;

        $messages = Message::where(
            function ($query) use ($userFrom, $userTo) {
                $query->where([
                    'from_user' => $userFrom,
                    'to_user' => $userTo
                ]);
            }
        )->orWhere(
            function ($query) use ($userFrom, $userTo) {
                $query->where([
                    'from_user' => $userTo,
                    'to_user' => $userFrom
                ]);
            }
        )->orderBy('created_at', 'ASC')->get();

        return response()->json(['messages' => $messages], Response::HTTP_OK);
    }

    public function store(Request $request) {

        $message = new Message();
        $message->from_user = Auth::user()->id;
        $message->to_user = $request->to_user;
        $message->content = filter_var($request->content, FILTER_SANITIZE_STRIPPED);
        $message->save();

        Event::dispatch(new SendMessage($message, $request->to_user));
        // broadcast(new SendMessage($message, $request->to_user))->toOthers();
        // Broadcast::channel('orders.{orderId}', function (User $user, int $orderId) {
        //     return $user->id === Order::findOrNew($orderId)->user_id;
        // });
    }
}
