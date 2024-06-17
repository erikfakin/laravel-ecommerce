<x-layout.dashboard>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vaše narudžbe') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">


                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                        @if ($orders)
                            <thead>
                                <tr>
                                    <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Broj
                                        narudžbe
                                    </th>
                                    <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Ukupno
                                    </th>
                                    <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Datum
                                        narudžbe
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                        @endif


                        <tbody class="divide-y divide-gray-200">

                            @forelse ($orders as $order)
                                <tr>

                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        <a class="underline" href="{{ route('orders.show', $order->id) }}">
                                            {{ $order->id }} </a>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        {{ number_format($order->total, 2, '.', '') }} €</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $order->created_at }}</td>

                                    <td class="whitespace-nowrap px-4 py-2 flex gap-3">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="inline-flex items-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
                                            type="button" x-on:click="open=true">
                                            <span class="text-sm font-medium"> Pogledaj narudžbu </span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        Nemamo kategorija za prikaz...
                                    </td>

                                </tr>
                            @endforelse




                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout.dashboard>
