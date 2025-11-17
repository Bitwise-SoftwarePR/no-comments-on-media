# No Comments on Media

**Minimalan WordPress plugin koji automatski isključuje komentare na media attachments.**

[![WordPress Plugin Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/Bitwise-SoftwarePR/NoCommentsOnMedia)
[![WordPress Compatibility](https://img.shields.io/badge/wordpress-5.0%2B-brightgreen.svg)](https://wordpress.org/)
[![PHP Version](https://img.shields.io/badge/php-7.0%2B-purple.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-GPLv2-red.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

---

## 📋 Opis

**No Comments on Media** je ultra-lagani plugin koji automatski isključuje komentare na svim media attachment stranicama. Bez komplikacija, bez bloat-a - samo čist, minimalan kod.

### Zašto vam je potreban ovaj plugin?

Media attachment stranice (slike, videi, PDF-ovi) **retko** trebaju komentare. Ovaj plugin:

✅ **Poboljšava SEO** - Uklanja nepotrebne comment sekcije  
✅ **Povećava sigurnost** - Smanjuje spam i potencijalne bezbednosne propuste  
✅ **Čisti vaš sajt** - Profesionalniji izgled attachment stranica  
✅ **Štedi resurse** - Manje database queries, brže učitavanje  

---

## ✨ Funkcionalnosti

### 🎯 Core Features

- **Automatsko isključivanje komentara** - Komentari se više ne mogu dodavati na attachments
- **Isključuje trackbacks/pingbacks** - Potpuna zaštita od spam-a
- **Uklanja Comments sekciju** - Potpuno sakriva comment form i postojeće komentare
- **Theme-agnostic** - Radi sa **bilo kojom** WordPress temom
- **Simple ON/OFF toggle** - Jednostavna kontrola u Settings → Media
- **Auto-close na aktivaciji** - Pri aktivaciji zatvara komentare na svim postojećim attachmentima

### 🎁 Bonus Features

- **Opciono brisanje komentara** - Toggle za trajno brisanje postojećih komentara na attachments
- **WP-CLI podrška** - Profesionalne komande za developere i system admine
- **Status monitoring** - Prikaz trenutnog stanja komentara na media

---

## 🚀 Instalacija

### Automatska instalacija (WordPress.org)

1. Idite na **Plugins → Add New**
2. Pretražite **"No Comments on Media"**
3. Kliknite **"Install Now"** i zatim **"Activate"**
4. Gotovo! Plugin radi automatski

### Ručna instalacija

1. Preuzmite plugin fajlove
2. Otpremite folder u `/wp-content/plugins/`
3. Aktivirajte plugin kroz **Plugins** meni
4. Plugin automatski počinje da radi

---

## 📖 Korišćenje

Plugin radi automatski nakon aktivacije. Za kontrolu funkcionalnosti:

### Admin Panel

1. Idite na **Settings → Media**
2. Pronaćite sekciju **"Comments on Media"**
3. Konfigurisanje opcija:
   - ☑ **Disable comments on all media attachments** - Glavna funkcionalnost
   - ☑ **Delete existing comments on attachments** - ⚠️ Trajno briše komentare (opciono)
4. Sačuvajte promene

**Plugin je omogućen po defaultu.**

### WP-CLI Komande

Za developere i system administratore:

```bash
# Provera statusa
wp media-comments status

# Isključivanje komentara
wp media-comments disable

# Uključivanje komentara
wp media-comments enable

# Brisanje svih komentara na media (sa potvrdom)
wp media-comments cleanup

# Brisanje bez potvrde
wp media-comments cleanup --yes
```

**Primer korišćenja:**

```bash
$ wp media-comments status

=== No Comments on Media - Status ===

Plugin Status: ENABLED
Attachments with open comments: 0
Total comments on attachments: 45

Success: Comments are disabled on media attachments.
```

---

## � Tehnički detalji

### WordPress Hooks

Plugin koristi sledeće hookove:

- `comments_open` - Isključuje mogućnost otvaranja komentara
- `pings_open` - Isključuje pingbacks/trackbacks
- `comments_array` - Vraća prazan array komentara za attachments
- `init` - Uklanja comment support sa attachment post type-a
- `template_redirect` - Zamenjuje comments template sa praznim fajlom
- `admin_init` - Registruje settings

### Šta se dešava pri aktivaciji?

1. Postavlja default opciju na `enabled`
2. Zatvara komentare na **svim postojećim** attachmentima
3. Plugin odmah počinje da radi

### Brisanje komentara

Plugin **NE BRIŠE** postojeće komentare po defaultu. Samo ih sakriva. 

**Ako želite da trajno obrišete komentare:**

1. **Via Admin:** Settings → Media → čekirajte "Delete existing comments on attachments"
2. **Via WP-CLI:** `wp media-comments cleanup --yes`

⚠️ **Napomena:** Ova akcija je **trajna** i ne može se opozvati. Preporučujemo backup pre brisanja.

---

## 📦 Struktura fajlova

```
no-comments-on-media/
├── no-comments-on-media.php  # Glavni plugin fajl (~160 linija)
├── blank.php                  # Prazan template za comments
├── readme.txt                 # WordPress.org readme
└── README.md                  # Ova dokumentacija
```

---

## 🎨 Performance & SEO

- ⚡ **Ultra brz** - Minimalni overhead, samo neophodni hookovi
- 🪶 **Extremely lightweight** - ~160 linija koda
- 🔍 **SEO friendly** - Uklanja nepotrebne sekcije, brže učitavanje
- 🎯 **Zero bloat** - Nema nepotrebnih features
- 🌐 **Theme-agnostic** - Radi sa bilo kojom temom

---

## 📋 Zahtevi

- **WordPress:** 5.0 ili noviji
- **PHP:** 7.0 ili noviji
- **MySQL:** 5.6 ili noviji (standard za WordPress)

---

## ❓ FAQ

### Da li plugin briše postojeće komentare?

**Po defaultu NE.** Plugin samo sakriva komentare. Međutim, postoji opcija za trajno brisanje:
- Admin: Settings → Media → "Delete existing comments on attachments"
- CLI: `wp media-comments cleanup`

### Da li isključuje i trackbacks/pingbacks?

**Da!** Plugin isključuje i komentare i trackbacks/pingbacks na svim media attachmentima.

### Radi li sa mojom temom?

**Da!** Plugin je theme-agnostic i radi sa svim WordPress temama (custom themes, page builders, block themes).

### Da li utiče na komentare na posts/pages?

**Ne.** Plugin utiče **samo** na media attachments. Komentari na postovima i stranicama nisu zahvaćeni.

### Da li usporava sajt?

**Ne.** Plugin je ultra-lagani i koristi minimalne resurse. Nema negativnog uticaja na performanse.

### Kompatibilnost sa caching pluginima?

**Da.** Kompatibilan sa svim caching pluginima (WP Super Cache, W3 Total Cache, WP Rocket, itd).

### Mogu li koristiti plugin preko command line?

**Da!** Plugin ima punu WP-CLI podršku sa komandama: `disable`, `enable`, `cleanup`, `status`.

### Je li bezbedno brisati komentare?

Brisanje je **trajno** i ne može se opozvati. **Napravite backup** pre korišćenja ove opcije. Koristite samo ako ste sigurni da vam komentari ne trebaju.

---

## 📄 Licenca

GPL v2 ili novija - [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

---

## 👨‍💻 Autor

**Bitwise Software**  
GitHub: [@Bitwise-SoftwarePR](https://github.com/Bitwise-SoftwarePR)

---

## 🐛 Podrška

Za pomoć:

- **GitHub Issues:** [github.com/Bitwise-SoftwarePR/NoCommentsOnMedia/issues](https://github.com/Bitwise-SoftwarePR/NoCommentsOnMedia/issues)
- **WordPress.org Support:** [wordpress.org/support/plugin/no-comments-on-media/](https://wordpress.org/support/plugin/no-comments-on-media/)

---

## 🤝 Doprinos

Pull requests su dobrodošli! Za veće izmene, molimo prvo otvorite issue.

### Development

```bash
# Clone repository
git clone https://github.com/Bitwise-SoftwarePR/NoCommentsOnMedia.git

# Install u WordPress
cp -r NoCommentsOnMedia /path/to/wordpress/wp-content/plugins/
```

---

## 📝 Changelog

### 1.0.0 - 2025-11-18
- 🎉 Initial release
- ✅ Disable comments and pingbacks/trackbacks on media attachments
- ✅ Remove comment forms and sections
- ✅ Simple ON/OFF toggle
- ✅ Optional: Delete existing comments
- ✅ WP-CLI support (disable, enable, cleanup, status)
- ✅ Auto-close existing comments on activation

---

**Napravljen sa ❤️ za WordPress zajednicu**

---

**Napravljen sa ❤️ za WordPress zajednicu**
