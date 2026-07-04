<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProfileModel;

class Cart extends BaseController
{
    /**
     * Display cart page.
     */
    public function index()
    {
        $cartItems = session()->get('cart') ?? [];

        $data = [
            'title'   => 'Keranjang Belanja',
            'profile' => (new ProfileModel())->getProfile(),
            'items'   => $cartItems,
            'total'   => $this->calculateTotal($cartItems),
        ];

        return view('frontend/cart/index', $data);
    }

    /**
     * Add product to cart (AJAX or form POST).
     */
    public function add()
    {
        $productId = (int) $this->request->getPost('product_id');
        $qty       = (int) ($this->request->getPost('qty') ?? 1);

        $productModel = new ProductModel();
        $product = $productModel->withCategory()->find($productId);

        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ]);
        }

        if ($product['stock'] < $qty) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Stok tidak mencukupi.',
            ]);
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $qty;
        } else {
            $cart[$productId] = [
                'product_id' => $product['id'],
                'name'       => $product['name'],
                'price'      => $product['price'],
                'thumbnail'  => $product['thumbnail'],
                'qty'        => $qty,
                'slug'       => $product['slug'],
            ];
        }

        session()->set('cart', $cart);

        $count = $this->getCartCount($cart);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success'   => true,
                'message'   => 'Produk berhasil ditambahkan ke keranjang.',
                'count'     => $count,
            ]);
        }

        return redirect()->to(base_url('cart'))->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update cart item quantity (AJAX or form POST).
     */
    public function update()
    {
        $productId = (int) $this->request->getPost('product_id');
        $qty       = (int) $this->request->getPost('qty');

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            if ($qty <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['qty'] = $qty;
            }
            session()->set('cart', $cart);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'total'   => $this->calculateTotal($cart),
                'count'   => $this->getCartCount($cart),
            ]);
        }

        return redirect()->to(base_url('cart'));
    }

    /**
     * Remove item from cart.
     */
    public function remove(int $productId)
    {
        $cart = session()->get('cart') ?? [];
        unset($cart[$productId]);
        session()->set('cart', $cart);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'total'   => $this->calculateTotal($cart),
                'count'   => $this->getCartCount($cart),
            ]);
        }

        return redirect()->to(base_url('cart'))->with('success', 'Item dihapus dari keranjang.');
    }

    /**
     * Get cart item count (AJAX).
     */
    public function count()
    {
        $cart = session()->get('cart') ?? [];
        return $this->response->setJSON([
            'count' => $this->getCartCount($cart),
        ]);
    }

    /**
     * Calculate total price.
     */
    protected function calculateTotal(array $cart): float
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['price'] * $item['qty']);
        }
        return $total;
    }

    /**
     * Get total item count.
     */
    protected function getCartCount(array $cart): int
    {
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['qty'];
        }
        return $count;
    }
}
