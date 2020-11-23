<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','cors']);
    }
    //
    public function conversation($userId)
    {
        $users = User::where('id','!=',Auth::id())->get();
        $friendInfo = User::findOrFail($userId);
        $myInfo = User::find(Auth::id());


        $this->data['users'] = $users;
        $this->data['friendInfo'] = $friendInfo;
        $this->data['myInfo'] = $myInfo;
        $this->data['users'] = $users;
        $this->data['userId'] = $userId;

        return view('message.conversation',$this->data);

    }
}
