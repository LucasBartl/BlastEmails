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
            'tab' => $tab,

            'form' => match($tab){
                'template' => '_template',
                'schedule' => '_schedule',
                default => '_config'
            }
        ]);
    }
    public function store(String $tab = null)
    {

        if (blank($tab)) { // Esta vindo do /create = primeira aba (setup)

            $data = request()->validate([
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable']
            ]);


            //criando uma sessão e adicionando os dados validados 
            session()->put('campaing::create', $data);
            
            //Assim que os dados forem validados vai ser enviado para a proxima pagina necessaria Template, e com isso passamos o tab
            return to_route('campaigns.create', ['tab' => 'template']);
        }
    }
}
