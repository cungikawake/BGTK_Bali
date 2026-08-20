<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">QR Code</h5>
		</div>
		<div class="modal-body">
			<div class="text-center"><img src="<?php print $qr_code["image"]; ?>" title="QR Code" /></div>
			<div class="text-center">
				<div style="width:98%;display:inline-block;word-wrap: break-word;" class="alert alert-info"><?php print $qr_code["url"]; ?></div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="<?php print base_url("/admin/tool/download_qr/".$id); ?>" class="btn btn-primary">Download</a>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
		</div>
	</div>
</div>