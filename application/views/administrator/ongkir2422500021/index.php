<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Starter Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
            <li class="breadcrumb-item active">Ongkir</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <a href="<?= base_url('admin/ongkir2422500021/tambah') ?>" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Tambah Ongkir</a>
          <?php if ($pesan = $this->session->flashdata('message')) : ?>
            <div class="alert <?= strpos($pesan, 'Berhasil') !== false ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
              <?= html_escape($pesan) ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Ekspedisi</th>
                  <th>Jenis Layanan</th>
                  <th>Tarif per Kg</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($list_ongkir)) : ?>
                  <?php $no = 1; foreach ($list_ongkir as $ongkir) : ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= html_escape($ongkir['nama_ekspedisi021'] ?? '') ?></td>
                      <td><?= html_escape($ongkir['jenis_layanan021'] ?? '') ?></td>
                      <td><?= html_escape($ongkir['tarif_per_kg021'] ?? '') ?></td>
                      <td><?= html_escape($ongkir['status021'] ?? '') ?></td>
                      <td class="text-nowrap">
                        <a href="<?= base_url('admin/ongkir2422500021/ubah/' . $ongkir['id_ongkir021']) ?>" class="badge bg-success">Ubah</a>
                        <a href="<?= base_url('admin/ongkir2422500021/hapus/' . $ongkir['id_ongkir021']) ?>" class="badge bg-danger" onclick="return confirm('Yakin ingin menghapus data ongkir ini?')">Hapus</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr><td colspan="6" class="text-center">Belum ada data ongkir.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
