# 📚 Swagger API Dokümantasyonu

Bu proje, Laravel API'nizi Swagger/OpenAPI formatında dokümante etmek için L5-Swagger paketini kullanır.

## 🚀 Swagger UI'a Erişim

API dokümantasyonuna erişmek için:

1. **Laravel sunucusunu başlatın:**
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

2. **Tarayıcıda şu adrese gidin:**
   ```
   http://localhost:8000/api/documentation
   ```

## 📋 Swagger Dokümantasyonunda Neler Var?

### 🏷️ **Türler (Genres)**
- **GET** `/api/turler` - Tüm türleri listele
- **POST** `/api/turler` - Yeni tür ekle
- **GET** `/api/turler/{id}` - Belirli türü getir
- **PUT** `/api/turler/{id}` - Tür güncelle
- **DELETE** `/api/turler/{id}` - Tür sil

### 👥 **Kişiler (People)**
- **GET** `/api/kisiler` - Tüm kişileri listele
- **POST** `/api/kisiler` - Yeni kişi ekle
- **GET** `/api/kisiler/{id}` - Belirli kişiyi getir
- **PUT** `/api/kisiler/{id}` - Kişi güncelle
- **DELETE** `/api/kisiler/{id}` - Kişi sil

### 🎬 **Filmler (Movies)**
- **GET** `/api/filmler` - Tüm filmleri listele
- **POST** `/api/filmler` - Yeni film ekle
- **GET** `/api/filmler/{id}` - Belirli filmi getir
- **PUT** `/api/filmler/{id}` - Film güncelle
- **DELETE** `/api/filmler/{id}` - Film sil
- **GET** `/api/filmler/tur/{tur_id}` - Türüne göre filmler
- **GET** `/api/filmler/search/{query}` - Film ara

### 🎭 **Oyuncular (Actors)**
- **GET** `/api/oyuncular` - Tüm oyuncuları listele
- **POST** `/api/oyuncular` - Yeni oyuncu ekle
- **GET** `/api/oyuncular/{id}` - Belirli oyuncuyu getir
- **PUT** `/api/oyuncular/{id}` - Oyuncu güncelle
- **DELETE** `/api/oyuncular/{id}` - Oyuncu sil

## 🔧 Swagger Özellikleri

### ✅ **Otomatik Dokümantasyon**
- Tüm API endpoint'leri otomatik olarak listelenir
- Request/Response şemaları otomatik oluşturulur
- Model ilişkileri görsel olarak gösterilir

### 🧪 **API Test Etme**
- Swagger UI üzerinden direkt API test edebilirsiniz
- Request body'leri kolayca düzenleyebilirsiniz
- Response'ları gerçek zamanlı görebilirsiniz

### 📊 **Detaylı Şemalar**
- Her model için detaylı property açıklamaları
- Veri türleri ve formatları
- Örnek değerler ve açıklamalar

## 🎯 Swagger UI'da Neler Yapabilirsiniz?

### 1. **Endpoint'leri Keşfedin**
- Tüm API endpoint'lerini kategorilere göre görün
- Her endpoint'in açıklamasını okuyun
- Request parametrelerini inceleyin

### 2. **API'yi Test Edin**
- "Try it out" butonuna tıklayın
- Request parametrelerini doldurun
- "Execute" butonuna tıklayın
- Response'u görün

### 3. **Şemaları İnceleyin**
- Model yapılarını görün
- İlişkileri anlayın
- Veri türlerini öğrenin

## 📝 Swagger Annotation Örnekleri

### Controller Annotation'ı
```php
/**
 * @OA\Get(
 *     path="/turler",
 *     summary="Tüm türleri listele",
 *     description="Veritabanındaki tüm film türlerini getirir",
 *     tags={"Türler"},
 *     @OA\Response(
 *         response=200,
 *         description="Başarılı",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Tur"))
 *         )
 *     )
 * )
 */
```

### Model Schema Annotation'ı
```php
/**
 * @OA\Schema(
 *     schema="Tur",
 *     title="Tür",
 *     description="Film türü modeli",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="adi", type="string", example="Aksiyon")
 * )
 */
```

## 🔄 Swagger Dokümantasyonunu Güncelleme

Kod değişikliklerinden sonra dokümantasyonu güncellemek için:

```bash
php artisan l5-swagger:generate
```

## 🌐 Swagger UI Özellikleri

### **Responsive Tasarım**
- Mobil ve masaüstü uyumlu
- Kolay navigasyon
- Modern arayüz

### **Gelişmiş Arama**
- Endpoint'lerde hızlı arama
- Tag'lere göre filtreleme
- Kolay bulma

### **Export Seçenekleri**
- JSON formatında export
- YAML formatında export
- PDF olarak yazdırma

## 🎉 Faydaları

1. **Geliştirici Deneyimi**: API'yi kolayca test edebilirsiniz
2. **Dokümantasyon**: Otomatik ve güncel dokümantasyon
3. **Test**: API endpoint'lerini test etmek için ayrı araç gerekmez
4. **Paylaşım**: Takım üyeleriyle API'yi kolayca paylaşabilirsiniz
5. **Entegrasyon**: Diğer geliştirici araçlarıyla entegre olur

## 🚀 Sonraki Adımlar

Swagger dokümantasyonunu daha da geliştirmek için:

1. **Authentication**: JWT token desteği ekleyin
2. **Error Responses**: Hata yanıtlarını detaylandırın
3. **Examples**: Daha fazla örnek ekleyin
4. **Grouping**: Endpoint'leri daha iyi gruplandırın
5. **Custom UI**: Swagger UI'ı özelleştirin

---

## 📖 Faydalı Linkler

- [Swagger UI](http://localhost:8000/api/documentation)
- [API Endpoints](http://localhost:8000/api)
- [L5-Swagger Paketi](https://github.com/DarkaOnLine/L5-Swagger)

---

**🎯 Swagger UI ile API'nizi profesyonel bir şekilde dokümante edin ve test edin!**
