<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EcommerceSeeder extends Seeder
{
    public function run()
    {
        // Seed Categories
        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Fashion', 'slug' => 'fashion', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        $categoryModel = new \App\Models\CategoryModel();
        foreach ($categories as $cat) {
            $categoryModel->insert($cat);
        }

        // Seed Products
        $products = [
            [
                'category_id' => 1,
                'name'        => 'Laptop Bisnis Pro X1',
                'slug'        => 'laptop-bisnis-pro-x1',
                'description' => 'Laptop bisnis berkualitas tinggi dengan prosesor terbaru, RAM 16GB, dan SSD 512GB. Cocok untuk kebutuhan profesional dan multitasking.',
                'price'       => 15000000,
                'stock'       => 25,
                'thumbnail'   => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 1,
                'name'        => 'Smartphone Flagship Z9',
                'slug'        => 'smartphone-flagship-z9',
                'description' => 'Smartphone flagship dengan kamera 108MP, layar AMOLED 6.7 inci, dan baterai 5000mAh. Performa terbaik di kelasnya.',
                'price'       => 8500000,
                'stock'       => 50,
                'thumbnail'   => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 2,
                'name'        => 'Kemeja Premium Katun',
                'slug'        => 'kemeja-premium-katun',
                'description' => 'Kemeja premium berbahan katun berkualitas tinggi. Nyaman dipakai seharian, tersedia dalam berbagai ukuran.',
                'price'       => 350000,
                'stock'       => 100,
                'thumbnail'   => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 3,
                'name'        => 'Paket Kopi Nusantara',
                'slug'        => 'paket-kopi-nusantara',
                'description' => 'Paket kopi premium dari berbagai daerah di Indonesia. Termasuk kopi Gayo, Toraja, dan Kintamani.',
                'price'       => 250000,
                'stock'       => 200,
                'thumbnail'   => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 4,
                'name'        => 'Vitamin C 1000mg',
                'slug'        => 'vitamin-c-1000mg',
                'description' => 'Suplemen vitamin C 1000mg untuk menjaga daya tahan tubuh. Isi 60 tablet, aman dikonsumsi harian.',
                'price'       => 150000,
                'stock'       => 300,
                'thumbnail'   => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'category_id' => 5,
                'name'        => 'Set Peralatan Dapur Modern',
                'slug'        => 'set-peralatan-dapur-modern',
                'description' => 'Set peralatan dapur lengkap dengan bahan stainless steel anti karat. Termasuk panci, wajan, dan spatula.',
                'price'       => 750000,
                'stock'       => 40,
                'thumbnail'   => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $productModel = new \App\Models\ProductModel();
        foreach ($products as $prod) {
            $productModel->insert($prod);
        }
    }
}
