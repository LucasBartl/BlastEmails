<?php

namespace App\Http\Controllers;

use App\Models\Campaing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {

        $search  = request()->get('search', null);
        $withTrash = request()->get('withTrash', false);

        return view('campaigns.index', [
            'campaigns' => Campaing::query()
                ->when($withTrash, fn(Builder $query) => $query->withTrashed()) //Busca de usuário que foram deletados
                ->when($search, fn(Builder $query) => $query->where('name', 'like', "%$search%")->orWhere('id', '=', $search)) //Busca pela pesquisa
                ->paginate(10)
                ->appends(compact('search', 'withTrash')), //serve para manter parâmetros da URL durante paginação no Laravel.
            'search' => $search,
            'withTrash' => $withTrash
        ]);
    }
    public function destroy(Campaing $campaign)
    {
        $campaign->delete();

        return back()->with('message', __('Campaing sussccefully deleted!'));
    }
    public function restore(Campaing $campaign)
    {

        $campaign->restore();

        return back()->with('message', __('Campaing sussccefully restored!'));
    }
    public function create(String $tab = null)
    {

        return view('campaigns.create', [ 
            'tab' => $tab
        ]);
    }
    public function store(Request $request)
    {

        $data = $request->validate([]);
    }
}
