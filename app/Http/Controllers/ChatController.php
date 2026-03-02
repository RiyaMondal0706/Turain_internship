<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Events\ChatMessageSent;

class ChatController extends Controller
{
    public function users()
    {
        $id = session()->get('user_id');

        return DB::table('users')
            ->where('id', '<>', $id)
            ->where('status', 1)
            ->get();
    }

public function messages($userId)
{
    $fromId = session()->get('user_id');
    $toId   = $userId;

    $messages = DB::table('ch_messages')
        ->where(function ($q) use ($fromId, $toId) {
            $q->where('from_id', $fromId)
              ->where('to_id', $toId);
        })
        ->orWhere(function ($q) use ($fromId, $toId) {
            $q->where('from_id', $toId)
              ->where('to_id', $fromId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return view('chat.partials.messages', compact('messages', 'fromId'));
}
    public function send(Request $request)
    {
        $from = session()->get('user_id');

        DB::table('ch_messages')->insert([
            'id' => (string) Str::uuid(),
            'from_id' => $from,
            'to_id' => $request->to_id,
            'body' => $request->message,
            'created_at' => now(),
        ]);

        broadcast(new ChatMessageSent([
            'from_id' => $from,
            'to_id' => $request->to_id,
            'message' => $request->message,
            'sender_name' => DB::table('users')->where('id', $from)->value('name'),
            'sender_role' => DB::table('users')->where('id', $from)->value('role'),
            'time' => now()->format('h:i A'),
        ]))->toOthers();

        return response()->json(['success' => true]);
    }

}