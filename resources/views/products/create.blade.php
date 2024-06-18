<x-layout.dashboard>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dodaj novi proizvod
        </h2>
    </x-slot>
    <div class="my-8 mx-8 ">
        <form class="flex flex-col gap-3" method="POST" action="{{ route('products.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name" class="block font-medium text-gray-700"> Ime proizvoda </label>

                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="mt-1 w-full rounded-md border-gray-200 shadow-sm " />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price"> Cijena proizvoda </label>
                <div class="flex gap-2 items-center">
                    <input type="number" step="0.01" min="0.01" id="price" name="price" required
                        value="{{ old('price') }}"
                        class="text-right mt-1 w-24 rounded-md border-gray-200  shadow-sm " />
                    <span>€</span>
                </div>
                @error('price')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>



            <div>
                <label for="description" class="block font-medium text-gray-700"> Opis </label>

                <textarea id="description" name="description" required
                    class="mt-2 w-full rounded-lg border-gray-200 align-top shadow-sm sm:text-sm" rows="4"
                    placeholder="Opis proizvoda...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block font-medium text-gray-700"> Slika proizvoda </label>

                <input type="file" id="image" name="image" required
                    class="mt-1 w-full rounded-md border-gray-200 shadow-sm " />
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            <div>
                <label for="category" class="block font-medium text-gray-700"> Kategorija proizvoda </label>

                <x-Products.CategorySelect name="category" id="category" selected="{{ old('category') }}" />
                @error('category')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="mt-8 flex items-center justify-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500">
                <span class="text-sm font-medium text-center"> Spremi proizvod </span>

                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
                </a>
        </form>
    </div>
</x-layout.dashboard>
