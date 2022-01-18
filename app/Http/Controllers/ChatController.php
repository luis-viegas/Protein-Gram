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
        if(!$user) return redirect("/login");
        $user_id=$user->id;
        $chat = $user->chats()->first();
        if(!$chat)  return redirect("/");
        return redirect("messages/{$chat->id}");
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
        if(!$currentUser || !($currentUser->is_admin)){
            return redirect("/messages");
        }
        $user = null;
        $chat = null;
        $user = User::find($user_id);
        if(!$user)return redirect("/messages");
        $chats = $user->chats()->find($chat_id);
        $chat = $chats->get();
        if(!$chat)return redirect("/users/{$user_id}/messages");
        $messages = $chat->messages()->orderBy('id')->get();
        return view('pages.messages', ['user'=>$user,'chat'=>$chat,'chats'=>$chats->get(), 'messages'=>$messages ]);
    }
    public function show($chat_id){
        $user = Auth::user();
        if(!$user)return redirect("/");
        $chats = $user->chats()->find($chat_id);
        $chat = $chats->get();
        if(!$chat)return redirect("/messages");
        $messages = $chats->messages()->orderBy('id')->get();
        return view('pages.messages', ['user'=>$user,'chat'=>$chat,'chats'=>$chats->get(), 'messages'=>$messages ]);
    }

    public function createChat($id){ //TODO
        $user = Auth::user();
        if(!$user)return redirect()->back();
        $chat = $user->sharedChats($id);
        if( !empty($chat) ){
            foreach($chat as $c){
                if(Chat::find($c->id)->users()->count()==2){
                    $chat=$c->id;
                }
            }
            return redirect("messages/{$chat}");
        }
        $newChat = new Chat();
        $newChat->save();
        $newChat->users()->attach($user->id);
        $newChat->users()->attach($id);
        return redirect("messages/{$newChat->id}");

    }

    public function createMessage($chat_id, Request $request){
        $user = Auth::user();
        if(!$user)return redirect()->back();
        if(!($user->chats()->find($chat_id)->get())) return redirect()->back();
        $message = new Message();
        $message->text = $request->input('text');
        $message->user_id = $user->id;
        $message->chat_id = $chat_id;
        $message->save();

        //event(new MessageUpdate($message));
    }

    
}
