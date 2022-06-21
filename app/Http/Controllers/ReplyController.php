<?php

namespace App\Http\Controllers;

use App\Events\ReplyCreated;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $reply = auth()->user()->replies()->create([
            'text' => $request->text,
            'ticket_id' => $ticket->id,
        ]);

        event(new ReplyCreated($reply,auth()->user()));

        return back();
    }
}
