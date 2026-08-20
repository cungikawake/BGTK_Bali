<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">QR CODE GENERATOR</h5>
		</div>
		
		<form action="/admin/tool/save_qr" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="id" class="form-control arsip-id" value="" />
			<div class="modal-body" style="background: #f4f7fa;">
				<div class="card mb-0">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Masukan URL</label>
									<textarea name="url" class="form-control" rows="5"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>