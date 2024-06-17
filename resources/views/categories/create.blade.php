<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dodaj novu kategoriju
        </h2>
    </x-slot>
    <div class="my-8 mx-8 ">
        <form class="flex flex-col gap-3" method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div>
                <label for="name" class="block font-medium text-gray-700"> Ime kategorije </label>

                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="mt-1 w-full rounded-md border-gray-200 shadow-sm " />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block font-medium text-gray-700"> Slug kategorije </label>

                <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                    class="mt-1 w-full rounded-md border-gray-200 shadow-sm " />
                @error('slug')
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



            <button type="submit"
                class="mt-8 flex items-center justify-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500">
                <span class="text-sm font-medium text-center"> Spremi kategoriju </span>

                <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
                </a>
        </form>
    </div>
</x-app-layout>
