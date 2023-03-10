<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Request as FacadesRequest;

class SearchController extends Controller
{
    /*
    public function search1(){
        $q = Request::input ( 'q' );
        $users = User::where('name','LIKE','%'.$q.'%')->orWhere('email','LIKE','%'.$q.'%')->get();
        if(count($users) > 0)
            return view('pages.search')
                ->with('users',$users)
                ->with( 'q', $q );
        else return view ('pages.search')
                ->with('message',"Unfortunately, we couldn't find the user you were looking for, try searching again!");
    }
    */

    //Full text search
    public function search(){
        $search = Request::input('q');

        if($search == ''){
            return view ('pages.search')
            ->with('message',"Please insert any name to search!");
        }

        $users = User::search($search)->get();

        if(count($users) > 0)
        return view('pages.search')
            ->with('users',$users)
            ->with( 'q', $search );
        else return view ('pages.search')
            ->with('message',"Unfortunately, we couldn't find the user you were looking for, try searching again!");

    }
    public function postSearch()
    {
        $search = Request::input('q');
        if($search == ''){
            return view ('pages.search')
            ->with('message',"Please insert any name to search!");
        }
        $posts = Post::search($search)->get();
        if(count($posts) > 0)
        return view('pages.searchPosts')
            ->with('posts',$posts)
            ->with( 'q', $search );
        else return view ('pages.searchPosts')
            ->with('message',"Unfortunately, we couldn't any matching posts, try searching again!");
    }


}
