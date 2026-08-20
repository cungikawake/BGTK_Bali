<?php $this->load->view("backend/includes/header"); ?>
	
	<!-- [ breadcrumb ] start -->
	<div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-20"><i class="feather icon-user"></i> Desain Sertifikat</h5>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- [ breadcrumb ] end -->
	<link rel="stylesheet" href="<?php print base_url('assets/plugins/jquery-ui/css/jquery-ui.css'); ?>">
	
	<?php
		$fonts = $this->config->item("sertifikat_fonts");

		$data = array(
			"nama_peserta_type" => "Nama Peserta Kegiatan",
			"nama_peserta_font" => "Cambria",
			"nama_peserta_size" => "28",
			"nama_peserta_x" => "41",
			"nama_peserta_y" => "209",
			"nama_peserta_w" => "624",
			"nama_peserta_align" => "left",
			"nomor_registrasi_font" => "Cambria",
			"nomor_registrasi_size" => "14",
			"nomor_registrasi_x" => "272",
			"nomor_registrasi_y" => "134",
			"nomor_registrasi_w" => "180",
			"nomor_registrasi_align" => "left",
			"qr_code_y" => "415",
			"qr_code_x" => "620"
		);

		if (isset($sertifikat["koordinat"]) && !empty($sertifikat["koordinat"])) {
			$data = json_decode($sertifikat["koordinat"], true);
			
			if (!isset($data["qr_code_y"])) {
				$data["qr_code_y"] = "415";
				$data["qr_code_x"] = "620";
			}
		}
	?>

	<style>
		<?php
			foreach ($fonts as $font => $fontFile) {
				if ($fontFile[0]) {
		?>
					@font-face {
						font-family: "<?php print $font; ?>";
						src: url("<?php print base_url("/assets/fonts/sertifikat/".$fontFile[1]); ?>");
					}
		
		<?php
				}
			}
		?>
		
		form .row {
			margin-left: -8px;
			margin-right: -8px;
		}
		
		form .col-md-4, form .col-md-5, form .col-md-6 {
			padding-left: 8px;
			padding-right: 8px;
		}
		
		.btn-group {
			border: 1px solid #ccc;
    		border-radius: 4px;
		}
		
		.btn-group .btn {
			padding: 8px 14px;
			text-align: center;
		}
		
		.btn-group .btn i {
			margin-right: 0;
		}
		
		.btn-group .btn:focus {
			outline: none;
			color: #fff;
		}

		.crop-pos-wrap {
			width: 700px;
			float: left;
		}

		#crop-pos {
			width: 700px;
			height: 495px;
			background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url("<?php print base_url("/assets/images/sertifikat/".$_SESSION["tahun_anggaran"]."/".$sertifikat["gambar"]."?v=".rand()); ?>");
			background-size: cover;
			position: relative;
		}
		#next_page {
			width: 700px;
			height: 495px;
			<?php
				if (isset($sertifikat["gambar_2"]) && !empty($sertifikat["gambar_2"])) {
			?>
				background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url("<?php print base_url("/assets/images/sertifikat/".$_SESSION["tahun_anggaran"]."/".$sertifikat["gambar_2"]."?v=".rand()); ?>");
			<?php
				}
			?>
			background-size: cover;
			position: relative;
		}
		#nama-peserta {
			display: inline-block;
			background: rgba(225,225,225, 0.6);
			cursor: move;
			position:absolute;
			font-size: 20px;
			text-align: <?php print $data["nama_peserta_align"]; ?>;
			font-family: "<?php print $data["nama_peserta_font"]; ?>";
			line-height: normal;
		}
		#nomor-registrasi{
			display: inline-block;
			background: rgba(225,225,225, 0.6);
			cursor: move;
			position:absolute;
			font-family: "<?php print $data["nomor_registrasi_font"]; ?>";
			text-align: <?php print $data["nomor_registrasi_align"]; ?>;
			line-height: normal;
		}
		#qr-code {
			position: absolute;
			cursor: move;
			top: <?php print $data["qr_code_y"]."px"; ?>;
			left: <?php print $data["qr_code_x"]."px"; ?>;
		}
		.ui-resizable {
			outline: 1px solid #39f;
		}
		.ui-resizable-e, .ui-resizable-w {
			background-color: #39f;
			height: 5px;
			opacity: 0.75;
			width: 5px;
			cursor: ew-resize;
			top:calc(50% - 3px);
		}
		.crop-val {
			width: calc(100% - 700px);
			float: left;
			padding: 0 0 0 40px;
		}
		.card-body:after {
			display: block;
			content: "";
			clear: both;
		}
		.input-group-sm>.form-control {
			font-size: 14px;
		}
	</style>

	
	<div class="main-body">
		<div class="page-wrapper"> 
			<!-- [ Main Content ] start -->
			<div class="row">
				
				<div class="col-md-12">										
					<div class="card">
						<div class="card-header">
							<h5>Design Sertifikat (<?php print $sertifikat["nama"]; ?>)</h5>
						</div>
						<div class="card-body row"> 
							<div class="crop-pos-wrap col-md-8">
								<div id="crop-pos">
									<div id="nomor-registrasi" style="top:<?php print $data["nomor_registrasi_y"]; ?>px; left:<?php print $data["nomor_registrasi_x"]; ?>px; width:<?php print $data["nomor_registrasi_w"]; ?>px; font-size:<?php print $data["nomor_registrasi_size"]; ?>px;">
										<div class="text">NO10-253673/B7.14/Cert/2022</div>
									</div>
									<div id="nama-peserta" style="top:<?php print $data["nama_peserta_y"]; ?>px; left:<?php print $data["nama_peserta_x"]; ?>px; width:<?php print $data["nama_peserta_w"]; ?>px; font-size:<?php print $data["nama_peserta_size"]; ?>px;">
										<div class="text"><?php print $data["nama_peserta_type"]; ?></div>
									</div>
									<img id="qr-code" src="<?php print base_url("/assets/images/qrcode.png"); ?>" width="79.8px" />
								</div>
								

								<hr style="margin-top:15px;" />
								<a class="btn btn-info" data-view="backend/sertifikat/modal_belakang" data-toggle="modal" data-target="#modal_belakang">Tambah Halaman</a>
								<p><small>Tambah halaman 2 (Optional)</small></p> 
								<?php $this->load->view("backend/sertifikat/modal_belakang"); ?>

								<?php if(!empty($sertifikat["gambar_2"])){ ?>
								<hr/>
								<h5>Halaman 2</h5>
								<div id="next_page"></div>
								<?php } ?>
							</div>

							<div class="crop-val col-md-4">
								<form class="form-design-sertifikat" method="post" action="">
									<input type="hidden" class="id_sertifikat" value="<?php print $sertifikat["id"]; ?>" />
									
									<div class="form-group">
										<h5>Pengaturan Nomor Sertifikat</h5>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Font</label>
												<select name="nomor_registrasi_font" class="form-control nomor-registrasi-font">
													<?php
														foreach ($fonts as $font => $fontFile) {
															$selected = "";
															if ($data["nomor_registrasi_font"] == $font) {
																$selected = 'selected="selected"';
															}
													?>
															<option value="<?php print $font; ?>" <?php print $selected; ?></optio><?php print $font; ?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Size</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control nomor-registrasi-size" value="<?php print $data["nomor_registrasi_size"]; ?>" name="nomor_registrasi_size" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Align</label>
												<input type="hidden" name="nomor_registrasi_align" value="<?php print $data["nomor_registrasi_align"]; ?>" />
												<div class="btn-group nomor-registrasi-align" role="group" aria-label="Basic example">
													<?php
														$nomorAlignLeft = "";
														$nomorAlignCenter = "";
														$nomorAlignRight = "";
													
														if ($data["nomor_registrasi_align"] == "right") {
															$nomorAlignRight = "btn-secondary";
														}
														else if ($data["nomor_registrasi_align"] == "center") {
															$nomorAlignCenter = "btn-secondary";
														}
														else {
															$nomorAlignLeft = "btn-secondary";
														}
													?>
													<button type="button" class="btn <?php print $nomorAlignLeft; ?>" value="left"><i class="fas fa-align-left"></i></button>
													<button type="button" class="btn <?php print $nomorAlignCenter; ?>" value="center"><i class="fas fa-align-center"></i></button>
													<button type="button" class="btn <?php print $nomorAlignRight; ?>" value="right"><i class="fas fa-align-right"></i></button>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>X Position</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control nomor-registrasi-x" value="<?php print $data["nomor_registrasi_x"]; ?>" name="nomor_registrasi_x" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Y Position</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control nomor-registrasi-y" value="<?php print $data["nomor_registrasi_y"]; ?>" name="nomor_registrasi_y" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Width</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control nomor-registrasi-w" value="<?php print $data["nomor_registrasi_w"]; ?>" name="nomor_registrasi_w" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
									</div>
								
									<hr style="margin: 20px 0;" />
								
									<div class="form-group">
										<h5>Pengaturan Nama Peserta</h5>
									</div>
									<div class="form-group">
										<label>Contoh Text Nama</label>
										<input type="text" class="form-control nama-peserta-type" value="<?php print $data["nama_peserta_type"]; ?>" name="nama_peserta_type" />
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Font</label>
												<select name="nama_peserta_font" class="form-control nama-peserta-font">
													<?php
														foreach ($fonts as $font => $fontFile) {
															$selected = "";
															if ($data["nama_peserta_font"] == $font) {
																$selected = 'selected="selected"';
															}
													?>
															<option value="<?php print $font; ?>" <?php print $selected; ?></optio><?php print $font; ?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Size</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control nama-peserta-size" value="<?php print $data["nama_peserta_size"]; ?>" name="nama_peserta_size" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Align</label>
												<input type="hidden" name="nama_peserta_align" value="<?php print $data["nama_peserta_align"]; ?>" />
												<div class="btn-group nama-peserta-align" role="group" aria-label="Basic example">
													<?php
														$namaAlignLeft = "";
														$namaAlignCenter = "";
														$namaAlignRight = "";
													
														if ($data["nama_peserta_align"] == "right") {
															$namaAlignRight = "btn-secondary";
														}
														else if ($data["nama_peserta_align"] == "center") {
															$namaAlignCenter = "btn-secondary";
														}
														else {
															$namaAlignLeft = "btn-secondary";
														}
													?>
													<button type="button" class="btn <?php print $namaAlignLeft; ?>" value="left"><i class="fas fa-align-left"></i></button>
													<button type="button" class="btn <?php print $namaAlignCenter; ?>" value="center"><i class="fas fa-align-center"></i></button>
													<button type="button" class="btn <?php print $namaAlignRight; ?>" value="right"><i class="fas fa-align-right"></i></button>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>X Position</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control nama-peserta-x" value="<?php print $data["nama_peserta_x"]; ?>" name="nama_peserta_x" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Y Position</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control nama-peserta-y" value="<?php print $data["nama_peserta_y"]; ?>" name="nama_peserta_y" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Width</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control nama-peserta-w" value="<?php print $data["nama_peserta_w"]; ?>" name="nama_peserta_w" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
									</div>
							
							
									<hr style="margin: 20px 0;" />
									
									<div class="form-group">
										<h5>Pengaturan QR Kode</h5>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>X Position</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control qr-code-x" value="<?php print $data["qr_code_x"]; ?>" name="qr_code_x" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Y Position</label>
												<div class="input-group input-group-sm">
													<input type="number" class="form-control qr-code-y" value="<?php print $data["qr_code_y"]; ?>" name="qr_code_y" />
													<span class="input-group-append">
														<span class="input-group-text">px</span>
													</span>
												</div>
											</div>
										</div>
									</div>
								
									
							
									<div class="form-group">
										<a class="btn btn-info btn-save-koordinat">Simpan</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- [ Main Content ] end -->
		</div>
	</div>


	<script src="<?php print base_url('assets/plugins/jquery-ui/js/jquery-ui.js'); ?>"></script>
	<script type="text/javascript">
		
		$(document).ready(function () {
			$('#btn_modal_belakang').click(function(){ 
				$("#modal_belakang").modal("show");
			});
			$('#close_modal_belakang').click(function(){
				$("#modal_belakang").modal("hide");
			});


			var Sertifikat = {};
			
			Sertifikat.init = function () {
				$( "#crop-pos #nomor-registrasi, #crop-pos #nama-peserta" )
				.draggable({
				  	containment: "parent",
					drag: function(event,ui) {
						var id = $(this).attr("id");
						var xPos = Math.round(ui.position.left);
						var yPos = Math.round(ui.position.top);
						
						if (id == "nama-peserta") {
							$('.nama-peserta-x').val(xPos);
							$('.nama-peserta-y').val(yPos);
						}
						else {
							$('.nomor-registrasi-x').val(xPos);
							$('.nomor-registrasi-y').val(yPos);
						}
					}
				})
				.resizable({
					handles: 'e, w',
					containment: "parent",
					resize: function(event,ui) {
						var id = $(this).attr("id");
						var w = Math.round(ui.size.width);
						var xPos = Math.round(ui.position.left);
						
						if (id == "nama-peserta") {
							$('.nama-peserta-w').val(w);
							$('.nama-peserta-x').val(xPos);
						}
						else {
							$('.nomor-registrasi-w').val(w);
							$('.nomor-registrasi-x').val(xPos);
						}
					}
				});
				
				$( "#crop-pos #qr-code" )
				.draggable({
				  	containment: "parent",
					drag: function(event,ui) {
						var id = $(this).attr("id");
						var xPos = Math.round(ui.position.left);
						var yPos = Math.round(ui.position.top);
						
						$('.qr-code-x').val(xPos);
						$('.qr-code-y').val(yPos);
					}
				})
				
				$('.nama-peserta-type').keyup(function () {
					var text = $(this).val();
					$('#nama-peserta .text').text(text);
				});
				
				$('.nama-peserta-font').change(function () {
					var font = $(this).val();
					$('#nama-peserta .text').css("fontFamily",'"'+font+'"');
				});
				
				$('.nama-peserta-size').bind('keyup mouseup', function () {
					var size = $(this).val();
					$('#nama-peserta .text').css("fontSize",size+'px');
				});
				
				$('.nama-peserta-x').bind('keyup mouseup', function () {
					var pos = $(this).val();
					$('#nama-peserta').css("left",pos+'px');
				});
				
				$('.nama-peserta-y').bind('keyup mouseup', function () {
					var pos = $(this).val();
					$('#nama-peserta').css("top",pos+'px');
				});
				
				$('.nama-peserta-w').bind('keyup mouseup', function () {
					var pos = $(this).val();
					$('#nama-peserta').css("width",pos+'px');
				});
				
				
				
				
				$('.nomor-registrasi-font').change(function () {
					var font = $(this).val();
					$('#nomor-registrasi .text').css("fontFamily",'"'+font+'"');
				});
				
				$('.nomor-registrasi-size').bind('keyup mouseup', function () {
					var size = $(this).val();
					$('#nomor-registrasi .text').css("fontSize",size+'px');
				});
				
				$('.nomor-registrasi-x').bind('keyup mouseup', function () {
					var pos = $(this).val();
					$('#nomor-registrasi').css("left",pos+'px');
				});
				
				$('.nomor-registrasi-y').bind('keyup mouseup', function () {
					var pos = $(this).val();
					$('#nomor-registrasi').css("top",pos+'px');
				});
				
				$('.nomor-registrasi-w').bind('keyup mouseup', function () {
					var pos = $(this).val();
					$('#nomor-registrasi').css("width",pos+'px');
				});
				
				$('.btn-group.nama-peserta-align .btn').click(function () {
					$(this).parent().find('.btn').removeClass("btn-secondary");
					$(this).addClass("btn-secondary");
					
					var align = $(this).val();
					
					$('[name="nama_peserta_align"]').val(align);
					$('#nama-peserta').css("text-align", align);
				});
				
				$('.btn-group.nomor-registrasi-align .btn').click(function () {
					$(this).parent().find('.btn').removeClass("btn-secondary");
					$(this).addClass("btn-secondary");
					
					var align = $(this).val();
					
					$('[name="nomor_registrasi_align"]').val(align);
					$('#nomor-registrasi').css("text-align", align);
				});
				
				
				$('.qr-code-x').bind('keyup mouseup', function () {
					var pos = $(this).val();
					$('#qr-code').css("left",pos+'px');
				});
				
				$('.qr-code-y').bind('keyup mouseup', function () {
					var pos = $(this).val();
					$('#qr-code').css("top",pos+'px');
				});
				
				
				$(".btn-save-koordinat").click(function () {
					var id = $(".id_sertifikat").val();
					var formVals = $('.form-design-sertifikat').serializeArray();
					var data = {};
					
					data['id'] = id;
					
					
					
					
					$.each(formVals, function( key, value ) {
						data[value.name] = value.value;
					});
					
					$.ajax({
						type: "POST",
						url: "/admin/sertifikat/save_koordinat/",
						data: data,
						dataType: 'json',
						success: function(obj){
							if (obj.error) {
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: 'Gagal menyimpan pengaturan'
								});
							}
							else {
								Swal.fire({
								  icon: 'success',
									title: 'Sukses...',
								  text: 'Berhasil menyimpan pengaturan'
								})
							}
						}
					});	
				});
			}
			
			Sertifikat.init();
		});
	</script>

<?php $this->load->view("backend/includes/footer"); ?>
