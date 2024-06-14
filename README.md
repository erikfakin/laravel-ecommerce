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

## Korak 1 - migracije

U ovom ćemo koraku kreirati modele i migracije za Product, Category i Image. Moramo paziti na redosljedu jer Product
ima strani ključ za kategoriju i za sliku proizvoda.

### Image

```
# generirati ćemo model, migraciju i controller odjednom
php artisan make:model Image -mc
```

U migraciji dodati ćemo potrebna polja:

```
# file database\migrations\####_##_##_######_create_images_table.php
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

```
# file database\migrations\####_##_##_######_create_categories_table.php
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

```
# file database\migrations\####_##_##_######_create_products_table.php
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

U default migraciju za Usera morat ćemo dodati još jedno polje is_admin.



```
# file database\migrations\0001_01_01_000000_create_users_table.php
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