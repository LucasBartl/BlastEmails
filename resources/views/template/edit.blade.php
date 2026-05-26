<x-layouts::app :title="__('Templates')">
    <x-h2>
        {{ __('Templates') }} > {{$template->name}} > {{ __('Update') }}
    </x-h2>

    <x-card>

        <x-form :action="route('template.update', $template)" put enctype="multipart/form-data">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" name="name" :value="old('name', $template->name)" autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="body" :value="__('Body')" />
                <x-text-input id="body" class="block mt-1 w-full" name="body" :value="old('body', $template->body )" autofocus />
                <x-input-error :messages="$errors->get('body')" class="mt-2" />
            </div>

            <div class="flex items-center space-x-4">
                <x-link-button secondary :href="route('template.index')">
                    {{ __('Cancel') }}
                </x-link-button>

                <x-primary-button type="submit">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </x-form>

    </x-card>
</x-layouts::app>
