# Ecommerce aplikacija u Laravelu - Tutorial

Ovo je tutorial za izradu jednostavnu ecommerce aplikaciju. 
Tutorial ću napisati korak po korak, objašnjavajući svoje razmišljanje. Bit će to samo jedan način na kojem se stvari mogu riješiti, slobodno prilagodite korake svom načinu rada i razmišljanja. 
___

## Funkcijonalnosti

Funkcijonalnosti koje ću uključivati u ovom projektu su sljedeće:
- proizvodi: dodavanje, ažuriranje i brisanje proizvoda
- kategorije proizvoda: organizacija proizvoda u različite kategorije, svaki prizvod pripadat će samo jednoj kategoriji
- fotografiju proizvoda: svaki proizvod imati će svoju fotografiju. Neću uključivati galeriju
- košarica: dodavanje, ažuriranje i brisanje proizvoda iz košarice. Košaricu neću spremat u database nego samo u sesiji
- narudžbe: kreiranje i upravljanje narudžba
- autorizacija: dvije vrste usera. Admin koji će moći upravljati stranicom. Kupci koji će se moći registrirati na našu aplikaciju ali neće moći upravljarti stranicom nego samo vlastitim narudžbama.
- administracijski panel: za upravljanje stranicom

Mogućnosti su beskonačne. Odlučio sam uključivati samo ove funkcije zbog vremenskih ograničenja.
___
## Entiteti

### Product

| Naziv           | Tip                  | Opis                                      |
|-----------------|----------------------|-------------------------------------------|
| `id`            | `unsignedBigInteger` | Primarni ključ                            |
| `name`          | `string`             | Naziv proizvoda                           |
| `description`   | `text`               | Opis proizvoda                            |
| `price`         | `decimal`            | Cijena proizvoda                          |
| `category_id`   | `unsignedBigInteger` | Rreferenca na kategoriju                  |
| `image_id`      | `unsignedBigInteger` | Rreferenca na sliku                       |
| `created_at`    | `timestamp`          |                                           |
| `updated_at`    | `timestamp`          |                                           |


### Category

| Naziv           | Tip                  | Opis                                      |
|-----------------|----------------------|-------------------------------------------|
| `id`            | `unsignedBigInteger` | Primarni ključ                            |
| `name`          | `string`             | Naziv kategorije                          |
| `slug`          | `string`             | Slug, dio url koji ćemo kmoristiti za tu kategoriju kako nebismo koristili id ili nešto drugo. |
| `description`   | `text`               | Opis kategorije                           |
| `created_at`    | `timestamp`          |                                           |
| `updated_at`    | `timestamp`          |                                           |

### Image

| Naziv           | Tip                  | Opis                                      |
|-----------------|----------------------|-------------------------------------------|
| `id`            | `unsignedBigInteger` | Primarni ključ                            |
| `alt`           | `text`               | Opis slike                                |
| `src`           | `string`             | Path slike na disku                       |
| `created_at`    | `timestamp`          |                                           |
| `updated_at`    | `timestamp`          |                                           |

### Order

| Naziv           | Tip                  | Opis                                      |
|-----------------|----------------------|-------------------------------------------|
| `id`            | `unsignedBigInteger` | Primarni ključ                            |
| `user_id`       | `text`               | Referenca na usera                        |
| `total`         | `decimal`            | Sveukupni iznos                           |
| `buyer_name`    | `string`             | Ime kupca                                 |
| `buyer_address` | `string`             | Adresa kupca                              |
| `buyer_email`   | `string`             | Email adresa kupca                        |
| `buyer_phone`   | `string`             | Broj telefona kupca                       |
| `created_at`    | `timestamp`          |                                           |
| `updated_at`    | `timestamp`          |                                           |

### User

| Naziv Atributa  | Tip Podatka          | Opis                                      |
|-----------------|----------------------|-------------------------------------------|
| `.`             |   | Default Laravel atributi za usera.        |
| `.`             |                |                                           |
| `.`             |                 |                                           |
| `is_admin`      | `boolean`            | Da li je korisnik administrator, default `false`. |

## Tablice za relacije

Kako bismo imali više na više ralacije između Orders i Products morat ćemo dodati tablicu:

### orderproduct

| Naziv           | Tip                  | Opis                                      |
|-----------------|----------------------|-------------------------------------------|
| `id`            | `unsignedBigInteger` | Primarni ključ                            |
| `order_id`      | `unsignedBigInteger` | Referenca na order                        |
| `product_id`    | `unsignedBigInteger` | Referenca na product                      |
| `created_at`    | `timestamp`          |                                           |
| `updated_at`    | `timestamp`          |                                           |

Isto tako ćemo napraviti za relaciju order i user:

### orderproduct

| Naziv           | Tip                  | Opis                                      |
|-----------------|----------------------|-------------------------------------------|
| `id`            | `unsignedBigInteger` | Primarni ključ                            |
| `order_id`      | `unsignedBigInteger` | Referenca na order                        |
| `user_id`    | `unsignedBigInteger`    | Referenca na user                         |
| `created_at`    | `timestamp`          |                                           |
| `updated_at`    | `timestamp`          |                                           |
___
## Korak 1

U ovom koraku ćemo postaviti .env konfiguraciju i pokrenuti instalaciju laravel breeza. Koristit ću običan Blade, bez livewire ili nešto drugo kako bi projekt bio što jednostavniji.

U .env datoteku moramo postaviti database konfiguraciju. Koristit ću MySQL i u mom slućaju ime baze biti će ecommerce:

file - .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

Nakon toga instalirat ću Breeze i pokrenuti ga. odabrat ću opciju
Blade with Alpine .......................................................................................................................... blade  

```
composer require laravel/breeze --dev
php artisan breeze:install
```

Nakon toga moram pokrenuti npm skriptu za development kako bi mi se dtranica prikazivala kako treba.

`npm run dev`

__
## Korak 2 - migracije

U ovom ćemo koraku kreirati modele i migracije za Product, Category i Image. Moramo paziti na redosljed jer Product
ima strani ključ za kategoriju i za sliku proizvoda.

### Image

```
# generirati ćemo model, migraciju i controller odjednom
php artisan make:model Image -mc
```

U migraciji dodati ćemo potrebna polja:

file database\migrations\####_##_##_######_create_images_table.php
```
        .
        .
        .

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->text('alt')->nullable();
            $table->string('src');
            $table->timestamps();
        });
```

### Category

```
# generirati ćemo model, migraciju i controller odjednom
php artisan make:model Category -mc
```

U migraciji dodati ćemo potrebna polja:
file database\migrations\####_##_##_######_create_categories_table.php
```
        .
        .
        .

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->timestamps();
        });

```

### Product

```
# generirati ćemo model, migraciju i controller odjednom
php artisan make:model Product -mc
```

U migraciji dodati ćemo potrebna polja:

file database\migrations\####_##_##_######_create_products_table.php
```
        .
        .
        .

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->foreignId('image_id')->nullable()->constrained();
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
        });

```

### User

U default migraciju za Usera dodat ćemo još jedno polje is_admin.


file database\migrations\0001_01_01_000000_create_users_table.php
```
        .
        .
        .

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('is_admin')->default(false); // dodali smo ovo
            $table->timestamps();
        });

```


## Korak 3 - Routing

U ovom ćemo koraku dodati potrebne rute za Product, Image i Category.
Za sva tri modela trebat ćemo istu funkcijonalnost. Držat ćemo se [dokumentacije Laravela](https://laravel.com/docs/11.x/controllers#actions-handled-by-resource-controllers):

### Rute za entitet "products"

| Verb        | URI                   | Action  | Route Name       |
|-------------|-----------------------|---------|------------------|
| GET         | /products               | index   | products.index     |
| GET         | /products/create        | create  | products.create    |
| POST        | /products               | store   | products.store     |
| GET         | /products/{product}       | show    | products.show      |
| GET         | /products/{product}/edit  | edit    | products.edit      |
| PUT/PATCH   | /products/{product}       | update  | products.update    |
| DELETE      | /products/{product}       | destroy | products.destroy   |

file routes\web.php

```
.
.
.
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::prefix('images')->group(function () {
    Route::get('/', [ImageController::class, 'index'])->name('images.index');
    Route::get('/create', [ImageController::class, 'create'])->name('images.create');
    Route::post('/', [ImageController::class, 'store'])->name('images.store');
    Route::get('/{product}', [ImageController::class, 'show'])->name('images.show');
    Route::get('/edit/{product}', [ImageController::class, 'edit'])->name('images.edit');
    Route::put('/{product}', [ImageController::class, 'update'])->name('images.update');
    Route::delete('/{product}', [ImageController::class, 'destroy'])->name('images.destroy');
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{product}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/edit/{product}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{product}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{product}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

```
___
## Korak 4 - views

U ovom ćemo koraku dodati generalni layout i poglede za product.

Prvo izmjenit ćemo layout koji je kreirao za nas Breeze:

file - resources\views\layouts\app.blade.php
```
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <x-header />
    <div class="min-h-screen bg-gray-100">


        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>

```

Nakon toga kreirat ćemo komponentu za header u folderu resources\views\components

file - resources\views\components\header.blade.php
```
<header class="bg-white">
    <div class="mx-auto flex h-16 max-w-screen-xl items-center gap-8 px-4 sm:px-6 lg:px-8">
        <a class="block text-teal-600" href="#">
            <span class="sr-only">Home</span>
            <svg class="h-8" viewBox="0 0 28 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0.41 10.3847C1.14777 7.4194 2.85643 4.7861 5.2639 2.90424C7.6714 1.02234 10.6393 0 13.695 0C16.7507 0 19.7186 1.02234 22.1261 2.90424C24.5336 4.7861 26.2422 7.4194 26.98 10.3847H25.78C23.7557 10.3549 21.7729 10.9599 20.11 12.1147C20.014 12.1842 19.9138 12.2477 19.81 12.3047H19.67C19.5662 12.2477 19.466 12.1842 19.37 12.1147C17.6924 10.9866 15.7166 10.3841 13.695 10.3841C11.6734 10.3841 9.6976 10.9866 8.02 12.1147C7.924 12.1842 7.8238 12.2477 7.72 12.3047H7.58C7.4762 12.2477 7.376 12.1842 7.28 12.1147C5.6171 10.9599 3.6343 10.3549 1.61 10.3847H0.41ZM23.62 16.6547C24.236 16.175 24.9995 15.924 25.78 15.9447H27.39V12.7347H25.78C24.4052 12.7181 23.0619 13.146 21.95 13.9547C21.3243 14.416 20.5674 14.6649 19.79 14.6649C19.0126 14.6649 18.2557 14.416 17.63 13.9547C16.4899 13.1611 15.1341 12.7356 13.745 12.7356C12.3559 12.7356 11.0001 13.1611 9.86 13.9547C9.2343 14.416 8.4774 14.6649 7.7 14.6649C6.9226 14.6649 6.1657 14.416 5.54 13.9547C4.4144 13.1356 3.0518 12.7072 1.66 12.7347H0V15.9447H1.61C2.39051 15.924 3.154 16.175 3.77 16.6547C4.908 17.4489 6.2623 17.8747 7.65 17.8747C9.0377 17.8747 10.392 17.4489 11.53 16.6547C12.1468 16.1765 12.9097 15.9257 13.69 15.9447C14.4708 15.9223 15.2348 16.1735 15.85 16.6547C16.9901 17.4484 18.3459 17.8738 19.735 17.8738C21.1241 17.8738 22.4799 17.4484 23.62 16.6547ZM23.62 22.3947C24.236 21.915 24.9995 21.664 25.78 21.6847H27.39V18.4747H25.78C24.4052 18.4581 23.0619 18.886 21.95 19.6947C21.3243 20.156 20.5674 20.4049 19.79 20.4049C19.0126 20.4049 18.2557 20.156 17.63 19.6947C16.4899 18.9011 15.1341 18.4757 13.745 18.4757C12.3559 18.4757 11.0001 18.9011 9.86 19.6947C9.2343 20.156 8.4774 20.4049 7.7 20.4049C6.9226 20.4049 6.1657 20.156 5.54 19.6947C4.4144 18.8757 3.0518 18.4472 1.66 18.4747H0V21.6847H1.61C2.39051 21.664 3.154 21.915 3.77 22.3947C4.908 23.1889 6.2623 23.6147 7.65 23.6147C9.0377 23.6147 10.392 23.1889 11.53 22.3947C12.1468 21.9165 12.9097 21.6657 13.69 21.6847C14.4708 21.6623 15.2348 21.9135 15.85 22.3947C16.9901 23.1884 18.3459 23.6138 19.735 23.6138C21.1241 23.6138 22.4799 23.1884 23.62 22.3947Z"
                    fill="currentColor" />
            </svg>
        </a>

        <div class="flex flex-1 items-center justify-end md:justify-between">
            <nav aria-label="Global" class="hidden md:block">
                <ul class="flex items-center gap-6 text-sm">
                    <li>
                        <a class="text-gray-500 transition hover:text-gray-500/75" href="/products"> Proizvodi </a>
                    </li>
                </ul>
            </nav>

            <div class="flex items-center gap-4">
                <div class="sm:flex sm:gap-4">
                    <a class="block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-teal-700"
                        href="#">
                        Login
                    </a>

                    <a class="hidden rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600 transition hover:text-teal-600/75 sm:block"
                        href="#">
                        Register
                    </a>
                </div>

                <button
                    class="block rounded bg-gray-100 p-2.5 text-gray-600 transition hover:text-gray-600/75 md:hidden">
                    <span class="sr-only">Toggle menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
```

Sad imamo neki layout s kojim možemo početi raditi.

