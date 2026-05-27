<x-layouts::app :title="__('Email List')">
    <x-h2>
        {{ __('Email List') }} > {{ __('Create new list') }}
    </x-h2>
 
    <x-card>

        <x-form :action="route('email-list.create')" post enctype="multipart/form-data">
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" name="title" :value="old('title')" autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="file" :value="__('File list')" />
                <x-text-input id="file" class="block mt-1 w-full" type="file" accept=".csv" name="file" autofocus />
                <x-input-error :messages="$errors->get('file')" class="mt-2" />
            </div>

            <div class="flex items-center space-x-4">
                <x-link-button :href="route('email-list.index')">
                    {{ __('Cancel') }}
                </x-link-button>

                <x-primary-button type="submit">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </x-form>

    </x-card>
</x-layouts::app>
