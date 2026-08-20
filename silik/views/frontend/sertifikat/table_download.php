<?php
	$nama = "";
	$groups = array();
	$items = array();
	
	if (isset($sertifikats) && !empty($sertifikats)) {
		foreach ($sertifikats as $sertifikat) {
			// SORT BY TGL SELESAI
			$sortBy = strtotime($kegiatan[$sertifikat["kegiatan_id"]]["tgl_selesai_kegiatan"]);
			
			if (!isset($items[$sortBy])) {
				$items[$sortBy] = array();
			}
			
			$items[$sortBy][] = $sertifikat;
			
			$nama = $sertifikat["nama"];
		}
	}

	if (!empty($items)) {
		krsort($items);
		
		foreach ($items as $dateKeg => $itemSertifikats) {
			foreach ($itemSertifikats as $item) {
				$groups[] = $item;
			}
		}
	}
?>

<style type="text/css">
	.head-download-sertifikat div {
		font-weight:bold;
		padding-top:4px;
		padding-bottom:4px;
		background:#ddd;
		border-top: 1px solid #ccc;
		border-bottom: 1px solid #ccc;
	}
	.row-download-sertifikat {
		padding-top:4px;
		padding-bottom:4px;
		border-bottom: 1px solid #ddd;
		display: flex;
		align-items: center;
		flex-wrap: wrap;
	}
	.row-download-sertifikat .label {
		padding:2px 7px;
	}
	.btn-download-sertifikat {
		padding: 4px 10px;
		margin:0;
	}
</style>

<div class="table-result">
	<div style="text-align: center; font-size: 20px; margin-bottom: 15px;">Sertifikat <strong style="font-weight: bold;"><?php print $nama; ?></strong></div>
	<div class="wrap-table-bootgrid" style="padding:5px 15px;">
		<div class="row head-download-sertifikat">
			<div class="col-md-1">No</div>
			<div class="col-md-1">Sebagai</div>
			<div class="col-md-4">Kegiatan</div>
			<div class="col-md-2">Tempat Kegiatan</div>
			<div class="col-md-2">Tanggal</div>
			<div class="col-md-2">Sertifikat</div>
		</div>

		<?php
			$no = 1;
			foreach ($groups as $sertifikat) {
				$tipeKeg = $kegiatan[$sertifikat["kegiatan_id"]]["tipe_kegiatan"];
				$namaKeg = $kegiatan[$sertifikat["kegiatan_id"]]["nama"];

				if ($kegiatan[$sertifikat["kegiatan_id"]]["tipe_kegiatan"] == "Luring") {
					$tempat = $kegiatan[$sertifikat["kegiatan_id"]]["tempat_kegiatan"];
				}
				else {
					$tempat = "Zoom";
				}

				$tgl = $this->utility->formatRangeDate($kegiatan[$sertifikat["kegiatan_id"]]["tgl_mulai_kegiatan"], $kegiatan[$sertifikat["kegiatan_id"]]["tgl_selesai_kegiatan"]);

				$downloadYear = date("Y", strtotime($kegiatan[$sertifikat["kegiatan_id"]]["tgl_selesai_kegiatan"]));
				$download = 0;
				
				if (!empty($sertifikat["sertificate"])) {
					$download = 1;
				}
	
				if ($download) {
					$button = '<a href="'.base_url("/download/sertifikat/".$downloadYear."/".$sertifikat["kode"]).'" class="btn btn-info btn-sm btn-download-sertifikat" target="_blank">Download</a></td>';
				}
				else {
					$button = '-';
				}

				$labelTipeKeg = "label-success";

				if ($tipeKeg == "Daring") {
					$labelTipeKeg = "label-danger";
				}
		?>
			<div class="row row-download-sertifikat">
				<div class="col-md-1"><?php print $no; ?></div>
				<div class="col-md-1"><?php print $sertifikat["jabatan_kegiatan"]; ?></div>
				<div class="col-md-4"><?php print $namaKeg." <span class='label ".$labelTipeKeg."'>".$tipeKeg."</span>"; ?></div>
				<div class="col-md-2"><?php print $tempat; ?></div>
				<div class="col-md-2"><?php print $tgl; ?></div>
				<div class="col-md-2"><?php print $button; ?></div>
			</div>
		<?php
				$no++;
			}
		?>
	</div>
</div>