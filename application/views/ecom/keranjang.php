<style>
.product-img {
    width: 60px;
    height: auto;
}

.qty-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.qty-btn {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 0;
}
</style>

<div class="container mb-3 mt-4">
    <h2 class="mb-4">Keranjang Belanja</h2>
    <?php if ($this->session->flashdata('message')): ?>
    <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col">Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Produk 1 -->
                <?php foreach ($produk as $item): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('/uploads/produk/') . $item['gambar'][0]['nama_gambar'] ?>" alt="Produk A" class="me-3 product-img">
                            <div>
                                <strong><?= $item['nama'] ?></strong><br>
                            </div>
                        </div>
                    </td>
                    <td>Rp <?= number_format($item['harga']) ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <!-- Tombol MINUS -->
                            <form action="<?= base_url('keranjang/ubah') ?>" method="post" class="d-inline">
                                <input type="hidden" name="id_keranjang_produk" value="<?= $item['id_keranjang_produk'] ?>">
                                <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">
                                <input type="hidden" name="jumlah" value="<?= $item['jumlah'] - 1 ?>">
                                <button type="submit" class="btn btn-outline-secondary btn-sm qty-btn" <?= ($item['jumlah'] <= 1 ? 'disabled' : '') ?>>-</button>
                            </form>

                            <!-- Tampilkan jumlah sekarang -->
                            <span><?= $item['jumlah'] ?></span>

                            <!-- Tombol PLUS -->
                            <form action="<?= base_url('keranjang/ubah') ?>" method="post" class="d-inline">
                                <input type="hidden" name="id_keranjang_produk" value="<?= $item['id_keranjang_produk'] ?>">
                                <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">
                                <input type="hidden" name="jumlah" value="<?= $item['jumlah'] + 1 ?>">
                                <button type="submit" class="btn btn-outline-secondary btn-sm qty-btn" <?= ($item['jumlah'] >= $item['stok'] ? 'disabled' : '') ?>>+</button>
                            </form>
                        </div>
                    </td>
                    <td>Rp <?= number_format($item['harga'] * $item['jumlah']) ?></td>
                    <td>
                        <form action="<?= base_url('keranjang/hapus') ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">
                            <input type="hidden" name="id_keranjang_produk" value="<?= $item['id_keranjang_produk'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>

                <!-- Total Keseluruhan -->
                <tr class="table-light">
                    <td colspan="3" class="text-end"><strong>Total Keseluruhan:</strong></td>
                    <td><strong>Rp <?= number_format($total) ?></strong></td>
                    <td>
                        <form action="<?= base_url('pesanan/tambah') ?>" method="post" onsubmit="return confirm('Yakin ingin checkout?');">
                            <input type="hidden" name="keranjang_id" value="<?= $keranjang_id ?>">
                            <button type="submit" class="btn btn-success btn-sm">Checkout</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>