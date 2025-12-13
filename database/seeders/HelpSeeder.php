<?php

namespace Database\Seeders;

use App\Models\Help;
use Illuminate\Database\Seeder;

class HelpSeeder extends Seeder
{
    public function run()
    {
        $helps = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => "Selamat datang di MangaMongo!

MangaMongo adalah platform membaca manga online terbaik di Indonesia. Kami menyediakan ribuan judul manga dari berbagai genre yang dapat kamu baca secara gratis.

Visi Kami:
Menjadi platform manga terdepan yang menyediakan konten berkualitas tinggi dengan pengalaman membaca yang optimal.

Misi Kami:
- Menyediakan koleksi manga terlengkap dan terupdate
- Memberikan pengalaman membaca yang nyaman dan mudah
- Membangun komunitas pecinta manga di Indonesia
- Mendukung industri manga dengan promosi konten resmi

Kenapa Memilih MangaMongo?
- Update chapter terbaru setiap hari
- Interface yang user-friendly
- Gratis tanpa registrasi (opsional)
- Kualitas gambar HD
- Mobile responsive
- Komunitas aktif

Tim Kami:
MangaMongo dikelola oleh tim yang passionate dengan manga dan komitmen untuk memberikan layanan terbaik kepada para pembaca.

Hubungi kami jika ada pertanyaan atau saran!",
                'is_active' => true,
            ],
            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content' => "Hubungi Kami

Kami senang mendengar dari kamu! Jika kamu memiliki pertanyaan, saran, atau masalah teknis, jangan ragu untuk menghubungi kami.

Email:
support@mangamongo.com
admin@mangamongo.com

Jam Operasional:
Senin - Jumat: 09:00 - 18:00 WIB
Sabtu: 10:00 - 15:00 WIB
Minggu: Libur

Response Time:
Kami akan merespon email kamu dalam 1-2 hari kerja.

Alamat:
Jakarta, Indonesia

Untuk laporan bug atau masalah teknis, mohon sertakan:
- Browser yang digunakan
- Screenshot jika memungkinkan
- Deskripsi masalah yang detail

Follow kami di social media untuk update terbaru!",
                'is_active' => true,
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'content' => "Frequently Asked Questions (FAQ)

Q: Apakah MangaMongo gratis?
A: Ya, MangaMongo 100% gratis untuk semua pengguna. Kamu bisa membaca semua manga tanpa biaya apapun.

Q: Apakah saya harus registrasi?
A: Tidak wajib. Kamu bisa membaca manga tanpa registrasi. Namun, dengan registrasi kamu bisa menyimpan bookmark, history, dan memberikan rating.

Q: Seberapa sering manga diupdate?
A: Kami update manga setiap hari. Chapter baru akan muncul segera setelah tersedia.

Q: Kenapa gambar tidak muncul?
A: Coba refresh halaman atau clear cache browser kamu. Jika masih bermasalah, hubungi kami.

Q: Bagaimana cara request manga?
A: Kamu bisa mengirim request via email atau kontak kami. Kami akan berusaha menambahkan manga yang direquest.

Q: Apakah ada aplikasi mobile?
A: Saat ini kami belum memiliki aplikasi mobile, tapi website kami fully responsive dan bisa diakses dengan baik di smartphone.

Q: Bagaimana cara bookmark manga?
A: Klik tombol bookmark di halaman detail manga. Kamu harus login terlebih dahulu.

Q: Manga yang saya cari tidak ada, apa yang harus saya lakukan?
A: Silakan hubungi kami melalui halaman kontak dan berikan judul manga yang kamu cari.

Q: Apakah konten aman untuk anak-anak?
A: Kami menyediakan berbagai genre. Orang tua disarankan untuk mengawasi konten yang dibaca anak.

Punya pertanyaan lain? Hubungi kami!",
                'is_active' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => "Privacy Policy

Terakhir diupdate: " . now()->format('d F Y') . "

Privasi kamu penting bagi kami. Dokumen ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi kamu.

1. Informasi yang Kami Kumpulkan
- Email dan nama (jika registrasi)
- Data aktivitas membaca (history, bookmark)
- Data teknis (IP address, browser, device)
- Cookies untuk pengalaman yang lebih baik

2. Bagaimana Kami Menggunakan Informasi
- Menyediakan dan meningkatkan layanan
- Personalisasi konten
- Komunikasi dengan pengguna
- Analisis penggunaan website
- Keamanan dan fraud prevention

3. Cookies
Kami menggunakan cookies untuk:
- Menyimpan preferensi pengguna
- Analisis traffic website
- Meningkatkan user experience

4. Keamanan Data
Kami mengimplementasikan langkah keamanan standar industri untuk melindungi data kamu.

5. Berbagi Informasi
Kami TIDAK menjual atau membagikan data pribadi kamu ke pihak ketiga tanpa persetujuan.

6. Hak Pengguna
Kamu berhak:
- Mengakses data pribadi kamu
- Menghapus akun dan data
- Opt-out dari komunikasi marketing

7. Perubahan Privacy Policy
Kami dapat mengupdate kebijakan ini. Perubahan akan dinotifikasi di website.

8. Kontak
Untuk pertanyaan tentang privacy policy, hubungi: privacy@mangamongo.com",
                'is_active' => true,
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => "Terms of Service

Terakhir diupdate: " . now()->format('d F Y') . "

Dengan menggunakan MangaMongo, kamu setuju dengan syarat dan ketentuan berikut.

1. Penggunaan Layanan
- Kamu harus berusia minimal 13 tahun
- Satu akun per orang
- Dilarang menggunakan bot atau automation
- Dilarang melakukan scraping konten

2. Konten
- Semua konten adalah properti dari pemilik hak cipta masing-masing
- Kami tidak meng-claim kepemilikan atas manga yang ditampilkan
- Konten disediakan untuk tujuan promosi dan edukasi

3. Kewajiban Pengguna
- Tidak melakukan spam atau abuse
- Tidak membagikan akun dengan orang lain
- Tidak meng-upload konten ilegal
- Tidak melakukan hacking atau kegiatan merusak

4. Hak Cipta
- Semua konten dilindungi hak cipta
- DMCA takedown requests akan diproses
- Hubungi kami untuk copyright issues

5. Disclaimer
- Layanan disediakan 'as is'
- Kami tidak bertanggung jawab atas kerugian dari penggunaan layanan
- Kami berhak menghentikan layanan kapan saja

6. Perubahan Layanan
Kami berhak:
- Memodifikasi atau menghentikan layanan
- Mengubah terms of service
- Menghapus konten yang melanggar

7. Penangguhan Akun
Kami dapat menangguhkan atau menghapus akun yang melanggar ToS.

8. Hukum yang Berlaku
Terms ini diatur oleh hukum Republik Indonesia.

9. Kontak
Untuk pertanyaan: legal@mangamongo.com

Dengan melanjutkan menggunakan MangaMongo, kamu menyetujui Terms of Service ini.",
                'is_active' => true,
            ],
        ];

        foreach ($helps as $help) {
            Help::create($help);
        }
    }
}