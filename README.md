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
## Korak 2 - migracije i modeli

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

### Modeli

Kako bismo povezali modele međusobno, moramo dodati relacije. Svaki proizvod imat će sliku proizvoda i pripadajuću kategoriju.
Oba dvije relacije su 1 prema više.

U modelima također trebamo dodati $fillable svojstva kako bismo mogli masovno dodijeliti svojstva.

Kako bismo mogli preko proizvoda dobiti njegovu kategoriju i sliku moramo u modelu Product dodati:

file - app\Models\Product.php

```
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_id',
        'category_id'
    ];


    /**
     * Get the category of the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the category of the product.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
```

U modelu Category i Image relacija je obrnuta. Jedna kategorija može imati puno proizvoda, jedna slika može imati više proizvoda koju je koristi.

U modelu Image nismo zainteresirani dobiti sve proizvode koje koriste jednu sliku, pa nećemo ni dodati relaciju modelu. 
Dodati ćemo samo $fillable svojstva.

file - file - app\Models\Image.php
```
class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'alt',
        'src'
    ];

}
```

U modelu Category trebat će nam relacija kako bismo mogli dobiti sve proizvode iz jedne kategorije. Dodat ćemo i $fillable svojstva.

file - file - app\Models\Category.php
```
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     * Get the products for the blog category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
```

### Seedanje

Kako bismo lakše kreirali poglede u sljedećem koraku, dodat ćemo par kategorija, slika i proizvoda.
Dodat ćemo ih koristeći seedere.

Moramo prije toga 'otvoriti' javni disk, kako bi korisnici mogli vidjeti slike proizvoda. Slike ćemo tako spremati na public disku u folderu images.
Na dokumentaciji možemo pronaći sljedeće [link](https://laravel.com/docs/11.x/filesystem#the-public-disk)

Za aktivirati public disk pokrećemo:

`php artisan storage:link`

Nakon toga možemo poćeti sa seederima. U folderu storage\app\public\images dodao sam par slika koje ćemo povezati s Image modelom.

Za kreirati seeder koristimo:
`php artisan make:seeder ImageSeeder`

`php artisan make:seeder CategorySeeder`

`php artisan make:seeder ProductSeeder`

U seederima kreirati ćemo par slika, kategorija i proizvoda:

file - database\seeders\ImageSeeder.php

```
/**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image = Image::create([
            'alt' => 'Savage Gear SGS2 All-Around Stap',
            'src' => '/images/Savage Gear SGS2 All-Around.png'
        ]);

        $image->id = 1; // kako bismo u seeder za proizvod mogli direktno koristiti image_id = 1 za ovu sliku.
        $image->save();

        $image = Image::create([
            'alt' => 'DTD Panic Shad 16g 120 Combo',
            'src' => '/images/DTD Panic Shad 16g 120 Combo.jpg'
        ]);

        $image->id = 2;
        $image->save();

        $image = Image::create([
            'alt' => 'Varivas Shock Leader',
            'src' => '/images/Varivas Shock Leader.jpg'
        ]);

        $image->id = 3;
        $image->save();
    }
```
file - database\seeders\CategorySeeder.php
```
    public function run(): void
    {
        $category = Category::create([
            'name' => 'Štapovi',
            'slug' => 'stapovi',
            'description' => 'Ribolovni štapovi.'
        ]);

        $category->id = 1;
        $category->save();

        $category = Category::create([
            'name' => 'Varalice',
            'slug' => 'varalice',
            'description' => 'Varalice za ribolov.'
        ]);

        $category->id = 2;
        $category->save();

        $category = Category::create([
            'name' => 'Najloni',
            'slug' => 'najloni',
            'description' => 'Najloni za ribolov.'
        ]);

        $category->id = 3;
        $category->save();
    }
```
file - database\seeders\ProductSeeder.php
```
 public function run(): void
    {
        Product::create([
            'name' => 'Savage Gear SGS2 All-Around',
            'description' => 'Savage Gear SGS2 All-Around Štapovi srednje duljine nude savršenu ravnotežu udaljenosti i točnosti zabacivanja, što ih čini idealnim za čitav niz različitih mjesta za ribolov u morskoj vodi uključujući luke, stijene i plaže. Omogućuju preciznu kontrolu tvrdih i mekih mamaca i, ovisno o težini bacanja koju odaberete, mogu se koristiti za ciljanje na mnoge različite vrste uključujući brancina, plavu ribu, palamide...',
            'price' => 84.81,
            'image_id' => 1,
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'Silikonac DTD Panic Shad 16g 120 Combo + body',
            'description' => 'Silikonac DTD Panic Shad 16g 120 Combo + body je novost iz DTD-a za 2023 godinu namjenjen lovu brancina opremljen Decoy udicom i proizveden u Japanu.',
            'price' => 6.50,
            'image_id' => 2,
            'category_id' => 2
        ]);

        Product::create([
            'name' => 'Fluorocarbon 100% Varivas Shock Leader',
            'description' => 'VARIVAS Fluorocarbon Shock Leader je tvrda, vrlo procizan leader otporan na abraziju dizajniran posebno za napredne ribolovne tehnike kao što su snažno vrtenje, popping, duboki jigging i ribolov na dnu. Uz izvrsnu otpornost na abraziju za zaštitu od kontakta sa kamenjem, zubima, perajama i dnom čamaca, također ima visoku otpornost na udarce. Uz gotovo nultu vidljivost, materijal od 100% fluorocarbona nestaje u vodi. Ovaj leader se preporučuje za ribolov na tune.
Napravljeno u Japanu.',
            'price' => 10.50,
            'image_id' => 3,
            'category_id' => 3
        ]);
    }
```

Sad kad smo namijestili seedere moramo iste dodati u run metodi database\seeders\DatabaseSeeder.php kako bi ste iste pokrenuli kada seedamo bazu.

file - database\seeders\DatabaseSeeder.php

```
    public function run(): void
    {

        $this->call([
            ImageSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
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

## Kontroler i pogledi za proizvod

Započet ćemo s pogledima za proizvode.

Draže mi je namijestiti Controller i View u isto vrijeme pa ću tako i raditi. 

### Lista proizvoda - index

U fileu routes\web.php povezali smo rutu GET /products s index metodom kontrolera ProductController. U kontroleru želimo dohvatiti proizvode i poslati ih u pogled za ovu rutu.

Dodati ćemo sljedeće ProductControlleru:

file - app\Http\Controllers\ProductController.php
```
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }
```

Koristimo ćemo laravel metodu paginate(12) koja će automatski paginirat 12 proizvoda po 12. Metoda paginate je jako korisna u tim situacijama jer automatski riješava paginaciju. Potrebno je samo dodati page parametar u rutu i laravel automatski dohvati drugu stranicu za nas.

Npr. ako idemo na rutu /products?page=2 pokušati će otvoriti drugu stranicu od 12 proizvoda. U seederu kreirali smo za sad samo 3 proizvoda pa ako idemo na tu rutu lista će biti prazna.

U kontroleru vratili smo pogled 'products.index' koji za sad ne postoji. Kreirat ćemo folder products u resources/views i nakon toga file resources\views\products\index.blade.php

Ovaj će file imati svrhu prikazat listu proizvoda.

file - resources\views\products\index.blade.php

```
<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Svi proizvodi') }}
        </h2>
    </x-slot>
    <ul class="my-8 mx-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

        @forelse ($products as $product)

            // Ovo je kartica za proizvod.
            <li>
                <a href="#" class="group relative block overflow-hidden">
                    <img src="{{ asset('/storage' . $product->image->src) }}" alt=""
                        class="h-64 w-full object-contain transition duration-500 group-hover:scale-105 sm:h-72" />

                    <div class="relative border border-gray-100 bg-white p-6">
                        <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $product->name }}</h3>

                        <p class="mt-1.5 text-sm text-gray-700">
                            {{ number_format((float) $product->price, 2, '.', '') }} €
                        </p>

                        // Dodaj u košaricu button
                        <a class="mt-6 inline-flex items-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500" href="#">
                            <span class="text-sm font-medium"> Dodaj u košaricu </span>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </a>
                    </div>
                </a>
            </li>
        @empty
            <li>
                Nemamo proizvoda za prikaz...
            </li>
        @endforelse

    </ul>
</x-app-layout>
```

Sad kad idemo na rutu /products trebali bismo vidijeti 3 proizvoda kojih smo dadali pomoću seedera.

### Kartica za prikaz proizvoda

Karticu za proizvod koristit ćemo i u drugim pogledima pa bi bilo korisno da istu premijestimo u svoju komponentu. Kreirat ćemo folder resources\views\components\products u kojem ćemo spremati sve komponente vezane za proizvode.

U folderu resources\views\components\products ćemo onda stvoriti file resources\views\components\products\card.blade.php koji će nam služiti za prikaz proivoda u kartici.

file - resources\views\components\products\card.blade.php
```
<a href="#" class="group relative block overflow-hidden">
    <img src="{{ asset('/storage' . $product->image->src) }}" alt=""
        class="h-64 w-full object-contain transition duration-500 group-hover:scale-105 sm:h-72" />

    <div class="relative border border-gray-100 bg-white p-6">
        <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $product->name }}</h3>

        <p class="mt-1.5 text-sm text-gray-700">
            {{ number_format((float) $product->price, 2, '.', '') }} €
        </p>


        // Dodaj u košaricu button
        <a class="mt-6 inline-flex items-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500" href="#">
            <span class="text-sm font-medium"> Dodaj u košaricu </span>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
        </a>
    </div>
</a>
```

### Tipka za dodavanje u košaricu

Button za dodat u košaricu možemo također izolirati u svoju komponentu pošto ćemo je prikazivatio na više mjesta, npr u stranici proizvoda, na listi proizvoda itd.

Kreirajmo onda file resources\views\components\products\addToCart.blade.php

file - resources\views\components\products\addToCart.blade.php
```
<a class="mt-6 inline-flex items-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500" href="#">
    <span class="text-sm font-medium"> Dodaj u košaricu </span>

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
        stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
    </svg>
</a>
```

Neznamo joša što ćemo kad netko klikne "dodaj u košaricu" pa ćemo za sada href ostavit prazan.

Sad u komponentu resources\views\components\products\card.blade.php možemo zamijenit dio za tipku dpodat u košaricu s novom komponentom:

file - resources\views\components\products\card.blade.php
```
<a href="#" class="group relative block overflow-hidden">
    <img src="{{ asset('/storage' . $product->image->src) }}" alt=""
        class="h-64 w-full object-contain transition duration-500 group-hover:scale-105 sm:h-72" />

    <div class="relative border border-gray-100 bg-white p-6">
        <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $product->name }}</h3>

        <p class="mt-1.5 text-sm text-gray-700">
            {{ number_format((float) $product->price, 2, '.', '') }} €
        </p>


        // Dodaj u košaricu button
        <x-products.addToCart :productId="$product->id" />
    </div>
</a>
```


Kako možemo viditi komponenta očekuje varijablu $product. Sad ćemo izmjeniti pogled resources\views\products\index.blade.php i zamijeniti dio kartice s novom komponentu.

file - resources\views\products\index.blade.php
```
<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Svi proizvodi }}
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
```

### Single proizvod - show

Sad kad imamo listu proizvoda bilo bi lijepo kada bismo mogli klikom na karticu proizvoda otvoriti stranicu za pregled proizvoda.

U route dodali smo rutu `Route::get('/{product}', [ProductController::class, 'show'])->name('products.show')`. Ova će nam ruta služit za pregled jednog proizvoda. 
Ruta očekuje parametar `{product}` koji je id proizvoda. U kontroleru ćemo dodati metodu show i u parametrima primati Product a Laravel će čarobno skužit da treba poslati u metodu proizvod s id-om koji smo upisali u rutu.

file - app\Http\Controllers\ProductController.php
```
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
```

Sad u folderu resources\views\products kreirat ćemo novu file show.blade.php

file - resources\views\products\show.blade.php
```
<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>


    <div class="bg-white">
        <div class="pt-6">
            <nav aria-label="Breadcrumb">
                <ol role="list"
                    class="mx-auto flex max-w-2xl items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                    <li>
                        <div class="flex items-center">
                            <a href="{{ route('products.index') }}"
                                class="mr-2 text-sm font-medium text-gray-900">Proizvodi</a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                                class="h-5 w-4 text-gray-300">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>

                    <li class="text-sm">
                        <a href="#" aria-current="page" class="font-medium text-gray-500 hover:text-gray-600">
                            {{ $product->category->name }}
                        </a>
                    </li>
                </ol>
            </nav>

            <!-- Image  -->
            <div class="mt-6 max-w-2xl sm:px-6">
                <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
                    <img src="{{ asset('/storage' . $product->image->src) }}" alt="{{ $product->image->alt }}"
                        class="h-full w-full object-cover object-center">
                </div>
            </div>

            <!-- Product info -->
            <div
                class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
                <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $product->name }}</h1>
                </div>

                <!-- Options -->
                <div class="mt-4 lg:row-span-3 lg:mt-0">
                    <h2 class="sr-only">Informacije o proizvodu</h2>
                    <p class="text-3xl tracking-tight text-gray-900">
                        {{ number_format($product->price, 2, '.', '') }} €
                    </p>

                    <a class="mt-6 inline-flex items-center gap-2 rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
                        href="#">
                        <span class="text-sm font-medium"> Dodaj u košaricu </span>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </a>
                </div>

                <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
                    <!-- Description and details -->
                    <div>
                        <h3 class="sr-only">Opis</h3>

                        <div class="space-y-6">
                            <p class="text-base text-gray-900">
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

```

Sad imamo pogled za prikaz jednog proizvoda. Možemo u resources\views\components\products\card.blade.php dodati poveznicu na proizvod:

file - resources\views\components\products\card.blade.php
```
<a href="{{ route('products.show', ['product' => $product->id]) }}" class="group relative block overflow-hidden">
    <img src="{{ asset('/storage' . $product->image->src) }}" alt="{{ $product->image->alt }}"
        class="h-64 w-full object-contain transition duration-500 group-hover:scale-105 sm:h-72" />

    <div class="relative border border-gray-100 bg-white p-6">
        <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $product->name }}</h3>

        <p class="mt-1.5 text-sm text-gray-700">
            {{ number_format($product->price, 2, '.', '') }} €
        </p>

        <form class="mt-4">
            <button class="block w-full rounded bg-indigo-400 p-4 text-sm font-medium transition hover:scale-105">
                Dodaj u košaricu
            </button>
        </form>
    </div>
</a>
```

### Kategorija proizvoda

Bilo bi lijepo filtrirati sve proizvode koji se nalaze u jednu kategoriju. Za to trebamo dodati rutu.

Ruta koja mi ima smisla za to je /products/category/{category-slug}. U routes\web.php idemo dodati tu novu rutu u grupu s prefixom 'products'.

file - routes\web.php
```
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/category/{categorySlug}', [ProductController::class, 'category'])->name('products.category'); // dodali smo ovu rutu
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
```

Sad u kontroleru `app\Http\Controllers\ProductController.php` dodajmo metodu category. Za pogled možemo iskoristit products.index koji prikazuje listu proizvoda.
Trebamo samo filtrirati proizvode po kategoriji prije nego ih šaljemo u pogled.

file - app\Http\Controllers\ProductController.php
```
    /**
     * Display a listing of the products filtered by category.
     */
    public function category(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $products = $category->products()->paginate(12);
        return view('products.index', ['title' => $category->name, 'products' => $products]);
    }
```

Dodali smo varijablu $title u pogled kako nebi pisalo 'Svi proizvodi' kao naslov pogledu products.index. Kako bi to radilo kako treba moramo malo izmijeniti pogled products.index:

file - resources\views\products\index.blade.php

```
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

```

Sad imamo pogled za prikaz proizvoda iz jedne kategorije. Idemo dalje.

### Forma za kreiranje proizvoda

Sad kad možemo pregledat proizvode ajmo dodati formu za kreiranje.

Postavili smo već rutu GET `/products/create` koja će nas voditi na formu.

`Route::get('/create', [ProductController::class, 'create'])->name('products.create');`

Rutu trebamo još zaštititi, omogućiti pregled rute samo admin useru. To ćemo poslije nakon što sredimo formu.

Možemo viditi kako nas ruta vodi na kontroler ProductController na metodu 'create'. Ajmo urediti kontroler.

file - app\Http\Controllers\ProductController.php
```
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }
```

U metodu create vraćamo samo view. Mogli smo direktno iz route vratit view umijesto metodu controllera ali draže mi je imati sve u kontroleru nego "razbacano" malo u routes malo u kontrolerima.

Ajmo sad urediti pogled za create formu. Kreirajmo file `resources\views\products\create.blade.php`

file - resources\views\products\create.blade.php
```
<x-app-layout>
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
</x-app-layout>
```
U formi za odabrat kategoriju koristio sam komponentu `<x-Products.CategorySelect name="category" id="category" />` koju još nismo kreirali.
Koristio sam komponentu samo za to jer ne želim u view poslati listu kategoriju iz kontrolera, po meni je bolje da komponenta sama učita svge kategorije iz baze.

Do sada smo koristili samo komponente kao view, koje nemaju neku svoju logiku nego služe samo za prikazivanje nečega. Ova komponenta želimo da bude "pametna", da sama pokupi potrebne podatke.

Za napraviti takvu komponentu možemo koristiti komandu ([Dokumentacija](https://laravel.com/docs/11.x/blade#components)):

`php artisan make:component Products/CategorySelect`

Artisan je za nas kreirao dvije datoteke:
- `app\View\Components\Products\CategorySelect.php` (ovdje ćemo pisati "logiku" komponente)
- `resources\views\components\products\category-select.blade.php` (ovdje ćemo pisati prikaz/view komponente)

`app\View\Components\Products\CategorySelect.php` dohvatit ćemo sve kategorije i poslati ih u njegov view.

file - `app\View\Components\Products\CategorySelect.php`
```
<?php
class CategorySelect extends Component
{

    public $categories;
    public $name;
    public $id;
    /**
     * Create a new component instance.
     */
    public function __construct($name = "category", $id = "category")
    {
        $this->name = $name;
        $this->id = $id;
        $this->categories = Category::orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.products.category-select');
    }
}
```

Svojstva koja su deklarirana kao public nije potrebno poslati ih eksplicitno u view već su automaski proslijeđene.

file - resources\views\components\products\category-select.blade.php
```
<select name="{{ $name ?? 'asd' }}" id="category"
    class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
    @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
</select>
```

Možemo posijetiti /products/create i vidjieti formu.

Sad kad smo sredili formu moramo spremiti kontroler za spremanje novih proizvoda.

file - app\Http\Controllers\ProductController.php
```
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|exists:images,id'
        ]);

        $path = $request->image->store('images', 'public');
        $image = Image::create([
            'alt' => $request->name,
            'src' => $path
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_id' => $image->id,
            'category_id' => $request->category,
        ]);

        return redirect()->route('products.index')->with('message', 'Proizvod uspiješno kreiran.');
    }
```

U kontroleru validairamo podatke koje smo poslali put metodom, spremamo novu sliku u public driveu i model Image u bazu te na kraju kreiramo novi proizvod i napravimo redirect na stranicu proizvoda s porukom 'Proizvod uspiješno kreiran.'.

Sad možemo ići na /products/create, dodati novi proizvod i moći ga vidjeti u popisu svih proizvoda.

### Forma za uređivanje proizvoda

Ajmo sada napraviti formu za izmjenu proizvoda. Rutu za formu postavili smo je ranije /products/edit/{product} koja nas đšalje na metodu edit kontrolera ProductController. Ajmo urediti metodu.

file - app\Http\Controllers\ProductController.php
```
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit');
    }
```

Sad ćemo kopirati pogled za formu za kreiranje proizvoda i malo je uredit.

file - resources\views\products\edit.blade.php
```
<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Uredi proizvod: {{ $product->name }}
        </h2>
    </x-slot>
    <div class="my-8 mx-8 ">
        <form class="flex flex-col gap-3" method="POST" action="{{ route('products.update', $product->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block font-medium text-gray-700"> Ime proizvoda </label>

                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                    class="mt-1 w-full rounded-md border-gray-200 shadow-sm " />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price"> Cijena proizvoda </label>
                <div class="flex gap-2 items-center">
                    <input type="number" step="0.01" min="0.01" id="price" name="price" required
                        value="{{ old('price', $product->price) }}"
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
                    placeholder="Opis proizvoda...">{{ old('description', $product->description) }}</textarea>
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
                @if ($product->image)
                    <div class="mt-6 max-w-2xl ">
                        <div class="hidden overflow-hidden rounded-lg lg:block">
                            <img src="{{ asset('/storage/' . $product->image->src) }}" alt="{{ $product->image->alt }}"
                                class="h-full w-full object-cover object-center">
                        </div>
                    </div>
                @endif
            </div>

            <div>
                <label for="category" class="block font-medium text-gray-700"> Kategorija proizvoda </label>

                <x-Products.CategorySelect name="category" id="category"
                    selected="{{ old('category', $product->category_id) }}" />
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
</x-app-layout>
```

Odredište akcije forme je ruta pod imenom 'products.update' i uz rutu šaljemo i ID proizvoda.
Ruta 'products.update' vodi nas na kontroler za proizvod u metodu update. Ajmo dodati tu metodu:

file - app\Http\Controllers\ProductController.php

```
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|exists:categories,id'
        ]);

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category');

        if ($request->hasFile('image')) {
            $path = $request->image->store('images', 'public');
            $image = Image::create([
                'alt' => $request->name,
                'src' => $path
            ]);
            $product->image_id = $image->id;
        }

        $product->save();
        return redirect()->route('products.index')->with('success', 'Proizvod uređen uspiješno.');
    }
```

Sad možemo urediti pogledati, dodati i urediti proizvode. Fali još samo način za ih obrisati. Za brisanje spremili smo već rutu DELETE /products/{product}. Ruta vodi na metodu `destroy` kotrolera ProductController.

### Tipka za brisanje proizvoda


Ideja je napraviti komponentu koja će izgledati kao tipka na kojoj će pisati "Obriši" i kad kliknemo na obriši da se otvori prozor koji će nas pitat za potvrdu. Kad potvrdimo onda se forma submita.

Spremimo prije kontroler koji je jednostavniji:

file - app\Http\Controllers\ProductController.php
```
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Proizvod izbrisan.');
    }
```

Kreirajmo sada komponentu. Komponenta će imat samo svrhu prikazivanja, nećemo imati potrebe napredne logike za tipku i formu.

Kako bi komponenta bila interaktivna trebamo nekako dodati javascript. Sa Breezom već nam je laravel dodao Alpine.js koji nam omogućuje da dodajemo interaktivnost bez da idemo ručno pisati javascript, već to radimo direktno u blade fileovima kao html tagove.

Kreirajmo sada datoteku `resources\views\components\products\delete-button.blade.php`

file - resources\views\components\products\delete-button.blade.php
```
<div x-data="{ open: false }">
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

    <div role="alert" x-cloak x-show="open"
        class="flex border border-gray-100 bg-white p-4 items-start rounded-lg shadow-2xl w-fit">

        <div class="flex items-start gap-4">
            <span class="text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </span>

            <form class="flex-1" method="POST" action={{ route('products.destroy', $id) }}>
                @csrf
                @method('DELETE')

                <strong class="block font-medium text-gray-900"> Želite li obrisati proizvod: </strong>

                <p class="mt-1 text-sm text-gray-700">Jednom kada obrišete prizvod nećete ga moći vratit.</p>

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
        </div>
        <button type="button" x-on:click="open = false" class="text-gray-500 transition hover:text-gray-600">
            <span class="sr-only">Zatvori</span>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
```

Sad imamo tipku za brisati proizvode. Možemo za testiranje ubacit komponentu u products.show pogled:

file - resources\views\products\show.blade.php
```
    ...
    <div class="bg-white">
            <div class="pt-6">
                <x-products.delete-button id="{{ $product->id }}" />

    ...
```

Kad smo isporbali možemo izbrisati tipku iz ovog pogleda.

Sad imamo sve osnovne funkcijonbalnosti za proizvod. Možemo kreirati, urediti, brisati i pregledati proizvode.

### Dodavanje autorizacije

Ajmo sada zaštiti rute kako bi mogli samo admini kreirati, urediti i brisati proizvode.
Za to koristit ćemo middleware.

Middleware nam omogućuje filtriranje zahtjeva koji ulaze u našu aplikaciju. Možemo dodati svoj middleware i u njemu pregledati tko je poslao zahtjev. Ako je zahtjev poslan od strane nekog admin onda će zahtjev proć, inače ne.

Možemo kreirati middleware koristeći artisan:

`php artisan make:middleware IsAdmin`

Laravel nam je dodao file `app\Http\Middleware\IsAdmin.php`

Ajmo ga urediti:

file - app\Http\Middleware\IsAdmin.php
```
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() &&  Auth::user()->is_admin == 1) {
            return $next($request);
        }

        return redirect()->route('products.index')->with('error', 'Nisi autorizirani!');
    }
```

Sad idemo dodati u rutama u fileu `routes\web.php` potrebni middleware kako bismo zaštitili rute.

file - routes\web.php
```
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/category/{categorySlug}', [ProductController::class, 'category'])->name('products.category');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create')->middleware(['auth', 'isAdmin']);
    Route::post('/', [ProductController::class, 'store'])->name('products.store')->middleware(['auth', 'isAdmin']);;
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('products.edit')->middleware(['auth', 'isAdmin']);;
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update')->middleware(['auth', 'isAdmin']);;
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware(['auth', 'isAdmin']);;
});
```

Sada ako nismo ulogirani kao admin nećemo moći pristupiti formama za kreiranje, uređivanje niti nećemo moći preko post metodama rutama `/store`, `/update` i `/destroy`.

### Dashboard

Bilo bi zgodno u dashboard dodati sekciju za uređivanje proizvoda.