<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hvala Vam na narudžbi
        </h2>
    </x-slot>


    <div class="bg-white">


        <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <div class="mx-auto max-w-3xl">
                <div class="mt-8">
                    <h2 class="mb-8 text-3xl font-bold sm:text-4xl">Hvala Vam na narudžbi!</h2>
                    <h3 class="mb-8 text-lg font-bold">Broj vaše narudžbe: {{ $order->id }}</h3>
                    <table class="mb-8 min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                        <thead class="ltr:text-left rtl:text-right">
                            <tr>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Slika</th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Naziv
                                </th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Cijena</th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Količina
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">



                            @foreach ($order->products as $product)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                        <img src="{{ asset('/storage/' . $product->image->src) }}"
                                            alt="{{ $product->image->alt }}" class="size-16 rounded object-contain" />
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        <h3 class="text-sm text-gray-900">{{ $product->name }}</h3>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        {{ number_format($product->price, 2, '.', '') }} €</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                        {{ $product->pivot->quantity }}</td>

                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                    <h3 class="mb-8 text-lg font-bold">Detalji kupca</h3>
                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                        <thead class="ltr:text-left rtl:text-right">
                            <tr>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Ime</th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Adresa
                                </th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Email</th>
                                <th class="text-left whitespace-nowrap px-4 py-2 font-medium text-gray-900">Telefon
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                    {{ $order->buyer_name }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                    {{ $order->buyer_address }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                    {{ $order->buyer_email }}</td>
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                    {{ $order->buyer_phone }}</td>

                            </tr>
                        </tbody>
                    </table>




                </div>
            </div>
        </div>
    </div>




</x-app-layout>
