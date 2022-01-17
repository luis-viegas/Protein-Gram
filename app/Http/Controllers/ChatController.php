<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function messages(){
        $user = Auth::user();
        $user_id=$user->id;
        $chat = $user->chats()->first()->id;
        if(!$chat)  return redirect("/");
        return redirect("/messages/{$chat}");

    }
    public function userMessages($user_id){
        $user = Auth::user();
        if(!$user) 
            return redirect("/");
        if($user->is_admin){
            $user = User::find($user_id);
            if(!$user) return redirect("/");
            $chat = $user->chats()->first()->id;
            return $this->user_show($user_id,$chat);
        }else{
            return redirect("/messages");
        }

    }

    public function userShow($user_id, $chat_id){
        $currentUser = Auth::user();
        $user = null;
        $chat = null;
        if(!$currentUser || !($currentUser->is_admin)){
            return redirect("/messages");
        }
        $user = User::find($user_id);
        if(!$user)return redirect("/messages");
        $chats = $user->chats();
        $chat = $chats->find($chat_id);
        if(!$chat)return redirect("/users/{$user_id}/messages");
        $messages = $chat->messages()->orderBy('id')->get();
        return view('pages.messages', ['user'=>$user,'chat'=>$chat,'chats'=>$user->chats()->get(), 'messages'=>$messages ]);
    }

    public function show($chat_id){
        $user = Auth::user();
        if(!$user)return redirect("/");
        $chats = $user->chats();
        $chat = $chats->find($chat_id);
        if(!$chat)return redirect("/messages");
        $messages = $chat->messages()->orderBy('id')->get();
        return view('pages.messages', ['user'=>$user,'chat'=>$chat,'chats'=>$user->chats()->get(), 'messages'=>$messages ]);
    }

    public function createChat($id){ //TODO

        $user = Auth::user();

        $chats_of_user = $user->chats()->get();
        foreach($chats_of_user as $chat){
            if($chat->users()->find($id)){
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

    public function createMessage($chat_id, Request $request){
        $user = Auth::user();
        if(!$user)return redirect()->back();
        if(!($user->chats()->find($chat_id)))return redirect()->back();
        
        $message = new Message();
        $message->text = $request->input('text');
        $message->user_id = $user->id;
        $message->chat_id = $chat_id;
        $message->save();

        event(new MessageUpdate($message));

    }

    
}
