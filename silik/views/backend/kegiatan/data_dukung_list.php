<style style="text/css">
	table.table-dakung thead tr th {
		height:30px;
		border-bottom: 1px solid #ddd;
		padding-bottom:8px;
	}
	table.table-dakung.table-condensed>tbody>tr>td {
		padding-top:8px;
		padding-bottom:8px;
	}
</style>
<table class="table table-condensed table-hover table-striped table-dakung">
	<thead>
		<tr>
			<th width="50px">No</th>
			<th colspan="2">Nama File</th>
			<th width="45px">&nbsp;</th>
			<th width="45px">&nbsp;</th>
			<th width="45px">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if (!empty($list)) {
				$no = 1;

				foreach ($list as $dakung) {
					$id = $dakung["id"];
					$nama = $dakung["nama"];
					$namafile = $dakung["nama_file"];
					$size = $this->utility->formatSizeUnits($dakung["size"]);
					$type = $dakung["type"];
					$user = $dakung["user"];
					$tgl = $this->utility->formatDateIndo($dakung["dibuat_tgl"]);
					
					$icon = "fa-file-pdf";
					
					if ($type == "doc" || $type == "docx") {
						$icon = "fa-file-word";
					}
					else if ($type == "jpg" || $type == "jpeg") {
						$icon = "fa-file-image";
					}
					
					$showDelete = false;
					
					if ($dakung["dibuat_oleh"] == $_SESSION["user"]["id"]) {
						$showDelete = true;
					}
		?>
					<tr>
						<td>
							<?php print $no; ?>
						</td>
						<td width="30px">
							<i class="dakung-icon fas <?php print $icon; ?>"></i>
						</td>
						<td>
							<h6 class="m-0"><a href="javascript:;" class="dakung-title view-dokumen" data-id="<?php print $id; ?>" data-table="kegiatan_data_dukung" data-modal-view="backend/kegiatan/modal_view_dokumen" title="<?php print $nama; ?>"><?php print $nama; ?></a></h6>
							<div class="dakung-attr">
								<div class="dakung-size"><?php print $size; ?></div>
								<div class="dakung-date"><i class="fas fa-calendar-alt"></i> <?php print $tgl; ?></div>
								<div class="dakung-user"><i class="fas fa-user"></i> <?php print $user; ?></div>
							</div>
						</td>
						<td class="text-right">
							<a href="javascript:;" title="Lihat" class="btn btn-info btn-sm view-dokumen" data-id="<?php print $id; ?>" data-table="kegiatan_data_dukung" data-modal-view="backend/kegiatan/modal_view_dokumen"><i class="fab fa-sistrix mr-0" title="Lihat Dokumen"></i></a>
						</td>
						<td class="text-right">
							<a href="<?php print base_url("assets/data_dukung/".$_SESSION["tahun_anggaran"]."/".$kegiatan["kode"]."/".$namafile); ?>" target="_blank" download title="Download" class="btn btn-info btn-sm"><i class="fas fa-download mr-0" title="Download Dokumen"></i></a>
						</td>
						<td class="text-right">
							<?php
								if ($showDelete) {
							?>
									<a class="btn btn-sm btn-danger delete-dakung" href="javascript:;" data-id="<?php print $id; ?>" title="Hapus"><i class="fas fa-trash-alt mr-0"></i></a>
							<?php
								}
							?>
						</td>
					</tr>
		<?php
					$no++;
				}
			}
		?>
	</tbody>
</table>