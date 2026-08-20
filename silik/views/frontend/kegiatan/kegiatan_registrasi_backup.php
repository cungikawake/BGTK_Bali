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
							<div class="head1">Pendaftaran <?php print $type; ?></div>
							<div class="head2">Kegiatan <?php print $kegiatan["nama"]; ?></div>
							
							<p class="meta-keg">Tanggal:
								<?php
									print $this->utility->formatRangeDate($kegiatan["tgl_mulai_kegiatan"], $kegiatan["tgl_selesai_kegiatan"]);
								 ?>
							</p>
							<?php
								if ($kegiatan["tipe_kegiatan"] == "Daring") {
							?>
								<p class="meta-keg">Zoom ID: <strong><?php print $kegiatan["zoom_id_kegiatan"]; ?></strong><br /> Passcode: <strong><?php print $kegiatan["zoom_code_kegiatan"]; ?></strong></p>
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
					
					if ($type == "Peserta" && $kegiatan["link_peserta_on"]) {
						$showForm = 1;
					}
					else if ($type == "Narasumber" && $kegiatan["link_narasumber_on"]) {
						$showForm = 1;
					}
					else if ($type == "Panitia" && $kegiatan["link_panitia_on"]) {
						$showForm = 1;
					}
					else if ($type == "Pelatih Ahli" && $kegiatan["link_pa_on"]) {
						$showForm = 1;
					}
					else if ($type == "Pengajar Praktek" && $kegiatan["link_pp_on"]) {
						$showForm = 1;
					}
					else if ($type == "Fasilitator" && $kegiatan["link_fasil_on"]) {
						$showForm = 1;
					}
					else if ($type == "Instruktur" && $kegiatan["link_instruktur_on"]) {
						$showForm = 1;
					}
					
					if (!$showForm) {
				?>
                		<div class="card-block" style="text-align: center;">
                        	<h4>Opss...! Formulir Pendaftaran Sudah Tidak Tersedia</h4>
                            <div>Mohon menghubungi Panitia untuk informasi lebih lanjut. Terima kasih</div>
                        </div>
                <?php
					}
					else {
				?>
                    <div class="card-block">
                        <form action="/kegiatan/registrasi_save" method="post" class="form-submit-registrasi">
                            <input type="hidden" name="type" class="form-control" value="<?php print $type; ?>"  />
                            <input type="hidden" name="kegiatan_id" class="form-control" value="<?php print $kegiatan["id"]; ?>"  />
                            <div class="modal-body">
                                <div class="form-group m-b-10">
                                    <label>NIK (16 digit) <span class="star-req">*</span></label>
                                    <input type="text" name="nik" required class="form-control" value="" style="background-color:#FDE9F1;" maxlength="16" />
									<small>Jumlah input <span class="hitung-digit">0</span> digit</small>
                                </div>
                                <hr />
                                
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
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tempat Lahir <span class="star-req">*</span></label>
                                            <input type="text" name="tempat_lahir" required class="form-control" value="" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tgl Lahir (dd/mm/yyyy) <span class="star-req">*</span></label>
                                            <input type="text" name="tgl_lahir" required class="form-control datepicker" value="" disabled placeholder="22/05/1992" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
										<div class="form-group">
											<label>Jenis Kelamin <span class="star-req">*</span></label>
											<select name="jenis_kelamin" class="form-control select2" disabled>
												<option value=""></option>

												<?php
													$options = array("Laki-laki"=>"Laki-laki", "Perempuan" => "Perempuan");

													foreach ($options as $jk => $jkVal) {
														$selected = '';
														print '<option value="'.$jk.'" '.$selected.'>'.$jk.'</option>';
													}
												?>
											</select>
										</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>NPWP</label>
                                            <input type="text" name="npwp" class="form-control" value="" disabled />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telp/Hp <span class="star-req">*</span></label>
                                            <input type="text" name="telp" required class="form-control" value="" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" class="form-control" value="" disabled />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group m-b-10">
                                    <label>Alamat Rumah</label>
                                    <textarea name="alamat_tinggal" class="form-control" disabled></textarea>
                                </div>
                                <hr class="m-b-20" />
    
    
                                <div id="accordion2">
                                    <div class="card" style="margin-bottom: 10px;">
                                        <div class="btn btn-info" id="headSatker1" style="padding:15px 20px; margin:0; text-align: left;">
                                            <a href="javascript:;" data-toggle="collapse" data-target="#collapseSatker1" aria-expanded="true" aria-controls="collapseSatker1" style="color:#fff; text-decoration: none;">
                                                <i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;&nbsp;								
                                                <strong style="font-weight: 700;">Unit Kerja:</strong>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="collapseSatker1" class="collapse in" aria-labelledby="headSatker1" data-parent="#accordion2">
                                    <div class="card-body" style="padding: 10px 0 15px;">
                                        <div class="form-group">
                                            <label>Nama Unit Kerja/Sekolah <span class="star-req">*</span></label>
                                            <input type="text" name="unit_kerja" class="form-control" value="" disabled required />
                                        </div>
    
                                        <div class="form-group">
                                            <label>Telp Unit Kerja/Sekolah</label>
                                            <input type="text" name="telp_unit_kerja" class="form-control" value="" disabled />
                                        </div>
										
										
										<div class="form-group">
											<label>Kabupaten/Kota Unit Kerja/Sekolah <span class="star-req">*</span></label>
											<select name="kab_unit_kerja" class="form-control select2" required disabled>
												<?php
													foreach ($this->config->item("transport_area") as $areaId => $areaName) {
														print '<option value="'.$areaId.'">'.$areaName.'</option>';
													}
												?>
											</select>
										</div>
										
                                        
										<div class="form-group kab_unit_kerja_lainnya hidden">
                                            <label>Nama Kabupaten/Kota Unit Kerja/Sekolah</label>
                                            <input type="text" name="kab_unit_kerja_lainnya" class="form-control" value="" disabled />
                                        </div>
                                        <div class="form-group m-b-0">
                                            <label>Alamat Unit Kerja/Sekolah</label>
                                            <textarea name="alamat_unit_kerja" class="form-control" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
                                    $showBank = false;
                                
                                    if ($type == "Narasumber" && $kegiatan["form_show_bank_narasumber"]) {
                                        $showBank = true;
                                    }
                                    else if ($type == "Panitia" && $kegiatan["form_show_bank_panitia"]) {
                                        $showBank = true;
                                    }
                                    else if ($type == "Peserta" && $kegiatan["form_show_bank_peserta"]) {
                                        $showBank = true;
                                    }
									else if ($type == "Pelatih Ahli" && $kegiatan["form_show_bank_pa"]) {
										$showBank = true;
									}
									else if ($type == "Pengajar Praktek" && $kegiatan["form_show_bank_pp"]) {
										$showBank = true;
									}
									else if ($type == "Fasilitator" && $kegiatan["form_show_bank_fasil"]) {
										$showBank = true;
									}
									else if ($type == "Instruktur" && $kegiatan["form_show_bank_instruktur"]) {
										$showBank = true;
									}
                                
                                    if ($showBank) {
                                ?>
                                        <hr class="m-b-20" />
                                        <div id="accordion">
                                            <div class="card" style="margin-bottom: 10px;">
                                                <div class="btn btn-info" id="headingOne" style="padding:15px 20px; margin:0; text-align: left;">
                                                    <a href="javascript:;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#fff; text-decoration: none;">
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;&nbsp;
    
                                                        <strong style="font-weight: 700;">Akun Bank:</strong>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapseOne" class="collapse in" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body" style="padding: 10px 0 5px;">
                                            <div class="form-group">
                                                <label>Nama Bank <span class="star-req">*</span></label>
                                                <select name="nama_bank" class="form-control select2" required disabled>
                                                    <option value="">&nbsp;</option>
                                                    <?php
                                                        foreach ($this->config->item("bank") as $bankOpsi) {
                                                            print '<option value="'.$bankOpsi.'">'.$bankOpsi.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Pemilik Rekening <span class="star-req">*</span></label>
                                                <input type="text" name="nama_pemilik_rekening" class="form-control" value="" required disabled />
                                            </div>
                                            <div class="form-group m-b-0">
                                                <label>Nomor Rekening <span class="star-req">*</span></label>
                                                <input type="text" name="no_rekening" class="form-control" value="" disabled required />
												<small>Pastikan nomor rekening aktif dan benar</small>
                                            </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
								
								<?php
									$showUploadSurtug = false;
									$wajibUploadSurtug = false;
                                
                                    if ($type == "Narasumber" && $kegiatan["form_upload_surtug_narasumber"]) {
                                        $showUploadSurtug = true;
                                    }
                                    else if ($type == "Panitia" && $kegiatan["form_upload_surtug_panitia"]) {
                                        $showUploadSurtug = true;
                                    }
                                    else if ($type == "Peserta" && $kegiatan["form_upload_surtug_peserta"]) {
                                        $showUploadSurtug = true;
                                    }
									else if ($type == "Pelatih Ahli" && $kegiatan["form_upload_surtug_pa"]) {
										$showUploadSurtug = true;
									}
									else if ($type == "Pengajar Praktek" && $kegiatan["form_upload_surtug_pp"]) {
										$showUploadSurtug = true;
									}
									else if ($type == "Fasilitator" && $kegiatan["form_upload_surtug_fasil"]) {
										$showUploadSurtug = true;
									}
									else if ($type == "Instruktur" && $kegiatan["form_upload_surtug_instruktur"]) {
										$showUploadSurtug = true;
									}
						
						
									if ($type == "Narasumber" && $kegiatan["form_wajib_surtug_narasumber"]) {
										$showUploadSurtug = true;
                                        $wajibUploadSurtug = true;
                                    }
                                    else if ($type == "Panitia" && $kegiatan["form_wajib_surtug_panitia"]) {
										$showUploadSurtug = true;
                                        $wajibUploadSurtug = true;
                                    }
                                    else if ($type == "Peserta" && $kegiatan["form_wajib_surtug_peserta"]) {
										$showUploadSurtug = true;
                                        $wajibUploadSurtug = true;
                                    }
									else if ($type == "Pelatih Ahli" && $kegiatan["form_wajib_surtug_pa"]) {
										$showUploadSurtug = true;
										$wajibUploadSurtug = true;
									}
									else if ($type == "Pengajar Praktek" && $kegiatan["form_wajib_surtug_pp"]) {
										$showUploadSurtug = true;
										$wajibUploadSurtug = true;
									}
									else if ($type == "Fasilitator" && $kegiatan["form_wajib_surtug_fasil"]) {
										$showUploadSurtug = true;
										$wajibUploadSurtug = true;
									}
									else if ($type == "Instruktur" && $kegiatan["form_wajib_surtug_instruktur"]) {
										$showUploadSurtug = true;
										$wajibUploadSurtug = true;
									}
						
                                
                                    if ($showUploadSurtug) {
										
										$star = "";
										$required = "";
										
										if ($wajibUploadSurtug) {
											$star = '<span class="star-req">*</span>';
											$required = "required";
										}
								?>
									<hr class="m-b-20" />
                                    <div class="form-group m-b-0">
										<label>Surat Tugas (Max 5Mb) <?php print $star; ?></label>
										<div id="dropzone-surat-tugas" class="dropzone <?php print $required; ?>">
											<div class="dz-message needsclick">    
											Drop files here or click to upload.
											</div>
										</div>
									</div>
								<?php
									}
								?>
                                
                                <?php
                                    $showConfirmPaket = false;
                                
                                    if ($type == "Narasumber" && $kegiatan["form_show_confirm_paket_narasumber"]) {
                                        $showConfirmPaket = true;
                                    }
                                    else if ($type == "Panitia" && $kegiatan["form_show_confirm_paket_panitia"]) {
                                        $showConfirmPaket = true;
                                    }
                                    else if ($type == "Peserta" && $kegiatan["form_show_confirm_paket_peserta"]) {
                                        $showConfirmPaket = true;
                                    }
									else if ($type == "Pelatih Ahli" && $kegiatan["form_show_confirm_paket_pa"]) {
										$showConfirmPaket = true;
									}
									else if ($type == "Pengajar Praktek" && $kegiatan["form_show_confirm_paket_pp"]) {
										$showConfirmPaket = true;
									}
									else if ($type == "Fasilitator" && $kegiatan["form_show_confirm_paket_fasil"]) {
										$showConfirmPaket = true;
									}
									else if ($type == "Instruktur" && $kegiatan["form_show_confirm_paket_instruktur"]) {
										$showConfirmPaket = true;
									}
                                
                                    if ($showConfirmPaket) {
                                ?>
                                    <hr class="m-b-20" />
                                    <div class="form-group m-b-0">
                                        <div class="checkbox checkbox-primary d-inline" style="margin: 0;">
                                            <input type="checkbox" name="konfirmasi_paket" id="checkbox-konfirmasi_paket" value="1" disabled>
                                            <label for="checkbox-konfirmasi_paket" class="cr">
                                                <span>Saya menyatakan bahwa benar, saya <b>belum menerima biaya paket data / komunikasi</b> dari pemerintah pada bulan ini</span>
                                            </label>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
								
								
                                
                                <?php
                                    $showTtd = false;
                                
                                    if ($type == "Narasumber" && $kegiatan["form_ttd_narasumber"]) {
                                        $showTtd = true;
                                    }
                                    else if ($type == "Panitia" && $kegiatan["form_ttd_panitia"]) {
                                        $showTtd = true;
                                    }
                                    else if ($type == "Peserta" && $kegiatan["form_ttd_peserta"]) {
                                        $showTtd = true;
                                    }
									else if ($type == "Pelatih Ahli" && $kegiatan["form_ttd_pa"]) {
										$showTtd = true;
									}
									else if ($type == "Pengajar Praktek" && $kegiatan["form_ttd_pp"]) {
										$showTtd = true;
									}
									else if ($type == "Fasilitator" && $kegiatan["form_ttd_fasil"]) {
										$showTtd = true;
									}
									else if ($type == "Instruktur" && $kegiatan["form_ttd_instruktur"]) {
										$showTtd = true;
									}
                                
                                    if ($showTtd) {
                                ?>
                                        <hr class="m-b-20" />
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
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="modal-footer" style="text-align: left;">
                                <button type="submit" class="btn btn-info btn-modal-form-submit" disabled>DAFTAR</button>
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
<?php $this->load->view("frontend/kegiatan/footer"); ?>