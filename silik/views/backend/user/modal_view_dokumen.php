<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title"><?php print $nama; ?></h5>
		</div>
		<div class="modal-body">
			<iframe style="border: 1px solid #ddd; width: 100%; min-height: 400px;" src="<?php print base_url("/assets/user_dokumen/".$user_id."/".$filename); ?>"></iframe>
		</div>
		<div class="modal-footer">
			<a href="<?php print base_url("/admin/user/download_dokumen/".$id); ?>" class="btn btn-primary">Download</a>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
		</div>
	</div>
</div>