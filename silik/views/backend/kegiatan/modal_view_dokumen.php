<div class="modal fade" id="modal-view-dakung" tabindex="-1" role="dialog" aria-labelledby="modal-button-row" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title"><?php print $nama; ?></h5>
			</div>
			<?php
				if ($type == "doc" || $type == "docx") {
					$path = "https://docs.google.com/gview?url=".base_url("/assets/data_dukung/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/".$nama_file)."&embedded=true";
				}
				else {
					$path = base_url("/assets/data_dukung/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/".$nama_file)."?v=".rand();
				}
				
			?>
			<div class="modal-body">
				<iframe style="border: 1px solid #ddd; width: 100%; min-height: 400px;" src="<?php print $path; ?>"></iframe>
			</div>
			<div class="modal-footer">
				<a href="<?php print base_url("assets/data_dukung/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/".$nama_file); ?>" download target="_blank" class="btn btn-primary">Download</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>