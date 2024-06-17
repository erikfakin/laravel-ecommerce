<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout
        </h2>
    </x-slot>
    <div class="my-8 mx-8 ">
        <form class="flex flex-col gap-3" method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div>
                <label for="buyerName" class="block font-medium text-gray-700"> Ime kupca </label>

                <input type="text" id="buyerName" name="buyerName" value="{{ old('buyerName') }}" required
                    class="mt-1 w-full rounded-md border-gray-200 shadow-sm " />
                @error('buyerName')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="buyerAddress" class="block font-medium text-gray-700"> Adresa kupca </label>

                <input type="text" id="buyerAddress" name="buyerAddress" value="{{ old('buyerAddress') }}"
                    class="mt-1 w-full rounded-md border-gray-200 shadow-sm " />
                @error('buyerAddress')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <div>
                <label for="buyerEmail" class="block font-medium text-gray-700"> Email kupca </label>

                <input type="text" id="buyerEmail" name="buyerEmail" value="{{ old('buyerEmail') }}"
                    class="mt-1 w-full rounded-md border-gray-200 shadow-sm " />
                @error('buyerEmail')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="buyerPhone" class="block font-medium text-gray-700"> Telefon kupca </label>

                <input type="text" id="buyerPhone" name="buyerPhone" value="{{ old('buyerPhone') }}"
                    class="mt-1 w-full rounded-md border-gray-200 shadow-sm " />
                @error('buyerPhone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>



            <button type="submit"
                class="mt-8 flex items-center justify-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500">
                <span class="text-sm font-medium text-center"> Pošalji narudžbu </span>

                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
                </a>
        </form>
    </div>
</x-app-layout>
