<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignStoreRequest;
use App\Models\Campaing;
use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\Template;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Traits\Conditionable;

class CampaignController extends Controller
{
    use Conditionable; // Importando metodos de condicionais 
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
    public function create(?String $tab = null)
    {

        //session()->forget('campaing::create');   -> matar sessão 

        $data = session()->get('campaigns::create', [
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'send_at' => null,
            'send_when' => null
        ]);

        return view(
            'campaigns.create',
            array_merge(

                $this->when(
                    blank($tab),
                    fn() =>
                    [
                        'email_lists' => EmailList::all(),
                        'templates' => Template::all(),
                    ],
                    fn() => []
                ),
                $this->when($tab == 'schedule', fn() => [
                    'countEmails' => EmailList::find($data['email_list_id'])->subscribers()->count(),
                    'template' => Template::find($data['template_id'])->name
                ], fn() => []),
                [
                    'tab' => $tab,
                    'form' => match ($tab) {
                        'template' => '_template',
                        'schedule' => '_schedule',
                        default => '_config'
                    },
                    'data' => $data,
                ]
            )
        );
    }
    public function store(CampaignStoreRequest $request, ?String $tab = null)
    {


        $data = $request->getData();
        $toRoute = $request->getToRoute();


        //Salvando 
        if ($tab == 'schedule') {
            Campaing::create($data);
        }


        return redirect($toRoute);
    }
}
