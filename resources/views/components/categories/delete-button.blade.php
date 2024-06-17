<div x-data="{ open: false }" x-cloak>

    <button
        class="inline-flex items-center gap-2 rounded border border-red-600 bg-red-600 px-8 py-3 text-white hover:bg-transparent hover:text-red-600 focus:outline-none focus:ring active:text-red-500"
        type="button" x-on:click="open=true">
        <span class="text-sm font-medium"> Obriši </span>

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>

    </button>

    <div role="alert" x-show="open"
        class="flex w-screen h-screen bg-black/50 justify-center items-center top-0 left-0 fixed">
        <div class="flex border border-gray-100 bg-white p-4 items-start rounded-lg shadow-2xl w-fit">
            <div class="flex items-start gap-4">
                <span class="text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>

                </span>

                <form class="flex-1" method="POST" action={{ route('categories.destroy', $id) }}>
                    @csrf
                    @method('DELETE')

                    <strong class="block font-medium text-gray-900"> Želite li obrisati kategoriju?</strong>

                    <p class="mt-1 text-sm text-gray-700">Jednom kada obrišete kategoriju nećete ju moći vratit.</p>

                    <div class="mt-4 flex gap-2">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                            <span class="text-sm"> Da </span>


                        </button>

                        <button x-on:click="open = false" type="button"
                            class="block rounded-lg px-4 py-2 text-gray-700 transition hover:bg-gray-50">
                            <span class="text-sm">Ne</span>
                        </button>
                    </div>
                </form>
                <button type="button" x-on:click="open = false" class="text-gray-500 transition hover:text-gray-600">
                    <span class="sr-only">Zatvori</span>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
        </div>
    </div>
