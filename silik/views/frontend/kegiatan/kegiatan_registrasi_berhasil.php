<?php
	$waGrup = "";
	$teleGrup = "";

	$type = $komponen->name;
	$komponen = $komponen->code;
	$bio = $item;
	
	if (!empty($wa_grup)) {
		$waGrup = $wa_grup;
	}
	
	if (!empty($tele_grup)) {
		$teleGrup = $tele_grup;
	}
?>

<div class="card-block card-block-congrats">
	<div class="modal-body">
		<div class="form-group m-b-10">
			<div class="congrats-logo"><img src="<?php print base_url("assets/images/hore.png"); ?>" /></div>
			<div class="congrats">SELAMAT!</div>
			<div class="congrats-desc">Berhasil Melakukan Pendaftaran.</div>
			
			<?php
				if ($kegiatan["tipe_kegiatan"] == "Luring") {
			?>
			<div class="text-wa-grup">Silahkan download dan print (A4) Biodata dilink berikut ini<br />
				<a href="<?php print base_url("/admin/kegiatan/download_single_biodata/".$komponen."/".$bio["id"]); ?>" class="btn btn-info" target="_blank"><strong><i class="fas fa-address-book"></i> &nbsp;Download Biodata</strong></a>
			</div>
			
			<div class="text-wa-grup">
				<strong>MOHON MEMBAWA KELENGKAPAN BERIKUT PADA SAAT KEGIATAN</strong><br />
					1. Surat Tugas<br />
								2. Biodata<br />
								3. Dan lainnya sesuai undangan.<br />
			</div>
			<?php
				}
				else {
			?>
					<div class="text-no-reg">Nomor Pendaftaran Anda</div>
					<div class="no-reg"><div><?php print $bio["kode"]; ?></div></div>
			<?php
				}
			?>
			
			<?php
				if (!empty($waGrup) || !empty($teleGrup)) {
			?>
					<div class="text-wa-grup">Untuk informasi lebih lanjut, silahkan bergabung ke Grup Chat Dibawah ini</div>
			<?php
				}
			
				if (!empty($waGrup)) {
			?>
				<div class="btn-wa-grup"><a href="<?php print $waGrup; ?>" target="_blank" class="btn btn-primary"><i class="fab fa-whatsapp"></i> Bergabung Grup WA</a></div>
			<?php
				}
			
				if (!empty($teleGrup)) {
			?>
				<div class="btn-tele-grup"><a href="<?php print $teleGrup; ?>" target="_blank" class="btn btn-primary"><i class="fab fa-telegram-plane"></i> Bergabung Grup Telegram</a></div>
			<?php
				}
			?>
			
		</div>
	</div>
</div>