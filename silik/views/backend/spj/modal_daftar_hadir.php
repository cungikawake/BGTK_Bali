<style type="text/css">
	.daftar-hadir-items {
		height: 220px;
		border: 1px solid #ddd;
		overflow-y: auto;
	}
	
	@media (min-width: 768px) {
		.modal-dialog {
			width:680px;
		}
	}
</style>

<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Daftar Hadir & Penerimaan ATK</h5>
		</div>
		
		<?php
			if (!isset($id)) {
				$id = 0;
			}
		
			if (!isset($nama_daftar_hadir) || empty($nama_daftar_hadir)) {
				$nama_daftar_hadir = "Daftar Hadir ".ucfirst($spj["komponen"]);
			}
		
			if (!isset($nama_penerimaan_atk) || empty($nama_penerimaan_atk)) {
				$nama_penerimaan_atk = "Daftar Penerimaan ATK ".ucfirst($spj["komponen"]);
			}
			
			if (!isset($spasi_daftar_hadir) || empty($spasi_daftar_hadir)) {
				$spasi_daftar_hadir = "50";
			}
			
			if (!isset($spasi_penerimaan_atk) || empty($spasi_penerimaan_atk)) {
				$spasi_penerimaan_atk = "50";
			}
		?>
		
        <form method="post" class="form-daftar-hadir">
        	<input name="id" type="hidden" value="<?php print $id; ?>" />
			<input name="spj_id" type="hidden" value="<?php print $spj_id; ?>" />
			
            <div class="modal-body">
				<div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Judul Daftar Hadir</label>
							<textarea class="form-control" name="nama_daftar_hadir"><?php print $nama_daftar_hadir; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Judul Penerimaan ATK</label>
							<textarea class="form-control" name="nama_penerimaan_atk"><?php print $nama_penerimaan_atk; ?></textarea>
                        </div>
                    </div>
                </div>
				<div class="row">
                    <div class="col-md-12">
						<div class="form-group">
                            <label>Item</label>
							<div class="daftar-hadir-items">
								
							</div>
						</div>
                    </div>
                </div>
				<div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Ketua Panitia</label>
							<?php
								$this->load->model("pengaturan_model");
								$this->load->model("biodata_model");

								$pegawai = $this->biodata_model->getBiodataByPegawaiBalai();
							?>
							<select class="form-control select2" name="ketua_panitia">
								<option value="">&nbsp;</option>
								
								<?php
									if (!empty($pegawai)) {
										foreach ($pegawai as $peg) {
											$selected = "";
											
											if ($peg["id"] == $ketua_panitia) {
												$selected = 'selected="selected"';
											}
											
											print '<option value="'.$peg["id"].'" '.$selected.'>'.$peg["nama"].'</option>';
										}
									}
								?>
							</select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Spasi Daftar Hadir</label>
							<input type="number" class="form-control" name="spasi_daftar_hadir" maxlength="19" value="<?php print $spasi_daftar_hadir; ?>" />
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group">
                            <label>Spasi Penerimaan ATK</label>
							<input type="number" class="form-control" name="spasi_penerimaan_atk" maxlength="19" value="<?php print $spasi_penerimaan_atk; ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
				<button type="submit" class="btn btn-info mb-0">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
		</form>
    </div>
</div>
<script type="text/javascript">
	function loadDaftarHadirItems (spjId, daftarHadirId) {
		$.ajax({
			type: "POST",
			url: "/admin/spj/getItemDaftarHadir/?v="+Math.random(),
			data: {
				spj_id: spjId,
				id: daftarHadirId,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('.daftar-hadir-items').html(html);

				Loader.stop();
			}
		});
	}
	
	$(document).ready(function () {
		Loader.start();
		
		loadDaftarHadirItems(<?php print $spj_id; ?>, <?php print $id; ?>);
	});
</script>