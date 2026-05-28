@props([
    'tabs' => [],

])
<div class="w-full">
    <div class="flex gap-2 overflow-x-auto border-b border-outline dark:border-outline-dark">
        @foreach ($tabs as $title => $route)
            @php
                //Variavel valida se a url vinda da requisição é igual a da rota 
                $selected = request()->getUri() == $route;
                
            @endphp
            <a @class([
                'h-min px-4 py-2 text-sm',
                'text-on-surface font-medium dark:text-on-surface-dark dark:hover:border-b-outline-dark-strong dark:hover:text-on-surface-dark-strong 
                        hover:border-b-2 hover:border-b-outline-strong hover:text-on-surface-strong' => !$selected,
                'font-bold text-primary border-b-2 border-primary dark:border-primary-dark dark:text-primary-dark' => $selected,
            ]) href="{{ $route }}">{{$title}}</a>
        @endforeach
        {{-- <button x-on:click="selectedTab = 'saved'" x-bind:aria-selected="selectedTab === 'saved'"
        x-bind:tabindex="selectedTab === 'saved' ? '0' : '-1'"
        x-bind:class="selectedTab === 'saved' ?
            'font-bold text-primary border-b-2 border-primary dark:border-primary-dark dark:text-primary-dark' :
            'text-on-surface font-medium dark:text-on-surface-dark dark:hover:border-b-outline-dark-strong dark:hover:text-on-surface-dark-strong hover:border-b-2 hover:border-b-outline-strong hover:text-on-surface-strong'"
        class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelSaved">Saved</button> --}}
    </div>
    <div class="px-2 py-4 text-on-surface dark:text-on-surface-dark">
        {{ $slot }}
    </div>
</div>
