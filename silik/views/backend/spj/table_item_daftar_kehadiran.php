<?php
	if (!isset($items) || empty($items)) {
		print "Item tidak tersedia.";
	}
	else {
		
		$checkedAll = 'checked="checked"';
		
		foreach ($items as $item) {
			if (empty($item["daftar_hadir"])) {
				$checkedAll = '';
			}
		}
?>
		<table class="table table-condensed table-hover table-striped table-spby-items">
			<thead>
				<tr>
					<th class="select-cell"><input type="checkbox" class="select-box select-all-item-df" value="all" <?php print $checkedAll; ?> /></th>
					<th>No</th>
					<th>Nama</th>
					<th>Kelas</th>
					<th>Kab/Kota</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i = 1;
					foreach ($items as $item) {
						$checked = "";
						
						if (!empty($id) && $item["daftar_hadir"] == $id) {
							$checked = 'checked="checked"';
						}
				?>
						<tr>
							<td class="select-cell">
								<input name="df_item[<?php print $item["id"]; ?>]" type="hidden" value="0" />
								<input name="df_item[<?php print $item["id"]; ?>]" type="checkbox" class="select-box select-df-item" value="<?php print $item["id"]; ?>" <?php print $checked; ?> />
							</td>
							<td><?php print $i; ?></td>
							<td><?php print $item["nama"]; ?></td>
							<td><?php print $item["kategori"]; ?></td>
							<td><?php print $item["kab_asal"]; ?></td>
						</tr>
				<?php
						$i++;
					}		
				?>
			</tbody>
		</table>

		<script type="text/javascript">
			$(document).ready(function () {
				$(".select-all-item-df").change(function() {
					if ($('input.select-all-item-df').is(':checked')) {
						$(".select-df-item").prop('checked', true);
					}
					else {
						$(".select-df-item").prop('checked', false);
					}
				});
			});
		</script>
<?php
	}
?>