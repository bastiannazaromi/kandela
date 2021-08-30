<section class="content">

	<div class="row">
		<div class="col-xl-12 col-md-12 mb-4">
			<div class="card">
				<div class="card-body">
					<div class="col-lg-12 col-12 text-right">
						<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Peminjaman</button>
					</div>
					<br>
					<br>
					<div class="table-responsive">
						<?php echo form_open('admin/peminjaman/multiple_delete'); ?>
						<table id="examples" class="table table-bordered table-hover">
							<thead class="bg-light text-dark">
								<tr>
									<th>#</th>
									<th>Nama</th>
									<th>Kelas</th>
									<th>Judul Buku</th>
									<th>Penerbit</th>
									<th>Jumlah</th>
									<th>Tanggal Pinjam</th>
									<th>Status</th>
									<th>Action</th>
									<th>
										<center><input type="checkbox" id="check-all"></center>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($pinjam as $hasil) : ?>
									<tr>
										<th><?= $i++ ?></th>
										<td><?= $hasil->nama; ?></td>
										<td><?= $hasil->kelas; ?></td>
										<td><?= $hasil->judul; ?></td>
										<td><?= $hasil->penerbit; ?></td>
										<td><?= $hasil->jumlah; ?></td>
										<td><?= date('d F Y - H:i:s', strtotime($hasil->tanggal_pinjam)); ?></td>
										<td>
											<span class="badge <?= ($hasil->status == 1) ? 'badge-warning' : 'badge-success'; ?>"><?= ($hasil->status == 1) ? 'Masih dipinjam' : 'sudah dikembalikan'; ?></span>
										</td>
										<td>
											<?php if ($hasil->status == 1) : ?>
												<a href="<?= base_url('admin/peminjaman/edit/' . enkrip($hasil->id)); ?>" class="badge badge-warning" data-toggle="tooltip" data-title="Kembalikan" onclick="return confirm('Apakah anda yakin buku ini akan dikembalikan ?')"><i class="fa fa-check"></i>
													Kembalikan</a>
											<?php else : ?>
												<a href="#" class="badge badge-success" data-toggle="tooltip" data-title="Sudah dikembalikan"><i class="fa fa-check"></i>
												</a>
											<?php endif; ?>
										</td>
										<td>
											<?php if ($hasil->status != 1) : ?>
												<center>
													<input type="checkbox" class="check-item" name="id[]" value="<?= enkrip($hasil->id) ?>">
												</center>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
							<tfoot>
								<tr class="table table-warning">
									<th colspan="9" class="text-center">-</th>
									<th>
										<center>
											<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data-data ini ?')"><i class="fa fa-trash "></i></button>
										</center>
									</th>
								</tr>
							</tfoot>
						</table>
						<?php echo form_close() ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>

<!-- Modal Add-->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<form action="<?= base_url('admin/peminjaman/tambah'); ?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Peminjaman</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="form-group">
						<label for="id_siswa">Nama Siswa</label>
						<select class="form-control basicAutoSelect" name="id_siswa" placeholder="Cari siswa..." data-url="<?= base_url('admin/peminjaman/getSiswa/?'); ?>" autocomplete="off"></select>
					</div>
					<div class="form-group">
						<label for="id_buku">Judul Buku</label>
						<select class="form-control basicAutoSelect" name="id_buku" placeholder="Cari judul buku..." data-url="<?= base_url('admin/peminjaman/getJudul/?'); ?>" autocomplete="off"></select>
					</div>
					<div class="form-group">
						<label for="jumlah">Jumlah</label>
						<input type="number" class="form-control" name="jumlah" min="1" required autocomplete="off">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" name="add" class="btn btn-primary">Tambah</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script src="<?= base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>

<script>
	$(document).ready(function() {
		$('#riwayat').addClass('menu-open');
		$('#r-peminjaman').addClass('bg-light');

		$('.basicAutoSelect').autoComplete({
			minLength: 2
		});

	});
</script>