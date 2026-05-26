<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function index(EmailList $emailList){

        $search  = request()->search;
        $showTrash = request()->get('showTrash', false);
        return view('subscribers.index',[ 
            'emailList' => $emailList,
            'subscribers' => $emailList->
            subscribers()
            ->with('emailList')
            ->when($showTrash,fn(Builder $query)=> $query->withTrashed())
            ->when($search, fn(Builder $query)=> $query->where('name', 'like', "%$search%")
                ->where('email', 'like',"%$search%")
                ->orWhere('id', '=', $search))
            ->paginate(),


            'search' => $search,
            'showTrash' => $showTrash
        ]);
    }

    public function destroy(mixed $emailList, Subscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('message', __('Subscriber deleted from the list!'));


    }


}
