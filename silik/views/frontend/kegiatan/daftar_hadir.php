<?php $this->load->view("frontend/kegiatan/header"); ?>
<style type="text/css">
	*,
	*::before,
	*::after {
	  box-sizing: border-box;
	}
	
	body {
		background: url(/assets/images/registrasi-peserta-bg.jpg);
		background-size: contain;
	}
	.container {
		max-width: 800px;
		margin-top: 20px;
	}
	.loader {
		width: 100%;
		height: 100%;
		display: block;
		position: absolute;
		top: -20px;
		background: rgba(0,0,0,0.2);
		z-index: 1076;
	}
	.loader-wrap {
		position: fixed;
		left: calc(50% - 102px);
		background: #fff;
		padding: 10px 42px 20px 50px;
		top: calc(50% - 70px);
	}
	.loader-text {
		font-weight: bold;
	}
	.col-md-12 > .card {
		border-radius:16px; 
		overflow: hidden; 
	}
	.card .card-header h5:after {
		content: "";
		background:none;
		position: absolute;
		left: -25px;
		top: 0;
		width: 4px;
		height: 20px;
	}
	.card .card-header h3, .card .card-header h5 {
		margin-bottom: 7px;
	}
	.head1 {
		font-size: 24px;
		line-height: 1.1;
		margin-bottom: 8px;
		font-weight: bolder;
	}
	.head2 {
		font-size: 18px;
		line-height: 1.4;
		margin-bottom: 10px;
	}
	.meta-keg {
		font-size: 15px;
		margin-bottom: 1px;
	}
	
	.congrats {
		font-size: 24px;
    	text-align: center;
		font-weight: bold;
	}
	
	.congrats-desc {
		font-size: 18px;
		text-align: center;
	}
	
	.text-no-reg {
		font-size: 16px;
		text-align: center;
		margin-top: 25px;
	}
	
	.no-reg {
		font-size: 20px;
    	text-align: center;
	}
	
	.no-reg div {
		display: inline-block;
		padding: 15px 28px;
		border: 1px dotted #1c7aa5;
		margin-top: 5px;
		background-color: #b9e7fc;
		color: #1c7aa5;
		font-weight: bold;
	}
	
	.text-wa-grup {
    	font-size: 16px;
		text-align: center;
		margin-top: 25px;
	}
	
	.btn-wa-grup {
    	text-align: center;
		margin-top: 10px;
	}
	
	.btn-wa-grup .btn {
		background-color: #25d366;
		color: #fff;
		border-color: #25d366;
		font-size: 16px;
	}
	.btn-wa-grup i {
		font-size: 20px;
	}
	
	.btn-tele-grup {
    	text-align: center;
		margin-top: 10px;
	}
	
	.btn-tele-grup .btn {
		background-color: #0088cc;
		color: #fff;
		border-color: #0088cc;
		font-size: 16px;
	}
	.btn-tele-grup i {
		font-size: 20px;
	}
	
	.congrats-logo {
		text-align: center;
		margin-top: 90px;
		margin-bottom: 8px;
	}
	
	.congrats-logo img {
		width: 165px;
	}
	
	.card-block-congrats {
		background: url("/assets/images/hore-bg.png") no-repeat center top;
		background-size: contain;
	}
	
	.checkbox input[type=checkbox] + .cr:before {
		float: left;
		border-color: #bbb;
	}
	.checkbox input[type=checkbox] + .cr span {
		display: inline-block;
		width: calc(100% - 32px);
		float: left;
	}
	
	.signature-pad {
		width: 100%;
		height: 250px;
	}
	
	.star-req {
		color: #D80407;
		font-size: 18px;
	}
	
	strong {
		font-weight: 700;
	}
	.dropzone {
		min-height: 100px;
	}
	.dropzone .dz-message {
		margin: 2em 0;
	}
	
	.foto-buku-tabungan {
	    
	}
	.foto-buku-tabungan a {
	    border: 1px solid #c9edf9;
        border-radius: 4px;
        background: #d9edf7;
	    margin-bottom:10px;
	    padding:5px 10px;
	    display:block;
	}
	
	@media only screen and (max-width: 415px) {
		.card .card-block, .card .card-body {
			padding: 5px;
		}
		.head1, .head2, .meta-keg { text-align: center; }
		.congrats-logo { margin-top: 20px; }
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-3" style="text-align: center;">
							<img src="/assets/images/logo-kemdikbud.jpg" width="120px" />
						</div>
						<div class="col-md-9">
							<div class="head1">Daftar Hadir <?php print $komponen->name; ?></div>
							<div class="head2">Kegiatan <?php print $kegiatan["nama"]; ?></div>
							
							<p class="meta-keg">Hari/Tgl:
								<?php
									print $this->utility->formatDayDate($tgl_daftar_hadir);
								 ?>
							</p>
							<?php
								if ($kegiatan["tipe_kegiatan"] == "Daring") {
							?>
								<p class="meta-keg">Meeting ID: <strong><?php print $kegiatan["zoom_id_kegiatan"]; ?></strong><br /> Passcode: <strong><?php print $kegiatan["zoom_code_kegiatan"]; ?></strong></p>
							<?php
								}
								else {
							?>
								<p class="meta-keg">Tempat: <?php print $kegiatan["tempat_kegiatan"]; ?></p>
							<?php
								}	
							?>
						</div>
					</div>
				</div>
                
                <?php
					$showForm = 0;

					if (isset($link_on)) {
						$showForm = $link_on;
					}
					
					if (!$showForm) {
				?>
                		<div class="card-block" style="text-align: center;">
                        	<h4>Opss...! Formulir Daftar Hadir Sudah Tidak Tersedia</h4>
                            <div>Mohon menghubungi Panitia untuk informasi lebih lanjut. Terima kasih</div>
                        </div>
                <?php
					}
					else {
				?>
                    <div class="card-block">
                        <form action="/kegiatan/daftar_hadir_save" method="post" class="form-submit-daftar-hadir">
                            <input type="hidden" name="type" class="form-control" value="<?php print $type; ?>"  />
                            <input type="hidden" name="kegiatan_id" class="form-control" value="<?php print $kegiatan["id"]; ?>"  />
							<input type="hidden" name="tgl_daftar_hadir" class="form-control" value="<?php print $tgl_daftar_hadir; ?>"  />
							
                            <div class="modal-body">
                                <div class="form-group m-b-10">
                                    <label>NIK (16 digit) <span class="star-req">*</span></label>
                                    <input type="text" name="nik" required class="form-control" value="" style="background-color:#FDE9F1;" maxlength="16" />
									<small>Jumlah input <span class="hitung-digit">0</span> digit</small>
                                </div>
                                <hr />
								
								<div id="collapseOneDiri" class="collapse in" aria-labelledby="headingOne" data-parent="#accordion-diri">
								
									<div class="form-group">
										<label>Nama Lengkap <span class="star-req">*</span></label>
										<input type="text" name="nama" required class="form-control" value="" disabled />
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>NIP</label>
												<input type="text" name="nip" class="form-control" value="" disabled />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Jabatan <span class="star-req">*</span></label>
												<input type="text" name="jabatan" class="form-control" required value="" disabled />
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Golongan</label>
												<select name="golongan" class="form-control select2" required disabled>
													<option value=""></option>

													<?php
														$options = $this->config->item("golongan_pangkat");
														$valSelected = isset($golongan) ? $golongan : "";

														foreach ($options as $gol => $pang) {
															$selected = '';

															if ($valSelected == $gol) {
																$selected = 'selected="selected"';
															}

															print '<option value="'.$gol.'" data-pangkat="'.$pang.'" '.$selected.'>'.$gol.'</option>';
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Pangkat</label>
												<input type="text" name="pangkat" class="form-control" disabled value="" readonly />
											</div>
										</div>
									</div>
                                </div>
                                
                                <div id="collapseSatker1" class="collapse in" aria-labelledby="headSatker1" data-parent="#accordion2">
                                    <div class="card-body" style="padding: 10px 0 15px;">
                                        <div class="form-group">
                                            <label>Nama Unit Kerja/Sekolah <span class="star-req">*</span></label>
                                            <input type="text" name="unit_kerja" class="form-control" value="" disabled required />
                                        </div>
                                    </div>
                                </div>
								
								<div class="form-group m-b-0">
									<label>Tanda Tangan <span class="star-req">*</span></label>
									<div id="signature-pad" class="signature-pad">
										<div class="signature-pad--body canvas-disable">
											<canvas></canvas>
										</div>
										<div class="signature-pad--actions">
											<div>
											<button type="button" class="btn btn-secondary clear" data-action="clear" style="margin: 0; padding: 4px 8px; font-size: 12px;">Clear</button>
											</div>
										</div>
									</div>
									<textarea class="signature-data form-control" style="display: none;" name="tanda_tangan"></textarea>
								</div>
                            </div>
                            <div class="modal-footer" style="text-align: left;">
                                <button type="submit" class="btn btn-info btn-modal-form-submit" disabled>SIMPAN</button>
                            </div>
                        </form>
                    </div>
            	<?php
					}
				?>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("frontend/kegiatan/footer_daftar_hadir"); ?>