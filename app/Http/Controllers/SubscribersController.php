<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscribersController extends Controller
{
    public function index(EmailList $emailList)
    {

        $search  = request()->search;
        $showTrash = request()->get('showTrash', false);
        return view('subscribers.index', [
            'emailList' => $emailList,
            'subscribers' => $emailList->subscribers()
                ->with('emailList')
                ->when($showTrash, fn(Builder $query) => $query->withTrashed())
                ->when($search, fn(Builder $query) => $query->where('name', 'like', "%$search%")
                    ->where('email', 'like', "%$search%")
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

    public function create(EmailList $emailList)
    {

        return view('subscribers.create', compact('emailList'));
    }
    public function store(EmailList $emailList)
    {

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('subscribers')
                    ->where('email_list_id', $emailList->id) //Regra que define emails como unicos
            ]
        ]);

        $emailList->subscribers()->create($data);
        return to_route('subscribers.index')
            ->with('message', __('Subscriber successfully create!'));
    }
}
