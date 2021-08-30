<section class="content">

	<div class="row">
		<div class="col-xl-12 col-md-12 mb-4">
			<div class="card">
				<div class="card-body">
					<div class="col-lg-12 col-12 text-right">
						<button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Download Format" onclick="window.location='<?= base_url('assets/excel/Format_siswa.xlsx'); ?>'">
							<i class="fa fa-download"></i>
						</button>
						<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-import" title="Import Matakuliah">
							<i class="fa fa-upload"></i>
						</button>
						<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Siswa</button>
					</div>
					<br>
					<br>
					<div class="table-responsive">
						<?php echo form_open('admin/list_siswa/multiple_delete'); ?>
						<table id="example" class="table table-bordered table-hover">
							<thead class="bg-light text-dark">
								<tr>
									<th>#</th>
									<th>Nama</th>
									<th>NISN</th>
									<th>Kelas</th>
									<th>JK</th>
									<th>Status</th>
									<th>Password</th>
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
										<td><?= $hasil->nama; ?></td>
										<td><?= $hasil->nisn; ?></td>
										<td><?= $hasil->kelas; ?></td>
										<td>
											<span class="badge <?= ($hasil->jk == 'L') ? 'badge-info' : 'badge-warning'; ?>"><?= ($hasil->jk == 'L') ? 'Laki - laki' : 'Perempuan'; ?></span>
										</td>
										<td>
											<span class="badge <?= ($hasil->status == 1) ? 'badge-success' : 'badge-dark'; ?>"><?= ($hasil->status == 1) ? 'Aktif' : 'Lulus'; ?></span>
										</td>
										<td><a href="<?= base_url() ?>admin/list_siswa/resetPassword/<?= enkrip($hasil->id) . '/' . enkrip($hasil->nisn); ?>" class="badge badge-success delete-people"><i class="fa fa-edit"></i>
												Reset</a>
										</td>
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
									<th colspan="8" class="text-center">-</th>
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
		<form action="<?= base_url('admin/list_siswa/tambah'); ?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="form-group">
						<label for="nama">Nama</label>
						<input type="text" class="form-control" name="nama" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="nisn">NISN</label>
						<input type="text" class="form-control" name="nisn" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="Kelas">Kelas</label>
						<select name="kelas" class="form-control">
							<option value="">-- Pilih Kelas --</option>
							<?php for ($i = 1; $i <= 6; $i++) : ?>
								<option value="<?= $i; ?>"><?= $i; ?></option>
							<?php endfor; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="jk">Jenis Kelamin</label>
						<select name="jk" class="form-control">
							<option value="">-- Pilih Jenis Kelamin --</option>
							<option value="L">Laki - laki</option>
							<option value="P">Perempuan</option>
						</select>
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
		<form action="<?= base_url('admin/list_siswa/edit'); ?>" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Siswa</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id" name="id">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="form-group">
						<label for="nama">Nama</label>
						<input type="text" class="form-control" id="nama" name="nama" required autocomplete="off">
					</div>
					<div class="form-group">
						<label for="nisn">NISN</label>
						<input type="text" class="form-control" id="nisn" name="nisn" required autocomplete="off">
					</div>

					<div class="form-group">
						<label for="Kelas">Kelas</label>
						<select name="kelas" class="form-control" id="kelas">
							<option value="">-- Pilih Kelas --</option>
							<?php for ($i = 1; $i <= 6; $i++) : ?>
								<option value="<?= $i; ?>"><?= $i; ?></option>
							<?php endfor; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="jk">Jenis Kelamin</label>
						<select name="jk" class="form-control" id="jk">
							<option value="">-- Pilih Jenis Kelamin --</option>
							<option value="L">Laki - laki</option>
							<option value="P">Perempuan</option>
						</select>
					</div>
					<div class="form-group">
						<label for="status">Status</label>
						<select name="status" class="form-control" id="status">
							<option value="">-- Pilih Status --</option>
							<option value="1">Aktif</option>
							<option value="2">Lulus</option>
						</select>
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
		<form action="<?= base_url('admin/list_siswa/import'); ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Import Siswa</h5>
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
		$('#l-siswa').addClass('bg-light');

		let tombol_edit = $('.btn-edit');
		$(tombol_edit).each(function(i) {
			$(tombol_edit[i]).click(function() {
				let id = $(this).data('id');
				$.ajax({
					url: '<?php echo base_url('admin/list_siswa/getOne/') ?>' + id,
					type: 'GET',
					dataType: 'JSON',
					success: function(respon) {
						$('#id').val(id);
						$('#nama').val(respon.nama);
						$('#nisn').val(respon.nisn);
						$('#kelas').val(respon.kelas);
						$('#jk').val(respon.jk);
						$('#status').val(respon.status);
					}
				});
			});
		});
	});
</script>