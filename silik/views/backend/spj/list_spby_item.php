<table class="table table-condensed table-hover table-striped table-spby-items">
<?php
	$fields = array();

	if ($akun == "524111" || $akun == "524113" || $akun == "524119" || $akun == "524114" || $akun == "533111") { // Perjadin Biasa
		$showTiket = 0;
		$showTaksi = 0;
		$showTransport = 0;
		$showTransLainnya = 0;
		$showUangHarian = 0;
		$showPenginapan = 0;
		
		if (isset($items) && !empty($items)) {
			foreach ($items as $item) {
				if ($item["pesawat_berangkat"] > 0 || $item["pesawat_pulang"] > 0) {
					$showTiket = 1;
				}
				
				if ($item["taksi_berangkat"] > 0 || $item["taksi_pulang"] > 0) {
					$showTaksi = 1;
				}
				
				if ($item["transport"] > 0) {
					$showTransport = 1;
				}
				
				if ($item["transport_lainnya"] > 0) {
					$showTransLainnya = 1;
				}
				
				if ($item["uang_harian"] > 0) {
					$showUangHarian = 1;
				}
				
				if ($item["penginapan"] > 0) {
					$showPenginapan = 1;
				}
			}
		}
		
		$isCheckedAll = 1;
		
		if (isset($items) && !empty($items)) {
			foreach ($items as $item) {
				if (empty($spby_id) || $spby_id != $item["spby_id"]) {
					$isCheckedAll = 0;
				}
			}
		}
		
		$checkedAll = '';
		if ($isCheckedAll) {
			$checkedAll = 'checked="checked"';
		}
		
		$disable = "";
		if ($spby["paid"]) {
			$disable = 'disabled="disabled"';
		}
	?>
		<thead>
			<tr>
				<th class="select-cell"><input type="checkbox" class="select-box select-all-item-spby" <?php print $checkedAll; ?> <?php print $disable; ?> value="all" /></th>
				<th>No</th>
				<th>Nama</th>
				
				<?php if ($akun == "524119"){ ?><th>Kelas</th><?php } ?>
				<?php if ($akun == "524119"){ ?><th>Kab/Kota Asal</th><?php } ?>
				<?php if ($showTiket) {?><th>Tiket</th><?php } ?>
				<?php if ($showTaksi) {?><th>Taksi</th><?php } ?>
				<?php if ($showTransport) {?><th>Transport</th><?php } ?>
				<?php if ($showTransLainnya) {?><th>Trans. Lainnya</th><?php } ?>
				<?php if ($showUangHarian) {?><th>Uang Harian</th><?php } ?>
				<?php if ($showPenginapan) {?><th>Penginapan</th><?php } ?>
				<th>Jumlah</th>
			</tr>
		</thead>
	
		<tbody>
			<?php
			$sumJumlah = 0;
		
			if (isset($items) && !empty($items)) {
				$i = 1;
				$sumTiket = 0;
				$sumTaksi = 0;
				$sumTransport = 0;
				$sumTransLainnya = 0;
				$sumUangHarian = 0;
				$sumPenginapan = 0;
				
				foreach ($items as $item) {
					
					if (isset($item["tgl_tugas"]) && !empty($item["tgl_tugas"])) {
						$tgl_tugas = json_decode($item["tgl_tugas"], true);
						$perjalanan = count($tgl_tugas);
						$lamaTugas = count($tgl_tugas);
						$lamaNginap = 0;
					}
					else {
						$perjalanan = 1;
						$lamaTugas = $this->utility->lama_tugas($item["tgl_mulai_tugas"], $item["tgl_selesai_tugas"]);
						$lamaNginap = $lamaTugas - 1;
					}
					
					$tiket = $item["pesawat_berangkat"] + $item["pesawat_pulang"];
					$taksi = $item["taksi_berangkat"] + $item["taksi_pulang"];
					$transport = $item["transport"] * $perjalanan;
					$transportLainnya = $item["transport_lainnya"];
					$uangHarian = $item["uang_harian"] * $lamaTugas;
					$penginapan = $item["penginapan"] * $lamaNginap;
					$jumlah = $tiket + $taksi + $transport + $transportLainnya + $uangHarian + $penginapan;
					
					$sumTiket += $tiket;
					$sumTaksi += $taksi;
					$sumTransport += $transport;
					$sumTransLainnya += $transportLainnya;
					$sumUangHarian += $uangHarian;
					$sumPenginapan += $penginapan;
					$sumJumlah += $jumlah;
					
					$checked = '';
					
					if (!empty($spby_id) && $spby_id == $item["spby_id"]) {
						$checked = 'checked="checked"';
					}
			?>
					<tr>
						<td class="select-cell">
							<input name="spby_item[<?php print $item["id"]; ?>]" type="hidden" value="0" />
							<input name="spby_item[<?php print $item["id"]; ?>]" type="checkbox" class="select-box select-spby-item" value="<?php print $item["id"]; ?>" <?php  print $checked; ?> data-spby="<?php print $spby_id; ?>" <?php print $disable; ?> data-spby-item="<?php print $item["spby_id"]; ?>" />
						</td>
						<td><?php print $i; ?></td>
						<td><?php print $item["nama"]; ?></td>
						
						<?php if ($akun == "524119"){ ?>
							<td><?php print $item["kategori"]; ?></td>
							<td><?php print $item["kab_asal"]; ?></td>
						<?php } ?>
						
						<?php if ($showTiket) {?><td><?php print $this->utility->format_money($tiket); ?></td><?php } ?>
						<?php if ($showTaksi) {?><td><?php print $this->utility->format_money($taksi); ?></td><?php } ?>
						<?php if ($showTransport) {?><td><?php print $this->utility->format_money($transport); ?></td><?php } ?>
						<?php if ($showTransLainnya) {?><td><?php print $this->utility->format_money($transportLainnya); ?></td><?php } ?>
						<?php if ($showUangHarian) {?><td><?php print $this->utility->format_money($uangHarian); ?></td><?php } ?>
						<?php if ($showPenginapan) {?><td><?php print $this->utility->format_money($penginapan); ?></td><?php } ?>
						<td><?php print $this->utility->format_money($jumlah); ?><input type="hidden" value="<?php print $jumlah ?>" class="item-value-<?php print $item["id"]; ?>" /><input type="hidden" value="0" class="item-pajak-<?php print $item["id"]; ?>" /><input type="hidden" value="<?php print $jumlah ?>" class="item-transfer-<?php print $item["id"]; ?>" /></td>
					</tr>
			<?php
					$i++;
				}
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="3">Total</th>
				<?php if ($akun == "524119"){ ?><th>&nbsp;</th><th>&nbsp;</th><?php } ?>
				<?php if ($showTiket) {?><th><?php print $this->utility->format_money($sumTiket); ?></th><?php } ?>
				<?php if ($showTaksi) {?><th><?php print $this->utility->format_money($sumTaksi); ?></th><?php } ?>
				<?php if ($showTransport) {?><th><?php print $this->utility->format_money($sumTransport); ?></th><?php } ?>
				<?php if ($showTransLainnya) {?><th><?php print $this->utility->format_money($sumTransLainnya); ?></th><?php } ?>
				<?php if ($showUangHarian) {?><th><?php print $this->utility->format_money($sumUangHarian); ?></th><?php } ?>
				<?php if ($showPenginapan) {?><th><?php print $this->utility->format_money($sumPenginapan); ?></th><?php } ?>
				<th><?php print $this->utility->format_money($sumJumlah); ?></th>
			</tr>
		</tfoot>
		<?php
	}
	else if ($akun == "522151" || $akun == "521213" || $akun == "521115") { // Jasa Profesi
		/*print "<pre>";
		print_r($items);
		print "</pre>";*/
		
		$isCheckedAll = 1;
		
		if (isset($items) && !empty($items)) {
			foreach ($items as $item) {
				if (empty($spby_id) || $spby_id != $item["spby_id_honor"]) {
					$isCheckedAll = 0;
				}
			}
		}
		
		$checkedAll = '';
		if ($isCheckedAll) {
			$checkedAll = 'checked="checked"';
		}
		
		$disable = "";
		if ($spby["paid"]) {
			$disable = 'disabled="disabled"';
		}
	?>
		<thead>
			<tr>
				<th class="select-cell"><input type="checkbox" class="select-box select-all-item-spby" <?php print $checkedAll; ?> <?php print $disable; ?> value="all" /></th>
				<th>No</th>
				<th>Nama</th>
				<th>Gol</th>
				<th class="text-right">Honor / Vol</th>
				<th class="text-right">Vol</th>
				<th class="text-right">Honor Bruto</th>
				<th class="text-right">Pajak</th>
				<th>&nbsp;</th>
				<th class="text-right">Honor Netto</th>
			</tr>
		</thead>
	<?php
		$sumBruto = 0;
		$sumPajak = 0;
		$sumNetto = 0;
		
		if (isset($items) && !empty($items)) {
			print "<tbody>";
			$i = 1;
			
			foreach ($items as $item) {
				$honorBruto = $item["honor"] * $item["vol_honor"];
				$pajakRp = $honorBruto * $item["pajak"] / 100;
				$honorNetto = $honorBruto - $pajakRp;
				
				$sumBruto += $honorBruto;
				$sumPajak += $pajakRp;
				$sumNetto += $honorNetto;
				
				
				$checked = '';
					
				if (!empty($spby_id) && $spby_id == $item["spby_id_honor"]) {
					$checked = 'checked="checked"';
				}
				
				?>
					<tr>
						<td class="select-cell">
							<input name="spby_item[<?php print $item["id"]; ?>]" type="hidden" value="0" />
							<input name="spby_item[<?php print $item["id"]; ?>]" type="checkbox" class="select-box select-spby-item" value="<?php print $item["id"]; ?>" <?php  print $checked; ?> data-spby="<?php print $spby_id; ?>" <?php print $disable; ?> data-spby-item="<?php print $item["spby_id_honor"]; ?>" />
						</td>
						<td><?php print $i; ?></td>
						<td><?php print $item["nama"]; ?></td>
						<td><?php print $item["golongan"]; ?></td>
						<td class="text-right"><?php print $this->utility->format_money($item["honor"]); ?></td>
						<td class="text-right"><?php print $item["vol_honor"]." ".$item["satuan_honor"]; ?></td>
						<td class="text-right">
							<?php print $this->utility->format_money($honorBruto); ?>
							<input type="hidden" value="<?php print $honorBruto; ?>" class="item-value-<?php print $item["id"]; ?>" />
							<input type="hidden" value="<?php print $pajakRp; ?>" class="item-pajak-<?php print $item["id"]; ?>" />
							<input type="hidden" value="<?php print $honorNetto; ?>" class="item-transfer-<?php print $item["id"]; ?>" />
						</td>
						<td class="text-right"><?php print $this->utility->format_money($pajakRp); ?></td>
						<td class="text-right"><?php print $item["pajak"]."%"; ?></td>
						<td class="text-right"><?php print $this->utility->format_money($honorNetto); ?></td>
					</tr>
				<?php
				
				$i++;
			}
			
			print "</tbody>";
		}
	?>
		<tfoot>
			<tr>
				<th>&nbsp;</th>
				<th colspan="5">Jumlah</th>
				<th class="text-right"><?php print $this->utility->format_money($sumBruto); ?></th>
				<th class="text-right"><?php print $this->utility->format_money($sumPajak); ?></th>
				<th>&nbsp;</th>
				<th class="text-right"><?php print $this->utility->format_money($sumNetto); ?></th>
			</tr>
		</tfoot>
	<?php
	}
?>
</table>