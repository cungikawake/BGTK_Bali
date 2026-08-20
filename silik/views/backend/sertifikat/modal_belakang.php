<div  id="modal_belakang" class="modal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title">Tambah Template </h5>
			</div>
			
			<div class="modal-body">
				<input type="hidden" name="old_id" value="<?php print $sertifikat["id"]; ?>" class="old-id-sertifikat" />
				<div class="form-group">
					<label>Background - Size A4 (3508px x 2480px)</label>
					<div id="dropzone-sertifikat-belakang" class="dropzone">
						<div class="dz-message needsclick">    
						Drop files here or click to upload.
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-info btn-submit-sertifikat-belakang">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Batal</button>
			</div>
		</div>
	</div>
</div>

<script>
	var Sertifikat = {};
	
	Sertifikat.setDropzone = function () {
		$("div#dropzone-sertifikat-belakang").dropzone({ 
			url: "/admin/sertifikat/add_next_page?v"+Math.random(),
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: 5, // MB
			autoProcessQueue: false,
			acceptedFiles: '.jpg,.jpeg',
			addRemoveLinks: true,
			parallelUploads : 10,
			maxFiles: 1,
			init: function() {
				var submitButton = document.querySelector(".btn-submit-sertifikat-belakang")
				myDropzone = this;

				submitButton.addEventListener("click", function() {
					myDropzone.processQueue(); 
				});

				myDropzone.on('sending', function(file, xhr, formData){
					 
					var idSertifikat = $('.old-id-sertifikat').val();
					formData.append('old_id', idSertifikat);
				});

				myDropzone.on("success", function(file, response) {
					myDropzone.removeFile(file);
					
					var obj = JSON.parse(response);
					window.location.href = "<?php print base_url("admin/sertifikat/edit/"); ?>"+obj.id;
				});
			},
		});
	}
	
	$(document).ready(function () {
		Sertifikat.setDropzone();
	});
</script>
