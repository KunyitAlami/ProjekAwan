# MiniStack Cloud - Simulasi Infrastructure as a Service (IaaS)

## Deskripsi

MiniStack Cloud merupakan aplikasi simulasi **Infrastructure as a Service (IaaS)** berbasis web yang dibangun menggunakan **Laravel** dan **MiniStack** sebagai penyedia layanan cloud lokal. Sistem ini memungkinkan pengguna untuk mengelola sumber daya cloud seperti bucket penyimpanan, resource komputasi, serta melakukan upgrade paket layanan melalui integrasi dengan **Midtrans Sandbox**.

Proyek ini dikembangkan sebagai tugas akhir mata kuliah **Komputasi Awan** Program Studi Teknologi Informasi Universitas Lambung Mangkurat.

---

## Fitur Utama

- Registrasi dan autentikasi pengguna
- Dashboard pengguna
- Manajemen paket langganan
- Upgrade paket menggunakan Midtrans Sandbox
- Pembuatan dan pengelolaan bucket storage
- Upload dan penghapusan file pada bucket
- Pengelolaan resource komputasi
- Start dan stop resource
- Dashboard administrator
- Integrasi object storage berbasis MiniStack

---

## Teknologi yang Digunakan

| Teknologi        | Keterangan                   |
| ---------------- | ---------------------------- |
| Laravel          | Framework backend            |
| MySQL            | Basis data                   |
| Docker           | Containerization             |
| Docker Compose   | Orkestrasi container         |
| MiniStack        | Simulasi layanan cloud lokal |
| Midtrans Sandbox | Payment Gateway              |
| Tailwind CSS     | Frontend Styling             |
| PHP 8.x          | Bahasa pemrograman utama     |

---

## Arsitektur Sistem

```text
User
  │
  ▼
Laravel Web Application
  │
  ├── MySQL Database
  │
  ├── MiniStack Object Storage
  │
  └── Midtrans Sandbox
```

---

## Persyaratan Sistem

Pastikan perangkat telah terpasang:

- Docker Desktop
- Docker Compose
- PHP >= 8.2
- Composer
- Node.js dan NPM
- Git

---

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/ProjekAwan.git
cd ProjekAwan
```

### 2. Salin File Environment

```bash
cp .env.example .env
```

atau pada Windows:

```bash
copy .env.example .env
```

### 3. Install Dependency PHP

```bash
composer install
```

### 4. Install Dependency Frontend

```bash
npm install
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Jalankan Container

```bash
docker compose up -d
```

### 7. Jalankan Migrasi Database

```bash
php artisan migrate --seed
```

### 8. Build Asset Frontend

```bash
npm run build
```

atau

```bash
npm run dev
```

---

## Konfigurasi MiniStack

Contoh konfigurasi pada `docker-compose.yml`:

```yaml
ministack:
    image: ministackorg/ministack:full
    ports:
        - "4566:4566"
    environment:
        - MINISTACK_REGION=us-east-1
        - PERSIST_STATE=1
        - S3_PERSIST=1
```

---

## Konfigurasi Midtrans

Tambahkan konfigurasi berikut pada file `.env`:

```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

Gunakan kredensial dari Midtrans Sandbox.

---

## Struktur Fitur

- Dashboard
- Storage Management
- Resource Management
- Subscription Management
- Payment Gateway
- User Authentication
- Admin Panel

---

## Pengujian

Pengujian dilakukan menggunakan metode pengujian fungsional terhadap fitur utama sistem, meliputi:

- Login dan Registrasi
- Pengelolaan Bucket
- Upload File
- Pengelolaan Resource
- Upgrade Subscription
- Pembayaran Midtrans

Seluruh fitur utama berhasil berjalan sesuai kebutuhan sistem.

---

## Tim Pengembang

| Nama                       | NIM           |
| -------------------------- | ------------- |
| Akhmad Chaidar Ananda      | 2310817110015 |
| Ghani Mudzakir             | 2310817110011 |
| Jovan Gilbert Natamasindah | 2310817310002 |
| Muhammad Rizky             | 2310817310011 |
| Noviana Nur Aisyah         | 2310817120005 |
| Randy Febrian              | 2310817110013 |

---

## Lisensi

Proyek ini dikembangkan untuk keperluan akademik pada Mata Kuliah Komputasi Awan, Program Studi Teknologi Informasi, Universitas Lambung Mangkurat.
