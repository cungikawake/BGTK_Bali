<div class="card-block card-block-congrats">
	<div class="modal-body">
		<div class="form-group m-b-10">
			<div class="congrats-logo"><img src="<?php print base_url("assets/images/hore.png"); ?>" /></div>
			<div class="congrats">SELAMAT!</div>
			<div class="congrats-desc" style="margin-bottom:20px;">Anda Telah Berhasil Mengisi Daftar Hadir.</div>
			<div class="congrats-desc">Kegiatan <?php print $kegiatan["nama"]; ?></div>
			<div class="congrats-desc">tanggal <?php print date("d M Y", strtotime($tgl_daftar_hadir)); ?></div>
		</div>
	</div>
</div>