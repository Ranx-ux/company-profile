<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Profile
        $this->db->table('profile')->insert([
            'nama_perusahaan' => 'Jaya Makmur',
            'logo'            => null,
            'deskripsi'       => 'PT Jaya Makmur adalah perusahaan terkemuka yang berkomitmen memberikan produk dan layanan berkualitas tinggi untuk kepuasan pelanggan dan kemajuan bisnis.',
            'visi'            => 'Menjadi perusahaan terdepan dan terpercaya di tingkat nasional maupun internasional pada tahun 2030.',
            'misi'            => "1. Memberikan produk dan layanan berkualitas tinggi\n2. Mengembangkan inovasi berkelanjutan\n3. Membangun kemitraan strategis yang saling menguntungkan\n4. Berkontribusi pada pertumbuhan ekonomi nasional",
            'alamat'          => 'Jl. Jaya Makmur No. 1, Jakarta Selatan, Indonesia 12345',
            'email'           => 'info@jayamakmur.co.id',
            'telepon'         => '(021) 1234-5678',
            'website'         => 'www.jayamakmur.co.id',
        ]);

        // Seed Services
        $services = [
            ['nama' => 'Konsultasi Bisnis', 'deskripsi' => 'Layanan konsultasi bisnis profesional untuk membantu perusahaan Anda berkembang dan mencapai target.', 'icon' => 'fas fa-briefcase', 'kategori' => 'Konsultasi', 'status' => 'aktif'],
            ['nama' => 'Pengembangan IT', 'deskripsi' => 'Solusi teknologi informasi terpadu mulai dari pengembangan sistem hingga infrastruktur digital.', 'icon' => 'fas fa-laptop-code', 'kategori' => 'Teknologi', 'status' => 'aktif'],
            ['nama' => 'Manajemen Proyek', 'deskripsi' => 'Pengelolaan proyek secara profesional dengan metodologi terkini untuk hasil yang optimal.', 'icon' => 'fas fa-project-diagram', 'kategori' => 'Manajemen', 'status' => 'aktif'],
            ['nama' => 'Pemasaran Digital', 'deskripsi' => 'Strategi pemasaran digital komprehensif untuk meningkatkan brand awareness dan penjualan.', 'icon' => 'fas fa-chart-line', 'kategori' => 'Pemasaran', 'status' => 'aktif'],
            ['nama' => 'Solusi Keuangan', 'deskripsi' => 'Layanan perencanaan dan pengelolaan keuangan bisnis yang akurat dan terpercaya.', 'icon' => 'fas fa-coins', 'kategori' => 'Keuangan', 'status' => 'aktif'],
            ['nama' => 'Pelatihan SDM', 'deskripsi' => 'Program pelatihan dan pengembangan sumber daya manusia untuk meningkatkan kompetensi tim Anda.', 'icon' => 'fas fa-users', 'kategori' => 'SDM', 'status' => 'aktif'],
        ];

        foreach ($services as $service) {
            $service['created_at'] = date('Y-m-d H:i:s');
            $service['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('services')->insert($service);
        }

        // Seed Gallery
        $galleries = [
            ['judul' => 'Peresmian Kantor Baru', 'deskripsi' => 'Peresmian kantor pusat Jaya Makmur yang baru', 'kategori' => 'Event', 'status' => 'aktif'],
            ['judul' => 'Workshop Tim 2024', 'deskripsi' => 'Workshop pengembangan tim tahunan', 'kategori' => 'Kegiatan', 'status' => 'aktif'],
            ['judul' => 'Penghargaan Nasional', 'deskripsi' => 'Penerimaan penghargaan perusahaan terbaik', 'kategori' => 'Prestasi', 'status' => 'aktif'],
            ['judul' => 'Fasilitas Kantor', 'deskripsi' => 'Fasilitas kantor modern dan nyaman', 'kategori' => 'Fasilitas', 'status' => 'aktif'],
        ];

        foreach ($galleries as $gallery) {
            $gallery['created_at'] = date('Y-m-d H:i:s');
            $gallery['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('gallery')->insert($gallery);
        }

        // Seed Admin User
        $this->db->table('users')->insert([
            'nama'       => 'Super Admin',
            'email'      => 'admin@jayamakmur.co.id',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'superadmin',
            'status'     => 'aktif',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
