<x-layouts::app :title="__('Templates')">
    <x-h2>
        {{ __('Templates') }}
    </x-h2>
    <x-card>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <span class="opacity-70">{{ __('Name:') }}</span> {{ $template->name }}
                </div>
                <div>
                    <x-link-button secondary :href="route('template.index')">{{__('Back to list')}}</x-link-button>
                </div>
            </div>
            {{-- Utilizamos o {!! Para não mostrar tags html !!} --}}
            <div class="p-20 border-2 border-gray-400 rounded flex justify-center ">{!! $template->body !!}</div>
        </div>
    </x-card>
</x-layouts::app>
