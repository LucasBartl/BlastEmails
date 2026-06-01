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
    public function create(?String $tab = null)
    {

        //session()->forget('campaing::create');   -> matar sessão 

        return view('campaigns.create', [
            'tab' => $tab,

            'form' => match ($tab) {
                'template' => '_template',
                'schedule' => '_schedule',
                default => '_config'
            },
            'data' => session()->get('campaign::create', [
                'name' => null,
                'subject' => null,
                'email_list_id' => null,
                'template_id' => null,
                'body' => null,
                'track_click' => null,
                'track_open' => null,
                'sent_at' => null
            ])

        ]);
    }
    public function store(?String $tab = null)
    {
        $toRoute = '';


        $map = array_merge([
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'sent_at' => null
        ], request()->all());




        if (blank($tab)) { // Esta vindo do /create = primeira aba (setup)

            //Validações
            request()->validate([
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable'],
                'body' => ['nullable'],
                'track_click' => ['nullable'],
                'track_open' => ['nullable'],
                'sent_at' => ['nullable'],
            ]);

            //Assim que os dados forem validados vai ser enviado para a proxima pagina necessaria Template, e com isso passamos o tab
            $toRoute =  route('campaigns.create', ['tab' => 'template']);
        }

        if ($tab == 'template') {
            //Validações
            request()->validate([
                'body' => ['required'],
            ]);
            $toRoute = route('campaigns.create', ['tab' => 'schedule']);
        }
        if ($tab == 'schedule') {
            //Validações
            request()->validate([
                'sent_at' => ['date'],
            ]);
            $toRoute = route('campaigns.index');
        }

        $session = session('campaign::create', [
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'sent_at' => null,
        ]);

        foreach ($session as $key => $_) {
            $newValue = data_get($map, $key);

            if (filled($newValue)) {
                $session[$key] = $newValue;
            }
        }

        session()->put('campaign::create', $session);
        return redirect($toRoute);
    }
}
