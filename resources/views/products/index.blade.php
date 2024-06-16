<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (isset($title))
                {{ $title }}
            @else
                Proizvodi
            @endif
        </h2>
    </x-slot>
    <ul class="my-8 mx-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

        @forelse ($products as $product)
            <li>
                <x-products.card :product="$product" />
            </li>
        @empty
            <li>
                Nemamo proizvoda za prikaz...
            </li>
        @endforelse

    </ul>


</x-app-layout>
