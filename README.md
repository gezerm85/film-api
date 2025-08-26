# 🎬 Sinema API - Detaylı Öğrenme Rehberi

Bu proje, Laravel ve MySQL kullanarak bir sinema API'si geliştirme sürecini adım adım öğretir. Her adım detaylı olarak açıklanmıştır.

## 📚 İçindekiler

1. [Proje Hakkında](#proje-hakkında)
2. [Gereksinimler](#gereksinimler)
3. [Kurulum Adımları](#kurulum-adımları)
4. [Veritabanı Tasarımı](#veritabanı-tasarımı)
5. [Migration Oluşturma](#migration-oluşturma)
6. [Model Oluşturma](#model-oluşturma)
7. [Controller Oluşturma](#controller-oluşturma)
8. [Route Tanımlama](#route-tanımlama)
9. [API Test Etme](#api-test-etme)
10. [Öğrenilen Kavramlar](#öğrenilen-kavramlar)
11. [Sık Sorulan Sorular](#sık-sorulan-sorular)

---

## 🎯 Proje Hakkında

Bu proje, sinema dünyasındaki filmleri, türleri, kişileri ve oyuncuları yönetmek için geliştirilmiş bir REST API'dir. Laravel framework'ünün temel özelliklerini öğrenmek için mükemmel bir başlangıç projesidir.

### 🎬 Proje Amacı
- Film bilgilerini saklama ve yönetme
- Film türlerini kategorize etme
- Oyuncu ve kişi bilgilerini tutma
- Film-oyuncu ilişkilerini yönetme
- RESTful API prensiplerini uygulama

---

## 🔧 Gereksinimler

### Sistem Gereksinimleri
- **PHP**: 8.2 veya üzeri
- **Composer**: PHP paket yöneticisi
- **MySQL**: 5.7 veya üzeri
- **Web Sunucusu**: Apache/Nginx (Laravel'in built-in sunucusu da kullanılabilir)

### Yazılım Gereksinimleri
- **Laravel**: 11.x (en son sürüm)
- **MySQL Driver**: PHP MySQL extension
- **Adminer**: Veritabanı yönetimi için (opsiyonel)

---

## 🚀 Kurulum Adımları

### 1. Laravel Projesi Oluşturma

```bash
# Yeni Laravel projesi oluştur
composer create-project laravel/laravel film-api

# Proje dizinine git
cd film-api
```

**🔍 Ne Oldu?**
- `composer create-project` komutu, Laravel'in en son sürümünü indirir
- Proje klasörü oluşturulur ve tüm Laravel dosyaları yüklenir
- `vendor/` klasöründe tüm bağımlılıklar bulunur

### 2. Veritabanı Yapılandırması

```bash
# .env dosyasını kopyala
cp .env.example .env

# .env dosyasını düzenle
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sinema_db
DB_USERNAME=root
DB_PASSWORD=348282
```

**🔍 Ne Oldu?**
- `.env` dosyası, proje konfigürasyonlarını içerir
- Veritabanı bağlantı bilgileri burada tanımlanır
- Güvenlik için bu dosya git'e commit edilmez

### 3. Uygulama Anahtarı Oluşturma

```bash
# Uygulama anahtarı oluştur
php artisan key:generate
```

**🔍 Ne Oldu?**
- Laravel, güvenlik için bir encryption key kullanır
- Bu key, session, cookie ve diğer şifrelenmiş veriler için gereklidir

---

## 🗄️ Veritabanı Tasarımı

### Veritabanı Şeması

```sql
-- Türler tablosu
CREATE TABLE turler (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    adi VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Kişiler tablosu  
CREATE TABLE kisiler (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    adi VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Filmler tablosu
CREATE TABLE filmler (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    adi VARCHAR(255) NOT NULL,
    konusu TEXT NOT NULL,
    imdb_puani DECIMAL(3,1) NULL,
    tur_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (tur_id) REFERENCES turler(id) ON DELETE CASCADE
);

-- Oyuncular tablosu
CREATE TABLE oyuncular (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    film_id BIGINT UNSIGNED NOT NULL,
    kisi_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (film_id) REFERENCES filmler(id) ON DELETE CASCADE,
    FOREIGN KEY (kisi_id) REFERENCES kisiler(id) ON DELETE CASCADE
);
```

### 🔍 İlişki Analizi

1. **One-to-Many (Bir-Çok)**: Bir türde birden fazla film olabilir
2. **Many-to-Many (Çok-Çok)**: Bir filmde birden fazla oyuncu, bir oyuncu birden fazla filmde oynayabilir
3. **Foreign Key**: Referential integrity sağlar
4. **Cascade Delete**: Ana kayıt silindiğinde bağlı kayıtlar da silinir

---

## 📝 Migration Oluşturma

### Migration Nedir?

Migration, veritabanı şemasını kod olarak tanımlamanızı sağlar. Bu sayede:
- Veritabanı değişikliklerini versiyon kontrolü altında tutabilirsiniz
- Takım çalışmasında veritabanı senkronizasyonu sağlanır
- Rollback (geri alma) yapabilirsiniz

### 1. Migration Dosyası Oluşturma

```bash
# Türler tablosu için migration
php artisan make:migration create_turler_table

# Kişiler tablosu için migration
php artisan make:migration create_kisiler_table

# Filmler tablosu için migration
php artisan make:migration create_filmler_table

# Oyuncular tablosu için migration
php artisan make:migration create_oyuncular_table
```

**🔍 Ne Oldu?**
- `database/migrations/` klasöründe yeni dosyalar oluştu
- Her dosya benzersiz bir timestamp ile adlandırıldı
- Bu sayede migration'lar sırayla çalışır

### 2. Migration Dosyası İçeriği

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('turler', function (Blueprint $table) {
            $table->id();                    // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('adi');           // VARCHAR(255)
            $table->timestamps();            // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turler');     // Rollback için
    }
};
```

**🔍 Ne Oldu?**
- `up()` metodu: Migration çalıştırıldığında ne yapılacağını tanımlar
- `down()` metodu: Migration geri alındığında ne yapılacağını tanımlar
- `Schema::create()`: Yeni tablo oluşturur
- `Blueprint`: Tablo yapısını tanımlar

### 3. Migration Çalıştırma

```bash
# Migration'ları çalıştır
php artisan migrate

# Migration durumunu kontrol et
php artisan migrate:status

# Migration'ları geri al
php artisan migrate:rollback

# Tüm migration'ları sıfırla
php artisan migrate:reset
```

**🔍 Ne Oldu?**
- `migrate`: Henüz çalışmamış migration'ları çalıştırır
- `migrate:status`: Hangi migration'ların çalıştığını gösterir
- `migrate:rollback`: Son migration'ı geri alır
- `migrate:reset`: Tüm migration'ları geri alır

---

## 🎭 Model Oluşturma

### Model Nedir?

Model, veritabanı tablolarını PHP sınıfları olarak temsil eder. Eloquent ORM kullanarak:
- Veritabanı işlemlerini kolayca yapabilirsiniz
- İlişkileri tanımlayabilirsiniz
- Veri doğrulama kuralları ekleyebilirsiniz

### 1. Model Oluşturma

```bash
# Model oluştur
php artisan make:model Tur
php artisan make:model Kisi
php artisan make:model Film
php artisan make:model Oyuncu
```

**🔍 Ne Oldu?**
- `app/Models/` klasöründe yeni PHP sınıfları oluştu
- Her model, bir veritabanı tablosunu temsil eder
- Model isimleri tekil olmalıdır (Tur, Film, Kisi, Oyuncu)

### 2. Model İçeriği

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tur extends Model
{
    // Hangi tabloyu kullanacağını belirt
    protected $table = 'turler';
    
    // Toplu atama için güvenli alanlar
    protected $fillable = [
        'adi'
    ];

    // İlişki tanımlama
    public function filmler()
    {
        return $this->hasMany(Film::class, 'tur_id');
    }
}
```

**🔍 Ne Oldu?**
- `protected $table`: Model'in hangi tabloyu kullanacağını belirtir
- `protected $fillable`: Toplu atama (mass assignment) için güvenli alanları tanımlar
- `public function filmler()`: İlişki metodunu tanımlar

### 3. İlişki Türleri

```php
// One-to-Many (Bir-Çok)
public function filmler()
{
    return $this->hasMany(Film::class, 'tur_id');
}

// Many-to-One (Çok-Bir)
public function tur()
{
    return $this->belongsTo(Tur::class, 'tur_id');
}

// Many-to-Many (Çok-Çok)
public function oyuncular()
{
    return $this->hasMany(Oyuncu::class, 'film_id');
}
```

**🔍 Ne Oldu?**
- `hasMany()`: Bir türde birden fazla film olabileceğini belirtir
- `belongsTo()`: Bir filmin bir türe ait olduğunu belirtir
- `hasMany()`: Bir filmde birden fazla oyuncu olabileceğini belirtir

---

## 🎮 Controller Oluşturma

### Controller Nedir?

Controller, HTTP isteklerini karşılar ve yanıt verir. MVC (Model-View-Controller) mimarisinde:
- Model ile veritabanı işlemlerini yapar
- İş mantığını yönetir
- HTTP yanıtlarını döner

### 1. Controller Oluşturma

```bash
# Resource controller oluştur (CRUD işlemleri için)
php artisan make:controller TurController --resource
php artisan make:controller KisiController --resource
php artisan make:controller FilmController --resource
php artisan make:controller OyuncuController --resource
```

**🔍 Ne Oldu?**
- `--resource` flag'i ile 7 temel CRUD metodu oluşur
- `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`
- Her metod HTTP isteklerini karşılar

### 2. Controller Metodları

```php
<?php

namespace App\Http\Controllers;

use App\Models\Tur;
use Illuminate\Http\Request;
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
        $request->validate([
            'adi' => 'required|string|max:255'
        ]);

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
        
        $request->validate([
            'adi' => 'required|string|max:255'
        ]);

        $tur->update($request->all());
        return response()->json(['data' => $tur]);
    }

    // Tür sil
    public function destroy(string $id): JsonResponse
    {
        $tur = Tur::findOrFail($id);
        $tur->delete();
        return response()->json(['message' => 'Tür başarıyla silindi']);
    }
}
```

**🔍 Ne Oldu?**
- `index()`: GET /api/turler - Tüm türleri listeler
- `store()`: POST /api/turler - Yeni tür ekler
- `show()`: GET /api/turler/{id} - Belirli türü getirir
- `update()`: PUT /api/turler/{id} - Tür günceller
- `destroy()`: DELETE /api/turler/{id} - Tür siler

### 3. Veri Doğrulama (Validation)

```php
$request->validate([
    'adi' => 'required|string|max:255'
]);
```

**🔍 Ne Oldu?**
- `required`: Alan zorunludur
- `string`: Metin türünde olmalıdır
- `max:255`: Maksimum 255 karakter olabilir
- Doğrulama başarısız olursa otomatik hata döner

### 4. HTTP Yanıtları

```php
// Başarılı yanıt
return response()->json(['data' => $tur]);

// Oluşturuldu yanıtı (201)
return response()->json(['data' => $tur], 201);

// Hata yanıtı
return response()->json(['error' => 'Kayıt bulunamadı'], 404);
```

**🔍 Ne Oldu?**
- `response()->json()`: JSON formatında yanıt döner
- İkinci parametre HTTP status code'u belirtir
- 200: Başarılı, 201: Oluşturuldu, 404: Bulunamadı

---

## 🛣️ Route Tanımlama

### Route Nedir?

Route, HTTP isteklerini hangi controller metoduna yönlendireceğini tanımlar. Laravel'de:
- Web route'ları `routes/web.php` dosyasında
- API route'ları `routes/api.php` dosyasında tanımlanır

### 1. API Route Dosyası

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurController;
use App\Http\Controllers\KisiController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\OyuncuController;

// API Resource Routes
Route::apiResource('turler', TurController::class);
Route::apiResource('kisiler', KisiController::class);
Route::apiResource('filmler', FilmController::class);
Route::apiResource('oyuncular', OyuncuController::class);

// Özel route'lar
Route::get('/filmler/tur/{tur_id}', [FilmController::class, 'getByTur']);
Route::get('/filmler/search/{query}', [FilmController::class, 'search']);
```

**🔍 Ne Oldu?**
- `Route::apiResource()`: 7 CRUD route'unu otomatik oluşturur
- `use` statement'ları: Controller sınıflarını import eder
- Özel route'lar: Ek fonksiyonalite için

### 2. Laravel 11 Route Yapılandırması

Laravel 11'de API route'larını aktif etmek için `bootstrap/app.php` dosyasını düzenlemek gerekir:

```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',  // Bu satırı ekleyin
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
```

**🔍 Ne Oldu?**
- Laravel 11'de API route'ları varsayılan olarak aktif değil
- `api:` parametresi ile API route'ları aktif edilir
- Bu sayede `/api/` prefix'i ile route'lar çalışır

### 3. Oluşan Route'lar

```bash
# Route'ları listele
php artisan route:list --path=api
```

**Çıktı:**
```
GET|HEAD  api/turler                    turler.index   › TurController@index
POST      api/turler                    turler.store   › TurController@store
GET|HEAD  api/turler/{turler}          turler.show    › TurController@show
PUT|PATCH api/turler/{turler}          turler.update  › TurController@update
DELETE    api/turler/{turler}          turler.destroy › TurController@destroy
```

**🔍 Ne Oldu?**
- `GET /api/turler`: Tüm türleri listeler
- `POST /api/turler`: Yeni tür ekler
- `GET /api/turler/{id}`: Belirli türü getirir
- `PUT /api/turler/{id}`: Tür günceller
- `DELETE /api/turler/{id}`: Tür siler

---

## 🧪 API Test Etme

### 1. Laravel Sunucusu Başlatma

```bash
# Sunucuyu başlat
php artisan serve --host=0.0.0.0 --port=8000

# Arka planda çalıştır
php artisan serve --host=0.0.0.0 --port=8000 &
```

**🔍 Ne Oldu?**
- `--host=0.0.0.0`: Tüm IP adreslerinden erişime izin verir
- `--port=8000`: 8000 portunda çalışır
- `&`: Arka planda çalıştırır

### 2. cURL ile Test Etme

```bash
# Tüm türleri listele
curl -X GET http://localhost:8000/api/turler

# Yeni tür ekle
curl -X POST http://localhost:8000/api/turler \
  -H "Content-Type: application/json" \
  -d '{"adi": "Aksiyon"}'

# Belirli türü getir
curl -X GET http://localhost:8000/api/turler/1

# Tür güncelle
curl -X PUT http://localhost:8000/api/turler/1 \
  -H "Content-Type: application/json" \
  -d '{"adi": "Aksiyon Filmleri"}'

# Tür sil
curl -X DELETE http://localhost:8000/api/turler/1
```

**🔍 Ne Oldu?**
- `-X`: HTTP metodunu belirtir (GET, POST, PUT, DELETE)
- `-H`: HTTP header ekler
- `-d`: Request body (veri) ekler

### 3. Postman ile Test Etme

Postman gibi API test araçları kullanarak da test edebilirsiniz:

1. **GET Request**: `http://localhost:8000/api/turler`
2. **POST Request**: `http://localhost:8000/api/turler`
   - Body: `{"adi": "Aksiyon"}`
   - Headers: `Content-Type: application/json`

---

## 📚 Öğrenilen Kavramlar

### 1. Laravel Temelleri
- **Artisan CLI**: Laravel komut satırı aracı
- **Service Container**: Dependency injection container
- **Facades**: Statik interface'ler
- **Middleware**: HTTP request/response filtreleme

### 2. Veritabanı İşlemleri
- **Migration**: Veritabanı şema yönetimi
- **Eloquent ORM**: Object-Relational Mapping
- **Relationships**: Tablo ilişkileri
- **Query Builder**: SQL sorgu oluşturma

### 3. API Geliştirme
- **RESTful API**: REST prensiplerine uygun API
- **Resource Controllers**: CRUD işlemleri için controller
- **API Resources**: Response formatı standardizasyonu
- **Validation**: Veri doğrulama

### 4. HTTP Kavramları
- **HTTP Methods**: GET, POST, PUT, DELETE
- **Status Codes**: 200, 201, 404, 500
- **Headers**: Content-Type, Authorization
- **Request/Response**: İstek ve yanıt yapısı

---

## ❓ Sık Sorulan Sorular

### Q: Migration'ları nasıl geri alabilirim?
**A:** `php artisan migrate:rollback` komutu ile son migration'ı geri alabilirsiniz.

### Q: Model'de tablo adını nasıl değiştirebilirim?
**A:** `protected $table = 'yeni_tablo_adi';` property'sini kullanabilirsiniz.

### Q: API route'ları çalışmıyor, ne yapmalıyım?
**A:** `bootstrap/app.php` dosyasında `api:` parametresini eklediğinizden emin olun.

### Q: Veritabanı bağlantı hatası alıyorum, ne yapmalıyım?
**A:** `.env` dosyasındaki veritabanı bilgilerini kontrol edin ve MySQL servisinin çalıştığından emin olun.

### Q: Controller'da validation hatası nasıl yakalarım?
**A:** Laravel otomatik olarak validation hatalarını yakalar ve JSON response döner.

---

## 🎯 Sonraki Adımlar

Bu projeyi tamamladıktan sonra şunları öğrenebilirsiniz:

1. **Authentication**: JWT veya Sanctum ile kullanıcı girişi
2. **Authorization**: Rol tabanlı yetkilendirme
3. **File Upload**: Resim ve dosya yükleme
4. **Pagination**: Sayfalama sistemi
5. **Caching**: Redis ile önbellekleme
6. **Testing**: PHPUnit ile test yazma
7. **Deployment**: Sunucuya yükleme

---

## 📖 Faydalı Kaynaklar

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Eloquent Relationships](https://laravel.com/docs/eloquent-relationships)
- [Laravel API Resources](https://laravel.com/docs/api-resources)
- [REST API Design](https://restfulapi.net/)

---


