<div class="flex flex-col gap-4">
    <x-alert success  :title="__('Your campaign is ready to be send!')" />

    <div>

        <div>De:------@------</div>
        <div>Para:</div>
        <div>Assunto:{{$data['subject']}}</div>
        <div>Template:</div>
        
    </div>
    <hr>
    <div>
        <x-radio  id="send_now" name="send_when" value="now">{{__('Send now')}}</x-radio>
        <x-radio id="send_later" name="send_when" value="later">{{__('Schedule delivery')}}</x-radio>
    </div>
    <div>
        <x-input-label for="send_at" :value="__('Send_at')" />
        <x-text-input  id="send_at" class="block mt-1 w-full" type="date" name="send_at" :value="old('send_at', $data['send_at'])" autofocus />
        <x-input-error :messages="$errors->get('send_at')" class="mt-2" />
    </div>
</div>