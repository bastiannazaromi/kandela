<section class="content">
    <div class="row">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3> <?= $d_admin; ?></h3>

                    <p>Total Admin</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box">
                <div class="inner">
                    <h3> <?= $siswa; ?></h3>

                    <p>Total Siswa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3> <?= $buku; ?></h3>

                    <p>Total Buku</p>
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