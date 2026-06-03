<div class="flex flex-col gap-4">
    <x-alert success :title="__('Your campaign is ready to be send!')" />

    <div class="space-y-2 ">
        <div>{{__('De')}}:<x-badge>{{config('mail.from.address')}}</x-badge></div>
        <div>{{__('Para')}}: <x-badge>{{ $countEmails }}</x-badge></div>
        <div>{{__('Assunto')}}:<x-badge>{{ $data['subject'] }}</x-badge></div>
        <div>{{__('Template')}}:<x-badge>{{$template}} </x-badge></div>
    </div>
    <hr class="my-3 opacity-50">

    <div x-data="{ show: '{{ data_get($data, 'send_when', 'now') }}' }">
        <x-input-label :value="__('Schedule Delivery')"></x-input-label>
        <div class="flex flex-col gap-2 mt-2">
            <x-radio id="send_now" name="send_when" value="now" x-model="show">{{ __('Send now') }}</x-radio>
            <x-radio id="send_later" name="send_when" value="later" x-model="show">{{ __('Schedule later') }}</x-radio>
        </div>
        <div x-show="show == 'later'">
            <x-text-input id="send_at" class="block mt-1 w-full" type="date" name="send_at" :value="old('send_at', $data['send_at'])"
                autofocus />
            <x-input-error :messages="$errors->get('send_at')" class="mt-2" />

        </div>
    </div>
</div>
