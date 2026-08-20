<!-- [ breadcrumb ] start -->
<div class="page-header">
	<div class="page-block">
		<div class="row align-items-center">
			<div class="col-md-12">
				<div class="page-header-title">
					<h4 class=""><?php print $kegiatan["nama"]; ?></h5>
					<p class="m-b-20">
						<?php
							if (!empty($kegiatan["program"])) {
						?>
							<i class="fas fa-archive"></i>&nbsp; <?php print $kegiatan["program"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php
							}
						?>
						<i class="fas fa-calendar-alt"></i>&nbsp; 
						<?php
							if (!empty($kegiatan["detail_tgl_kegiatan"])) {
								print $this->utility->formatDetailDate($kegiatan["detail_tgl_kegiatan"]);
							}
							else {
								print $this->utility->formatRangeDate($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]);
							}
						?>
						<?php
							if ($kegiatan["tipe_kegiatan"] == "Daring") {
						?>	
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-video"></i>&nbsp; Daring
						<?php	
							}
							else {
						?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-map-marker-alt"></i>&nbsp; <?php print $kegiatan["tempat_kegiatan"]; ?>
						<?php
							}
						?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ breadcrumb ] end -->