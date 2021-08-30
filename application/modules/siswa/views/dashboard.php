<section class="content">
    <div class="row">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3> <?= $pinjam; ?></h3>

                    <p>Total Peminjaman</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dashboard').addClass('bg-light');
    });
</script>