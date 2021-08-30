<section class="content">

	<div class="row">
		<div class="col-xl-12 col-md-12 mb-4">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
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
									<th>Tanggal Kembali</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								foreach ($kembali as $hasil) : ?>
									<tr>
										<th><?= $i++ ?></th>
										<td><?= $hasil->nama; ?></td>
										<td><?= $hasil->kelas; ?></td>
										<td><?= $hasil->judul; ?></td>
										<td><?= $hasil->penerbit; ?></td>
										<td><?= $hasil->jumlah; ?></td>
										<td><?= date('d F Y - H:i:s', strtotime($hasil->tanggal_pinjam)); ?></td>
										<td><?= date('d F Y - H:i:s', strtotime($hasil->tanggal_kembali)); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>

<script src="<?= base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>

<script>
	$(document).ready(function() {
		$('#riwayat').addClass('menu-open');
		$('#r-pengembalian').addClass('bg-light');
	});
</script>