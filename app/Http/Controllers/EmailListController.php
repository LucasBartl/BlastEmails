<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EmailListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $search = request()->search;

        $emailLists = EmailList::query()
        ->withCount('subscribers')
        ->when($search, fn(Builder $query) => $query
        ->where('title', 'like', "%$search%")
        ->orWhere('id', '=', $search) 
        ) //responsavel pela pesquisa
        ->paginate(10)
        ->appends(compact('search'));

        $emailLists->isNotEmpty();

        return view('email-list.index', [
            'emailLists' => $emailLists,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('email-list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        /* Validações */
        $request->validate([
            'title' => ['required', 'max:255'],
            'file' => ['required', 'file', 'mimes:csv'],
        ]);

        //Leitura do arquivo
        $emails = $this->readCvsFile($request->file('file'));



        //Criando uma transaction 
        //Ela verifica se deu certo o processo, e se sim cria 
        DB::transaction(function () use ($request, $emails) {

            //Criando uma lista 
            $emailList =  EmailList::query()->create([
                'title' => $request->title
            ]);
            //Itens da lista 
            $emailList->subscribers()->createMany($emails);
        });
        return to_route('email-list.index');
    }

    // Função de leitura 
    private function readCvsFile(UploadedFile $file): array
    {

        //Abrindo o arquivo para leitura    
        $fileHandler = fopen($file->getRealPath(), 'r');
        $itens = [];

        while (($row = fgetcsv($fileHandler, null, ',')) != false) {
            if ($row[0] == 'Name' && $row[1] == 'Email') {
                continue;
            }

            $itens[] = [
                'name' => $row[0],
                'email' => $row[1]

            ];
        }
        fclose($fileHandler);

        return $itens;
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailList $emailList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailList $emailList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailList $emailList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailList $emailList)
    {
        //
    }
}
