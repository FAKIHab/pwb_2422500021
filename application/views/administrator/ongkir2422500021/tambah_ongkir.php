<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><h1>Tambah Ongkir</h1></div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card"><div class="card-body">
                <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                <form method="post" action="<?= base_url('admin/ongkir2422500021/tambah') ?>">
                    <div class="form-group">
                        <label for="nama_ekspedisi021">Nama Ekspedisi</label>
                        <input class="form-control" type="text" name="nama_ekspedisi021" id="nama_ekspedisi021" maxlength="11" value="<?= html_escape(set_value('nama_ekspedisi021')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_layanan021">Jenis Layanan</label>
                        <input class="form-control" type="text" name="jenis_layanan021" id="jenis_layanan021" maxlength="30" value="<?= html_escape(set_value('jenis_layanan021')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tarif_per_kg021">Tarif per Kg</label>
                        <input class="form-control" type="text" name="tarif_per_kg021" id="tarif_per_kg021" maxlength="10" value="<?= html_escape(set_value('tarif_per_kg021')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status021">Status</label>
                        <input class="form-control" type="text" name="status021" id="status021" maxlength="15" value="<?= html_escape(set_value('status021')) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="<?= base_url('admin/ongkir2422500021') ?>" class="btn btn-danger">Kembali</a>
                </form>
            </div></div>
        </div>
    </section>
</div>
