# 🚀 Laravel API Oluşturma - 101 Rehberi



---

## 📋 Ne Yapacağız?

Bu rehberde **4 tablolu bir sinema API'si** oluşturacağız:
- 🎬 **Filmler** (film adı, konusu, IMDB puanı, türü)
- 🏷️ **Türler** (aksiyon, komedi, drama vs.)
- 👥 **Kişiler** (oyuncular, yönetmenler)
- 🎭 **Oyuncular** (hangi filmde kim oynadı)

---

## ⚡ Hızlı Başlangıç (5 Dakika)

### 1️⃣ Laravel Kurulumu
```bash
# Yeni proje oluştur
composer create-project laravel/laravel film-api
cd film-api

# Veritabanı ayarlarını yap
cp .env.example .env
```

### 2️⃣ Veritabanı Ayarları
`.env` dosyasında şunları değiştir:
```env
DB_CONNECTION=mysql
DB_DATABASE=sinema_db
DB_USERNAME=root
DB_PASSWORD=348282
```

### 3️⃣ Migration'ları Çalıştır
```bash
php artisan migrate
```

### 4️⃣ Sunucuyu Başlat
```bash
php artisan serve
```

**🎉 API hazır!** `http://localhost:8000/api/` adresinde çalışıyor.

---

## 🔧 Detaylı Adımlar

### Adım 1: Laravel Projesi Oluştur
```bash
composer create-project laravel/laravel film-api
cd film-api
```

**Ne oldu?** Laravel kuruldu ve proje klasörü oluştu.

### Adım 2: Veritabanı Ayarları
```bash


# .env dosyasını düzenle (MySQL için)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sinema_db
DB_USERNAME=root
DB_PASSWORD=
```

**Ne oldu?** Veritabanı bağlantı bilgileri ayarlandı.

### Adım 3: Migration Dosyaları Oluştur
```bash
# 4 tablo için migration oluştur
php artisan make:migration create_turler_table
php artisan make:migration create_kisiler_table
php artisan make:migration create_filmler_table
php artisan make:migration create_oyuncular_table
```

**Ne oldu?** `database/migrations/` klasöründe 4 dosya oluştu.

### Adım 4: Migration İçeriklerini Düzenle

#### 📁 `create_turler_table.php`
```php
public function up(): void
{
    Schema::create('turler', function (Blueprint $table) {
        $table->id();           // Otomatik artan ID
        $table->string('adi');  // Tür adı (aksiyon, komedi vs.)
        $table->timestamps();   // Oluşturma ve güncelleme tarihi
    });
}
```

#### 📁 `create_kisiler_table.php`
```php
public function up(): void
{
    Schema::create('kisiler', function (Blueprint $table) {
        $table->id();           // Otomatik artan ID
        $table->string('adi');  // Kişi adı (Keanu Reeves vs.)
        $table->timestamps();   // Oluşturma ve güncelleme tarihi
    });
}
```

#### 📁 `create_filmler_table.php`
```php
public function up(): void
{
    Schema::create('filmler', function (Blueprint $table) {
        $table->id();                    // Otomatik artan ID
        $table->string('adi');           // Film adı
        $table->text('konusu');          // Film konusu
        $table->decimal('imdb_puani', 3, 1); // IMDB puanı (8.5 gibi)
        $table->foreignId('tur_id');     // Hangi türe ait
        $table->timestamps();            // Oluşturma ve güncelleme tarihi
    });
}
```

#### 📁 `create_oyuncular_table.php`
```php
public function up(): void
{
    Schema::create('oyuncular', function (Blueprint $table) {
        $table->id();                    // Otomatik artan ID
        $table->foreignId('film_id');    // Hangi filmde
        $table->foreignId('kisi_id');    // Kim oynadı
        $table->timestamps();            // Oluşturma ve güncelleme tarihi
    });
}
```

**Ne oldu?** Tablo yapıları tanımlandı.

### Adım 5: Migration'ları Çalıştır
```bash
php artisan migrate
```

**Ne oldu?** Veritabanında 4 tablo oluştu.

### Adım 6: Model'leri Oluştur
```bash
# 4 model oluştur
php artisan make:model Tur
php artisan make:model Kisi
php artisan make:model Film
php artisan make:model Oyuncu
```

**Ne oldu?** `app/Models/` klasöründe 4 PHP dosyası oluştu.

### Adım 7: Model İçeriklerini Düzenle

#### 📁 `app/Models/Tur.php`
```php
class Tur extends Model
{
    protected $table = 'turler';  // Hangi tabloyu kullanacağını belirt
    
    protected $fillable = ['adi']; // Hangi alanları doldurabileceğini belirt
    
    // Bir türde birden fazla film olabilir
    public function filmler()
    {
        return $this->hasMany(Film::class, 'tur_id');
    }
}
```

#### 📁 `app/Models/Kisi.php`
```php
class Kisi extends Model
{
    protected $table = 'kisiler';
    protected $fillable = ['adi'];
    
    // Bir kişi birden fazla filmde oynayabilir
    public function oyuncular()
    {
        return $this->hasMany(Oyuncu::class, 'kisi_id');
    }
}
```

#### 📁 `app/Models/Film.php`
```php
class Film extends Model
{
    protected $table = 'filmler';
    protected $fillable = ['adi', 'konusu', 'imdb_puani', 'tur_id'];
    
    // Bir film bir türe ait
    public function tur()
    {
        return $this->belongsTo(Tur::class, 'tur_id');
    }
    
    // Bir filmde birden fazla oyuncu olabilir
    public function oyuncular()
    {
        return $this->hasMany(Oyuncu::class, 'film_id');
    }
}
```

#### 📁 `app/Models/Oyuncu.php`
```php
class Oyuncu extends Model
{
    protected $table = 'oyuncular';
    protected $fillable = ['film_id', 'kisi_id'];
    
    // Hangi filmde oynadı
    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }
    
    // Kim oynadı
    public function kisi()
    {
        return $this->belongsTo(Kisi::class, 'kisi_id');
    }
}
```

**Ne oldu?** Model'ler veritabanı tablolarını temsil ediyor.

### Adım 8: Controller'ları Oluştur
```bash
# 4 controller oluştur (CRUD işlemleri için)
php artisan make:controller TurController --resource
php artisan make:controller KisiController --resource
php artisan make:controller FilmController --resource
php artisan make:controller OyuncuController --resource
```

**Ne oldu?** `app/Http/Controllers/` klasöründe 4 controller oluştu.

### Adım 9: Controller İçeriklerini Düzenle

#### 📁 `app/Http/Controllers/TurController.php`
```php
use App\Models\Tur;
use Illuminate\Http\JsonResponse;

class TurController extends Controller
{
    // Tüm türleri listele
    public function index(): JsonResponse
    {
        $turler = Tur::all();
        return response()->json(['data' => $turler]);
    }
    
    // Yeni tür ekle
    public function store(Request $request): JsonResponse
    {
        $request->validate(['adi' => 'required|string|max:255']);
        $tur = Tur::create($request->all());
        return response()->json(['data' => $tur], 201);
    }
    
    // Belirli türü getir
    public function show(string $id): JsonResponse
    {
        $tur = Tur::findOrFail($id);
        return response()->json(['data' => $tur]);
    }
    
    // Tür güncelle
    public function update(Request $request, string $id): JsonResponse
    {
        $tur = Tur::findOrFail($id);
        $request->validate(['adi' => 'required|string|max:255']);
        $tur->update($request->all());
        return response()->json(['data' => $tur]);
    }
    
    // Tür sil
    public function destroy(string $id): JsonResponse
    {
        $tur = Tur::findOrFail($id);
        $tur->delete();
        return response()->json(['message' => 'Tür silindi']);
    }
}
```

**Diğer controller'lar da aynı şekilde düzenle!**

**Ne oldu?** Controller'lar HTTP isteklerini karşılıyor.

### Adım 10: Route'ları Tanımla

#### 📁 `routes/api.php`
```php
use App\Http\Controllers\TurController;
use App\Http\Controllers\KisiController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\OyuncuController;

// 4 tablo için otomatik route'lar
Route::apiResource('turler', TurController::class);
Route::apiResource('kisiler', KisiController::class);
Route::apiResource('filmler', FilmController::class);
Route::apiResource('oyuncular', OyuncuController::class);

// Ek route'lar
Route::get('/filmler/tur/{tur_id}', [FilmController::class, 'getByTur']);
Route::get('/filmler/search/{query}', [FilmController::class, 'search']);
```

**Ne oldu?** API endpoint'leri tanımlandı.

### Adım 11: Laravel 11 Route Ayarı

#### 📁 `bootstrap/app.php`
```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',  // Bu satırı ekle!
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
```

**Ne oldu?** API route'ları aktif edildi.

### Adım 12: Sunucuyu Başlat
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

**Ne oldu?** API çalışmaya başladı.

---

## 🧪 API'yi Test Et

### Test 1: Tür Ekle
```bash
curl -X POST http://localhost:8000/api/turler \
  -H "Content-Type: application/json" \
  -d '{"adi": "Aksiyon"}'
```

### Test 2: Kişi Ekle
```bash
curl -X POST http://localhost:8000/api/kisiler \
  -H "Content-Type: application/json" \
  -d '{"adi": "Keanu Reeves"}'
```

### Test 3: Film Ekle
```bash
curl -X POST http://localhost:8000/api/filmler \
  -H "Content-Type: application/json" \
  -d '{"adi": "The Matrix", "konusu": "Bilgisayar programcısı...", "imdb_puani": 8.7, "tur_id": 1}'
```

### Test 4: Oyuncu Ekle
```bash
curl -X POST http://localhost:8000/api/oyuncular \
  -H "Content-Type: application/json" \
  -d '{"film_id": 1, "kisi_id": 1}'
```

### Test 5: Verileri Listele
```bash
# Tüm türleri listele
curl http://localhost:8000/api/turler

# Tüm filmleri listele
curl http://localhost:8000/api/filmler

# Tüm kişileri listele
curl http://localhost:8000/api/kisiler

# Tüm oyuncuları listele
curl http://localhost:8000/api/oyuncular
```

---

## 📚 Oluşan API Endpoint'leri

### 🏷️ Türler
- `GET /api/turler` - Tüm türleri listele
- `POST /api/turler` - Yeni tür ekle
- `GET /api/turler/{id}` - Belirli türü getir
- `PUT /api/turler/{id}` - Tür güncelle
- `DELETE /api/turler/{id}` - Tür sil

### 👥 Kişiler
- `GET /api/kisiler` - Tüm kişileri listele
- `POST /api/kisiler` - Yeni kişi ekle
- `GET /api/kisiler/{id}` - Belirli kişiyi getir
- `PUT /api/kisiler/{id}` - Kişi güncelle
- `DELETE /api/kisiler/{id}` - Kişi sil

### 🎬 Filmler
- `GET /api/filmler` - Tüm filmleri listele
- `POST /api/filmler` - Yeni film ekle
- `GET /api/filmler/{id}` - Belirli filmi getir
- `PUT /api/filmler/{id}` - Film güncelle
- `DELETE /api/filmler/{id}` - Film sil
- `GET /api/filmler/tur/{tur_id}` - Türüne göre filmler
- `GET /api/filmler/search/{query}` - Film ara

### 🎭 Oyuncular
- `GET /api/oyuncular` - Tüm oyuncuları listele
- `POST /api/oyuncular` - Yeni oyuncu ekle
- `GET /api/oyuncular/{id}` - Belirli oyuncuyu getir
- `PUT /api/oyuncular/{id}` - Oyuncu güncelle
- `DELETE /api/oyuncular/{id}` - Oyuncu sil

---

## ❓ Sık Karşılaşılan Sorunlar

### Sorun 1: "Route not found" hatası
**Çözüm:** `bootstrap/app.php` dosyasında `api:` satırını eklediğinden emin ol.

### Sorun 2: Veritabanı bağlantı hatası
**Çözüm:** `.env` dosyasındaki veritabanı bilgilerini kontrol et.

### Sorun 3: Migration hatası
**Çözüm:** `php artisan migrate:fresh` komutunu çalıştır.

### Sorun 4: Port 8000 kullanımda
**Çözüm:** `php artisan serve --port=8001` ile farklı port kullan.

---

## 🎯 Sonraki Adımlar

Bu API'yi tamamladıktan sonra şunları ekleyebilirsin:

1. **Kullanıcı Girişi** - JWT token ile
2. **Resim Yükleme** - Film posterleri için
3. **Arama ve Filtreleme** - Gelişmiş arama
4. **Sayfalama** - Çok veri için
5. **Cache** - Hızlı erişim için

---

## 🎉 Tebrikler!

Artık kendi Laravel API'lerini oluşturabilirsin! 

**Özet:**
- ✅ Laravel projesi oluşturdun
- ✅ Veritabanı tabloları tanımladın
- ✅ Model'ler oluşturdun
- ✅ Controller'lar yazdın
- ✅ Route'lar tanımladın
- ✅ API'yi test ettin

**Bir sonraki projede görüşmek üzere! 🚀**
