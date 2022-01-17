<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function messages($id){
        $user = User::find($id);
        $chat = $user->chats()->first()->id;

        return redirect("/users/{$id}/messages/{$chat}");
    }


    public function show($user_id, $chat_id){

        $user = User::find($user_id);
        $chat = Chat::find($chat_id);

        $chats = $user->chats()->get();

        $messages = $chat->messages()->orderBy('id')->get();

        return view('pages.messages', ['user'=>$user,'chat'=>$chat,'chats'=>$chats, 'messages'=>$messages ]);

    }

    public function createChat($id){

        $user = User::find(Auth::user()->id);

        $chats_of_user = $user->chats()->get();
        foreach($chats_of_user as $chat){
            if($chat->users()->get()->contains('id', $id)){
                
                $chats = $user->chats()->orderBy('updated_at', 'desc')->get();
                $messages = $chat->messages()->orderBy('id')->get();
                return view('pages.messages', ['user'=>$user,'chat'=>$chat,'chats'=>$chats, 'messages'=>$messages ]);
            }
            
        }

        $newChat = new Chat();
        $newChat->save();

        $newChat->users()->attach(Auth::id());
        $newChat->users()->attach($id);
        
    

        //$chats = $user->chats()->orderBy('updated_at', 'desc')->get();
        $chats = $user->chats()->get();

        $messages = $newChat->messages()->orderBy('id','desc')->get();

        return view('pages.messages', ['user'=>Auth::user(),'chat'=>$newChat,'chats'=>$chats, 'messages'=>$messages ]);
    }

    public function createMessage($user_id, $chat_id, Request $request){
        $message = new Message();

        $message->text = $request->input('text');
        $message->user_id = $user_id;
        $message->chat_id = $chat_id;

        $message->save();

        return redirect()->back();
    }
}
