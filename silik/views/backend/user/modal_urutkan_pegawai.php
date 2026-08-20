<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<style type="text/css">
	#sortable-pegawai { 
		margin: 0;
		padding: 0;
		list-style: none;
	}
	#sortable-pegawai .ui-state-default {
		margin-top:-1px;
		padding: 8px;
		cursor: move;
	}
</style>
<div class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">Urutkan Pegawai</h5>
			</div>
			<div class="modal-body">
				<ul id="sortable-pegawai">
					<?php
						if (!empty($users)) {
							foreach ($users as $user) {
						?>
							<li class="ui-state-default"><input type="hidden" class="user-id-pegawai" value="<?php print $user["id"]; ?>" /><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><span class="nama-pegawai"><?php print $user["nama_lengkap"]; ?></span></li>
						<?php
							}
						}
					?>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info btn-modal-form-submit">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script>
  $(document).ready(function () {
    $( "#sortable-pegawai" ).sortable();

	$('.btn-modal-form-submit').click (function () {
		var i = 1;
		var data = [];

		$("#sortable-pegawai .ui-state-default").each (function () {
			var urutan = {"no_urut":i, "user_id": $(this).find('.user-id-pegawai').val()};

			data.push(urutan);
			i++;
		});

		Loader.start();

		$.ajax({
			type: "POST",
			url: "/admin/user/update_urutan_pegawai",
			data: {
				"urutan" : data,
				"v" : Math.random()
			},
			dataType: 'json',
			success: function(obj){
				$('.modal-urutkan-pegawai .modal').modal("hide");
				Loader.stop();
			}
		});
	});
  });
</script>