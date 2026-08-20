<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">MCM Transfer File</h5>
		</div>
		
        <form method="post" class="form-mcm-transfer">
        	<input name="id" class="mcm_spby_id" type="hidden" value="<?php print $id; ?>" />
            <div class="modal-body">
				<div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nama File</label>
							<input type="text" class="form-control" name="nama_file" maxlength="100" value="<?php print $nama_file; ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Remark (19 character)</label>
							<input type="text" class="form-control" name="remark" maxlength="19" value="<?php print $remark; ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
				<input type="hidden" name="download" value="excel" />
				<button type="submit" value="excel" class="btn btn-submit-mcm btn-info" style="margin-bottom: 0"><i class="fas fa-file-excel"></i> Download Excel</button>
				<button type="submit" value="csv" class="btn btn-submit-mcm btn-success"><i class="fas fas fa-file-code"></i> Download CSV</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
		</form>
    </div>
</div>