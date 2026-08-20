<table class="table table-condensed table-hover table-striped mb-0">
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Status</th>
			<th>No Kabinet</th>
			<th>No Laci</th>
			<th>No Folder</th>
			<th>Peminjam</th>
			<th>Pembuat/Petugas</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if (isset($sejarah) && !empty($sejarah)) {
				$i = 1;

				foreach ($sejarah as $se) {
		?>
					<tr>
						<td><?php print $i; ?></td>
						<td><?php print date("d M Y", strtotime($se["dibuat_tgl"])); ?></td>
						<td><?php print $se["status"]; ?></td>
						<td><?php print $se["no_kabinet"]; ?></td>
						<td><?php print $se["no_laci"]; ?></td>
						<td><?php print $se["no_folder"]; ?></td>
						<td><?php print $se["dipinjam_nama"]; ?></td>
						<td><?php print $se["dibuat_nama"]; ?></td>
					</tr>
		<?php
					$i++;
				}
			}
		?>
	</tbody>
</table>