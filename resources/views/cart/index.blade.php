<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Košarica
        </h2>
    </x-slot>


    <div class="bg-white">
        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="mx-auto max-w-3xl">



                <div class="mt-8">
                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                        <thead class="ltr:text-left rtl:text-right">
                            <tr>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Slika</th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Naziv
                                </th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Cijena</th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Količina
                                </th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">



                            @forelse ($cart as $cartItem)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        <img src="{{ asset('/storage/' . $cartItem->image->src) }}"
                                            alt="{{ $cartItem->image->alt }}" class="size-16 rounded object-contain" />
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        <h3 class="text-sm text-gray-900">{{ $cartItem->name }}</h3>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        {{ number_format($cartItem->price, 2, '.', '') }} €</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $cartItem->quantity }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        <form method="POST" action="{{ route('cart.remove') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $cartItem->id }}">

                                            <button class="text-gray-600 transition hover:text-red-600">
                                                <span class="sr-only">Izbriši</span>

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="h-4 w-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>


                            @empty

                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        Vaša košarica je prazna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>



                    @if ($cart)
                        <div class="mt-8 flex justify-end border-t border-gray-100 pt-8">
                            <div class="w-screen max-w-lg space-y-4">
                                <dl class="space-y-0.5 text-sm text-gray-700">
                                    <div class="flex justify-between">
                                        <dt>Sveukupno</dt>
                                        <dd> {{ number_format($total, 2, '.', '') }} €</dd>
                                    </div>


                                </dl>



                                <div class="flex justify-end">
                                    <a href="{{ route('orders.create') }}"
                                        class="block rounded bg-indigo-700 px-5 py-3 text-sm text-indigo-100 transition hover:bg-indigo-600">
                                        Na naplatu
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
