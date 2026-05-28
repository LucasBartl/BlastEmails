<x-layouts::app :title="__('campaigns')">
    <x-h2>
        {{ __('Campaigns') }}
    </x-h2>

    <x-card class="space-y-4">

        <div class="flex justify-between">
            <x-link-button :href="route('campaigns.create')">
                {{ __('Add a new campaign') }}
            </x-link-button>
            <x-form :action="route('campaigns.index')" class="w-2/5" x-data x-ref="form">

                <x-checkbox-input :label="__('Show Deleted Records')" name="withTrash" value="1" @click="$refs.form.submit()"
                    :checked="$withTrash" />

                <x-text-input name="search" :placeholder="__('Search')" :value="$search" />

            </x-form>
        </div>

        <x-table :headers="['#', __('Name'), __('Actions')]">
            <x-slot name="body">

                @foreach ($campaigns as $campaign)
                    <tr>
                        <x-table.td>{{ $campaign->id }}</x-table.td>
                        <x-table.td>{{ $campaign->name }}</x-table.td>

                        <x-table.td class="flex space-x-4 ">
                            @unless ($campaign->trashed())
                                <x-form :action="route('campaigns.destroy', $campaign)" delete flat
                                    onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    <x-secondary-button type="submit">
                                        {{ __('Delete') }}
                                    </x-secondary-button>
                                </x-form>
                            @else
                                <x-form :action="route('campaigns.restore', $campaign)" patch  flat
                                    onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    <x-secondary-button type="submit">
                                        {{ __('Restore') }}
                                    </x-secondary-button>
                                </x-form>
                                <x-danger danger>
                                    {{ __('Deleted') }}
                                </x-danger>
                            @endunless
                        </x-table.td>
                    </tr>
                @endforeach

            </x-slot>
        </x-table>


    </x-card>
</x-layouts::app>
