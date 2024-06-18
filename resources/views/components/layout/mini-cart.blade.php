<div class="relative" x-data="{ open: false }" x-on:mouseenter="open = true" x-on:mouseleave="open = false">
    <div class="inline-flex items-center overflow-hidden rounded-xl bg-white">
        <a href="#"
            class="flex items-center gap-3 px-8 py-4 text-sm/none text-gray-600 hover:bg-gray-50 hover:text-gray-700">
            Košarica ({{ number_format($total, 2) }} €)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>

        </a>


    </div>

    <div x-show="open" x-cloak
        class="right-0 w-max z-40 absolute max-w-sm rounded-xl shadow-xl bg-white px-4 py-8 sm:px-6 lg:px-8"
        aria-modal="true" role="dialog" tabindex="-1">

        @if ($cart)
            <div class="mt-4 space-y-6">
                <h3 class="text-xl font-bold text-gray-900">Vaša košarica</h3>
                <ul class="space-y-4">
                    @foreach ($cart as $cartItem)
                        <li class="flex items-center gap-4">
                            <img src="{{ asset('/storage/' . $cartItem->image->src) }}"
                                alt="{{ $cartItem->image->alt }}" class="size-16 rounded object-contain" />

                            <div>
                                <h3 class="text-sm text-gray-900">{{ $cartItem->name }}</h3>
                                <dl class="mt-0.5 space-y-px text-[10px] text-gray-600">
                                    <div>
                                        <dt class="inline">Cijena:</dt>
                                        <dd class="inline">{{ $cartItem->price }}</dd>
                                    </div>


                                </dl>

                            </div>
                            <div>
                                {{ $cartItem->quantity }}
                            </div>

                            <div class="flex flex-1 items-center justify-end gap-2">

                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $cartItem->id }}">
                                    <button class="text-gray-600 transition hover:text-red-600">
                                        <span class="sr-only">Izbriši</span>

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach


                </ul>

                <p class="text-right">Sveukupno: {{ number_format($total, 2) }} €</p>

                <div class="space-y-4 text-center">
                    <a href="{{ route('cart.index') }}"
                        class="block rounded border border-gray-600 px-5 py-3 text-sm text-gray-600 transition hover:ring-1 hover:ring-gray-400">
                        Pogledaj košaricu
                    </a>

                    <a href="{{ route('orders.create') }}"
                        class="block rounded bg-indigo-700 px-5 py-3 text-sm text-gray-100 transition hover:bg-indigo-600">
                        Naplata
                    </a>

                </div>
            </div>
        @else
            <div class="mt-4 space-y-6">
                Vaša košarica je prazna.
            </div>
        @endif

    </div>
</div>
