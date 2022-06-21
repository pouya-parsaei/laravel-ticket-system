<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        auth()->user()->tickets()->create($request->all() + ['file_path' => $this->uploadFile($request)]);

        return redirect()->back()->withSuccess('تیکت با موفقیت ثبت شد');
    }

    private function uploadFile($request)
    {
        return $request->has('file') ?
            $request->file->store('public')
            : null;
    }

    public function index()
    {
        $tickets = auth()->user()->tickets;

        return view('tickets.index',compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        return view('tickets.show',compact('ticket'));
    }

    public function close(Ticket $ticket)
    {
        $ticket->close();
        return back();
    }
}
