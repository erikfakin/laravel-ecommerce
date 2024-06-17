<x-layout.dashboard>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Svi proizvodi') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">


                <div class="overflow-x-auto">
                    <a href="{{ route('products.create') }}"
                        class=" mb-8 inline-flex items-center gap-2 rounded border border-green-600 bg-green-600 px-8 py-3 text-white hover:bg-transparent hover:text-green-600 focus:outline-none focus:ring active:text-green-500"
                        type="button" x-on:click="open=true">
                        <span class="text-sm font-medium"> Dodaj novi proizvod </span>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>

                    </a>
                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                        @if ($products)
                            <thead>
                                <tr>
                                    <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Slika
                                    </th>
                                    <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Naziv
                                    </th>
                                    <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Cijena
                                    </th>
                                    <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        Kategorija</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                        @endif


                        <tbody class="divide-y divide-gray-200">

                            @forelse ($products as $product)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        <img class="size-16" src="/storage/{{ $product->image->src }}" />
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        <a class="underline" href="{{ route('products.show', $product->id) }}">
                                            {{ $product->name }}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        {{ number_format($product->price, 2, '.', '') }} €

                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $product->category->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 flex gap-3">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="inline-flex items-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
                                            type="button" x-on:click="open=true">
                                            <span class="text-sm font-medium"> Uredi </span>

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>

                                        </a>
                                        <x-products.delete-button id="{{ $product->id }}" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        Nemamo proizvoda za prikaz...
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
