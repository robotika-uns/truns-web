### [ **Pendahuluan** ]
Semua kontributor project `truns-web` yang sudah disetujui saat tahap **Pull Request** akan secara otomatis muncul pada [**Credits**](https://github.com/robotika-uns/truns-web/wiki/Credits) denan role sesuai dengan tugas yang sudah dikerjakan.

Usahakan menggunakan editor **Visual Studio Code** supaya workflow bisa lebih mudah. Tapi jika sudah terbiasa dengan editor lain boleh menggunakan editor lain.

Jika menggunakan editor **Visual Studio Code**, install extension di bawah ini untuk memudahkan alur kerja :

Backend:
  - **PHP Intelephense** by Ben Mewburn.

Frontend:
  - **Vetur** by Pine Wu.
  - **Tailwind CSS IntelliSense** by Tailwind Labs.
  - **PostCSS Language Support** by csstools.

Optional:
  - **Git Graph** by mhutchie.
  - **GutHub Pull Requests** by GitHub.

<br>

### [ **Prasyarat** ]
Backend:
- [**PHP**](https://www.php.net/releases/index.php) (7.0.11)
- [**MySQL**](https://downloads.mysql.com/archives/community/) (5.5.56)
- [**Composer**](https://getcomposer.org/) (>=2.2.5)

Frontend:
- [**Node.js**](https://nodejs.org) (>=16.13.1)
- [**NPM**](https://www.npmjs.com) (>=8.1.2)

<br>

### [ **Instalasi** ]
1. Install semua prasyarat yang dibutuhkan.
1. Clone repositori ini ke komputer/laptop lokal.   
1. Masuk ke direktori _truns-web_ yang baru saja diclone.
    ```
    cd truns-web
    ```

3. Install dependensi.   
    ```
    # Backend:
    composer install

    # Frontend:
    npm install
    ```
    
4. Jalankan server lokal.
    ```
    # Backend
    php -S localhost:8000 -t public

    # Frontend
    npm run dev
    ```
    Setelah melakukan tahap diatas, server akan berjalan dan dapat diakses.
    <br>
    Untuk Backend, server berada pada http://localhost:8000.
    <br>
    Untuk Frontend, server berada pada http://localhost:3000.
    <br>
    <br>
    Untuk penjelasan mendetail tentang cara kerja **Nuxt.js**, lihat [dokumentasi](https://nuxtjs.org/docs/get-started/installation).
    <br>
    Untuk penjelasan mendetail tentang cara kerja **Lumen**, lihat [dokumentasi](https://lumen.laravel.com/docs/5.5/installation).

<br>

### [ **Alur Kontribusi** ]
1. **Fork** repositori ini ke akun GitHub kamu.
1. **Clone** repositori yang sudah di fork ke komputer/laptop lokal.
1. Lakukan penambahan / perubahan kode pada repositori lokal yang sudah diclone.
1. **Commit** perubahan yang terjadi. Jangan lupa sertakan pesan perubahan.
2. **Push** perubahan pada lokal ke remote repositori fork.
3. **Pull** terlebih dahulu remote repositori fork kamu dari repositori remote [`robotika-uns/truns-web`](https://github.com/robotika-uns/truns-web) untuk update jika ada perubahan repositori terbaru.
4. Kemudian lakukan **Pull Request** dan sertakan pesan yang detil tentang **Pull Request** dan perubahan yang sudah kamu buat.
5. _Project Maintainer_ akan mengecek dan memastikan **Pull Request** yang kamu buat aman dan tidak terjadi konflik.
6. Jika dirasa sudah sesuai, **Pull Request** akan di setujui.