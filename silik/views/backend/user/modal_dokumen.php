
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title">Upload Dokumen</h5>
		</div>

		<div class="modal-body">
			<div class="form-group">
				<label>Nama Dokumen</label>
				<input type="text" class="form-control" name="nama_dokumen" required />
			</div>
			<div class="form-group">
				<label>Dokumen (jpg, jpeg, pdf, doc, docx, png) Max 3Mb</label>
				<div id="dropzone-user-document" class="dropzone">
					<div class="dz-message needsclick">    
					Drop files here or click to upload.
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-info btn-submit-document mb-0">Upload</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("div#dropzone-user-document").dropzone({ 
		url: "/admin/user/uploadDocument?v"+Math.random(),
		paramName: "file", // The name that will be used to transfer the file
		maxFilesize: 3, // MB
		autoProcessQueue: false,
		acceptedFiles: '.jpg,.jpeg,.pdf,.doc,.docx,.png',
		addRemoveLinks: true,
		parallelUploads : 10,
		maxFiles: 1,
		init: function() {
			
			var submitButton = document.querySelector(".btn-submit-document");
			
			myDropzone = this;

			submitButton.addEventListener("click", function() {
				myDropzone.processQueue(); 
			});

			myDropzone.on('sending', function(file, xhr, formData){
				var nama = $('[name="nama_dokumen"]').val();
				formData.append('nama', nama);
			});

			myDropzone.on("success", function(file, xhr) {
				myDropzone.removeFile(file);
				var out = JSON.parse(xhr);
				
				if (out.error) {
					Swal.fire(
						'Gagal!',
						out.msg,
						'error'
					);
				}
				
				$('.modal').modal('hide');
				$('.actionBar [title="Refresh"]').click();
			});
			
			this.on("maxfilesexceeded", function(file){
				Swal.fire(
					'Perhatian!',
					'Hanya 1 file yang boleh diupload.',
					'warning'
				);
				myDropzone.removeFile(file);
			});
		},
	});
</script>