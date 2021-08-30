<section class="content">

	<div class="row">
		<div class="col-xl-12 col-md-12 mb-4">
			<div class="card">
				<div class="card-body">
					<div class="col-lg-12 col-12 text-right">
						<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Download Format" onclick="window.location='<?= base_url('assets/excel/Format_buku.xlsx'); ?>'">
							<i class="fa fa-download"></i>
						</button>
						<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-import" title="Import Matakuliah">
							<i class="fa fa-upload"></i>
						</button>
						<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Buku</button>
					</div>
					<br>
					<br>
					<div class="table-responsive">
						<?php echo form_open('admin/list_buku/multiple_delete'); ?>
						<table id="example" class="table table-bordered table-hover">
							<thead class="bg-light text-dark">
								<tr>
									<th>#</th>
									<th>Penerbit</th>
									<th>Judul Buku</th>
									<th>Pengarang</th>
									<th>Tahun terbit</th>
									<th>Jumlah</th>
									<th>Stok</th>
									<th>Dipinjam</th>
									<th>Keadaan</th>
									<th>Action</th>
									<th>
										<center><input type="checkbox" id="check-all"></center>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($siswa as $hasil) : ?>
									<tr>
										<th><?= $i++ ?></th>
										<td><?= $hasil->penerbit; ?></td>
										<td><?= $hasil->judul; ?></td>
										<td><?= $hasil->pengarang; ?></td>
										<td><?= $hasil->tahun; ?></td>
										<td><?= $hasil->jumlah; ?></td>
										<td><?= $hasil->stok; ?></td>
										<td><?= ($hasil->jumlah - $hasil->stok); ?></td>
										<td><?= $hasil->keadaan; ?></td>
										<td>
											<a href="#" class="badge badge-warning btn-edit" data-toggle="modal" data-target="#modalEdit" data-id="<?= enkrip($hasil->id); ?>"><i class="fa fa-edit"></i>
												Edit</a>
										</td>
										<td>
											<center>
												<input type="checkbox" class="check-item" name="id[]" value="<?= enkrip($hasil->id) ?>">
											</center>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
							<tfoot>
								<tr class="table table-warning">
									<th colspan="10" class="text-center">-</th>
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
	<div class="modal-dialog" role="document">
		<form action="<?= base_url('admin/list_buku/tambah'); ?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="form-group">
						<label for="judul">Judul</label>
						<textarea name="judul" class="form-control" cols="30" rows="5"></textarea>
					</div>
					<div class="form-group">
						<label for="penerbit">Penerbit</label>
						<input type="text" class="form-control" name="penerbit" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="pengarang">Pengarang</label>
						<input type="text" class="form-control" name="pengarang" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="tahun">tahun</label>
						<input type="number" class="form-control" name="tahun" min="1900" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="jumlah">Jumlah</label>
						<input type="number" class="form-control" name="jumlah" min="1" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="keadaan">Keadaan</label>
						<input type="text" class="form-control" name="keadaan" required autocomplete="off">
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

<!-- Modal Edit-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="<?= base_url('admin/list_buku/edit'); ?>" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Buku</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id" name="id">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="form-group">
						<label for="judul">Judul</label>
						<textarea name="judul" class="form-control" cols="30" rows="5" id="judul"></textarea>
					</div>
					<div class="form-group">
						<label for="penerbit">Penerbit</label>
						<input type="text" class="form-control" name="penerbit" id="penerbit" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="pengarang">Pengarang</label>
						<input type="text" class="form-control" name="pengarang" id="pengarang" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="tahun">tahun</label>
						<input type="number" class="form-control" name="tahun" id="tahun" min="1900" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="jumlah">Jumlah</label>
						<input type="number" class="form-control" name="jumlah" id="jumlah" min="1" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="keadaan">Keadaan</label>
						<input type="text" class="form-control" name="keadaan" id="keadaan" required autocomplete="off">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" name="edit" class="btn btn-warning">Edit</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="<?= base_url('admin/list_buku/import'); ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Import Buku</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="nama">File Upload</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="image" data-toggle="custom-file-input" accept=".xlsx" name="file_excel">
							<label class="custom-file-label" for="one-profile-edit-avatar">Pilih file</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" name="edit" class="btn btn-warning">Import</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End Modal Import -->

<script src="<?= base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>

<script>
	$(document).ready(function() {
		$('#master').addClass('menu-open');
		$('#l-buku').addClass('bg-light');

		let tombol_edit = $('.btn-edit');
		$(tombol_edit).each(function(i) {
			$(tombol_edit[i]).click(function() {
				let id = $(this).data('id');
				$.ajax({
					url: '<?php echo base_url('admin/list_buku/getOne/') ?>' + id,
					type: 'GET',
					dataType: 'JSON',
					success: function(respon) {
						$('#id').val(id);
						$('#judul').text(respon.judul);
						$('#penerbit').val(respon.penerbit);
						$('#pengarang').val(respon.pengarang);
						$('#tahun').val(respon.tahun);
						$('#jumlah').val(respon.jumlah);
						$('#keadaan').val(respon.keadaan);
					}
				});
			});
		});
	});
</script>