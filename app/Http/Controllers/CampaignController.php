<?php

namespace App\Http\Controllers;

use App\Models\Campaing;
use Illuminate\Database\Eloquent\Builder;

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
                ->appends(compact('search')), //serve para manter parâmetros da URL durante paginação no Laravel.
            'search' => $search,
            'withTrash' => $withTrash
        ]);
    }
}
