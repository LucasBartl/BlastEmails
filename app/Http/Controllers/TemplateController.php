<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{

    public function index()
    {

        $search  = request()->get('search', null);
        $withTrash = request()->get('withTrash', false);

        return view('template.index', [
            'templates' => Template::query()
                ->when($withTrash, fn(Builder $query) => $query->withTrashed())
                ->when(
                    $search,
                    fn(Builder $query) => $query
                        ->where('name', 'like', "%$search%")
                        ->orWhere('id', '=', $search)
                ) //responsavel pela pesquisa
                ->paginate(10)
                ->appends(compact('search')),
            'search' => $search,
            'withTrash' => $withTrash
        ]);
    }

    public function create()
    {
        return view('template.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'body' => ['required']
        ]);

        //Chamando o model 
        Template::create($data);

        return to_route('template.index')
            ->with('message', __('Template successfully create!'));
    }

    public function show(Template $template)
    {
        return view('template.show', compact('template'));
    }

    public function edit(Template $template)
    {
        return view('template.edit', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'body' => ['required']
        ]);

        //Aqui diferente do create, estamos puxando as informações já existentes e preenchendo com as novas
        $template->fill($data);
        $template->save();
        return back()
            ->with('message', __('Template successfully updated!'));
    }

    public function destroy(Template $template)
    {

        $template->delete();

        return to_route('template.index')
            ->with('message', __('Template successfully updated!'));
    }
}
