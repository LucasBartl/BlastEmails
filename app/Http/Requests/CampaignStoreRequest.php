<?php

namespace App\Http\Requests;

use App\Models\Template;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CampaignStoreRequest extends FormRequest
{
    public function rules(): array
    {
        $tab = $this->route('tab');
        $rules = [];

        $map = array_merge([
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'send_at' => null
        ], request()->all());




        if (blank($tab)) { // Esta vindo do /create = primeira aba (setup)

            //Retorna para validações
            $rules =  [
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable'],
                'body' => ['nullable'],
                'track_click' => ['nullable'],
                'track_open' => ['nullable'],
                'send_at' => ['nullable'],
            ];
        }

        if ($tab == 'template') {
            $rules = [
                'body' => ['required'],
            ];
        }
        if ($tab == 'schedule') {
            $rules = [
                'send_at' => ['date'],
            ];
        }

        $session = session('campaigns::create', $map);

        foreach ($session as $key => $_) {
            $newValue = data_get($map, $key);

            if (filled($newValue)) {
                $session[$key] = $newValue;
            }
        }
         
        
        if($tempateID = $session['template_id'] && blank($session['body'])){
            //find() -> método usado para buscar um registro pelo ID da chave primária (
            $template = Template::find($tempateID);
            //Passando para o body o valor de template body
            $session['body'] = $template->body; 
        }


        session()->put('campaigns::create', $session);
        return $rules;
    }
    public function getData()
    {
        $session = session()->get('campaigns::create');
        unset($session['_token']);
        return $session;
    }
    public function getToRoute(){
        $tab = $this->route('tab');

        if (blank($tab)) {
            return route('campaigns.create', ['tab' => 'template']);

        }
        if($tab == 'template') { 
            return  route('campaigns.create', ['tab' => 'schedule']);
        }

        return route('campaigns.index');

        
    }
}
