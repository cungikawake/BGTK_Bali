<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Komponen Kegiatan</h5>
		</div>
		
		<?php
			$disable = 'disabled="disabled"';
		
			if (isset($id) && !empty($id)) {
				$disable = '';
			}
		?>
		
		<form action="/admin/komponen_kegiatan/save" method="post" class="form-submit" autocomplete="off">
			<input type="hidden" name="id" class="form-control" value="<?php print isset($id) ? $id : ""; ?>" />
			<div class="modal-body">
				<div class="form-group">
					<label>Nama Komponen</label>
					<input type="text" name="name" placeholder="Peserta" class="form-control" value="<?php print isset($name) ? $name : ""; ?>" /> 
				</div>  
				<div class="form-group">
					<label>Status</label>
					<select name="status" class="form-control select2">
						<?php
							$options = array("1","0");
							$valSelected = isset($tipe_kegiatan) ? $tipe_kegiatan : "";

							foreach ($options as $tipe) {
								$selected = '';

								if ($valSelected == $tipe) {
									$selected = 'selected="selected"';
								}
								$title = 'Aktif';
								if($tipe == 0){
									$title = 'Tidak Aktif';
								}
								print '<option value="'.$tipe.'" '.$selected.'>'.$title.'</option>';
							}
						?>
					</select>
				</div>
				<?php if (!isset($id) || empty($id)) { ?>
				<div class="form-group">
					<label>Short Kode</label>
					<input type="text" name="short_code" class="form-control" placeholder="PS" value="<?php print isset($short_code) ? $short_code : ""; ?>" /> 
				</div>
				<?php } ?>
				<div class="form-group">
					<label>Prioritas</label>
					<input type="text" name="order" placeholder="1" class="form-control" value="<?php print isset($order) ? $order : ""; ?>" /> 
				</div> 
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>
<script>
	 
</script>