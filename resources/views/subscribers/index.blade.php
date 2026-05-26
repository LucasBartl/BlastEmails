<x-layouts::app :title="__('Email List')">
    <x-h2>
        {{ __('Email List') }} > {{ __($emailList->title) }} > {{ __('Subscribers') }}
    </x-h2>

    <x-card class="space-y-4">

        <div class="flex justify-between">
            <x-link-button :href="route('subscribers.create', $emailList)">
                {{ __('Add a new subscriber') }}
            </x-link-button>

            <x-form :action="route('subscribers.index', $emailList)" class="w-2/5" x-data x-ref="form">

                <x-checkbox-input :label="__('Show Deleted Records')" name="showTrash" value="1" @click="$refs.form.submit()"
                    :checked="$showTrash" />

                <x-text-input name="search" :placeholder="__('Search')" :value="$search" />

            </x-form>
        </div>

        <x-table :headers="['#', __('Name'), __('Email'), __('Actions')]">
            <x-slot name="body">

                @foreach ($subscribers as $subscriber)
                    <tr>
                        <x-table.td>{{ $subscriber->id }}</x-table.td>
                        <x-table.td>{{ $subscriber->name }}</x-table.td>
                        <x-table.td>{{ $subscriber->email }}</x-table.td>

                        <x-table.td >
                            @unless ($subscriber->trashed())
                                <x-form :action="route('subscribers.destroy', [$emailList, $subscriber])" delete flat onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    <x-secondary-button type="submit">
                                        Delete
                                    </x-secondary-button>
                                </x-form>
                            @else
                                <x-danger danger>
                                    {{ __('Deleted') }}
                                </x-danger>
                            @endunless
                        </x-table.td>
                    </tr>
                @endforeach

            </x-slot>
        </x-table>

        {{ $subscribers->links() }}

    </x-card>
</x-layouts::app>
