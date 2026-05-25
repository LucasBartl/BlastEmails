<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function index(EmailList $emailList){

        $search  = request()->search;

        return view('subscribers.index',[ 
            'emailList' => $emailList,
            'subscribers' => $emailList->
            subscribers()
            ->with('emailList')
            ->when($search, fn(Builder $query)=> $query->where('name', 'like', "%$search%")
            ->where('email', 'like',"%$search%")
            ->orWhere('id', '=', $search))
            ->paginate(),
            'search' => $search
        ]);
    }
}
