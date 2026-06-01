<x-layouts::app :title="__('campaigns')">
    <x-h2>
        {{ __('campaigns') }} > {{ __('Create a new campaign') }}
    </x-h2>

    <x-card>

        <x-tabs :tabs="[
            __('Setup') => route('campaigns.create'),
            __('Email Body') => route('campaigns.create', ['tab' => 'template']),
            __('Schedule') => route('campaigns.create', ['tab' => 'schedule']),
        ]">
            <x-form :action="route('campaigns.create', compact('tab'))" post enctype="multipart/form-data">
                @include('campaigns.create.'. $form)


                <div class="flex items-center space-x-4">
                    <x-link-button secondary :href="route('campaigns.index')">
                        {{ __('Cancel') }}
                    </x-link-button>

                    <x-primary-button type="submit">
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
                </div>
            </x-form>
            </x-tabs.index>
    </x-card>
</x-layouts::app>
