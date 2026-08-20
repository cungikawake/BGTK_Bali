var AutoNumeric = {};
var Select2 = {};
var Datepicker = {};

AutoNumeric.init = function () {
	
}

Select2.init = function () {
	
}

Datepicker.init = function () {
	
}

AutoNumeric.init();
Select2.init();
Datepicker.init();

var Guest = {};
Guest.keepAuth = function () {
	$.ajax({
		type: "POST",
		url: "/user/keep_auth/",
		data: {
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){
			
		}
	});	
}

Guest.keepMenu = function () {
	$.ajax({
		type: "POST",
		url: "/user/keep_menu/",
		data: {
			version: Math.random()				
		},
		dataType: 'json',
		success: function(obj){
			
		}
	});	
}

Guest.setMenu = function () {
	$('#mobile-collapse').click(function () {
		var show = true;
		
		if ($(this).hasClass("on")) {
			var show = false;
		}
		
		$.ajax({
			type: "POST",
			url: "/user/set_menu/",
			data: {
				show: show,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){

			}
		});
	});
}


var Tiket = {};

Tiket.init = function () {
	Tiket.setDropzone();
	Tiket.loadChat();
	
	$('.show-tiket-upload').click(function () {
		$('.tiket-upload').slideToggle('fast');
	});
	
	$('.ticket-status-change').change(function () {
		var status = $(this);
		var statusVal = status.val();
		var tiket = $(this).attr("tiket-id");
		
		if (statusVal == "2") {
			$.ajax({
				type: "POST",
				url: "/tiket/rating_modal",
				data: {
					tiket_id: tiket,
					version: Math.random()				
				},
				dataType: 'html',
				success: function(html){
					console.log("test");
					$('#tiket-rating-modal').remove();
					
					$("body").append('<div id="tiket-rating-modal" class="modal fade" data-backdrop="static"></div>');
					
					$('#tiket-rating-modal').html(html);
					
					$("#rating").emojiRating({
						fontSize: 40,
						onUpdate: function(count) {
							$('[name="rating"]').val(count);
						}
					});
					
					$('#tiket-rating-modal').modal("show");
				}
			});
		}
	});
	
	$(document).on("click",".btn-modal-save-rating", function () {
		var tiket = $('[name="tiket_id"]').val();
		var rating = $('[name="rating"]').val();
		
		if (rating != "") {
			$.ajax({
				type: "POST",
				url: "/tiket/save_rating",
				data: {
					rating: rating,
					tiket_id: tiket,
					version: Math.random()				
				},
				dataType: 'json',
				success: function(obj){
					if (!obj.error) {
						Swal.fire({
						  icon: 'success',
							title: 'Terimakasih atas penilaian anda!',
						  showConfirmButton: true,
						});
					}
					
					$('#tiket-rating-modal').modal("hide");
					
					Guest.keepAuth();
					
					setTimeout(function() {
						location.reload();
					}, 1000);
				}
			});
		}
		else {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: "Mohon memberikan penilaian terhadapt layanan kami"
			});
		}
	});
}

Tiket.submitChatWithoutFiles = function () {
	var msg = $('.msg-send-chat').val().trim();
	var tiketId = $('[name="tiket_id"]').val();
	
	if (msg != "") {
		$.ajax({
			type: "POST",
			url: "/tiket/saveChat/",
			data: {
				msg: msg,
				tiket_id: tiketId,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				$('.msg-send-chat').val("");
				Tiket.loadChat();
			}
		});
	}
}

Tiket.setDropzone = function () {
	if ($('#dropzone-tiket').length) {
		$("div#dropzone-tiket").dropzone({ 
			url: "/tiket/saveChat/?v"+Math.random(),
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: 5, // MB
			autoProcessQueue: false,
			acceptedFiles: '.jpg,.jpeg,.pdf,.doc,.docx,.png',
			addRemoveLinks: true,
			parallelUploads : 10,
			uploadMultiple:true,
			init: function() {
				var myDropzone = this;
				var submitButton = document.querySelector(".btn-submit-tiket");
				
				submitButton.addEventListener("click", function() {
					var msg = $('.msg-send-chat').val();
					
					if (msg == "" && myDropzone.getQueuedFiles().length == 0) {
						$('.msg-send-chat').focus();
					}
					else {
						if (myDropzone.getQueuedFiles().length > 0) {                        
							myDropzone.processQueue();
						} else { 
							Tiket.submitChatWithoutFiles();
						}	
					}
				});
				
				myDropzone.on('sending', function(file, xhr, formData){
					var msg = $('.msg-send-chat').val();
					var tiketId = $('[name="tiket_id"]').val();
					
					formData.append('msg', msg);
					formData.append('tiket_id', tiketId);
				});

				myDropzone.on("success", function(file) {
					myDropzone.removeFile(file);
					$('.msg-send-chat').val("");
					Tiket.loadChat();
				});
			},
		});
	}
}

Tiket.newWithoutFile = function () {
	var judul = $('.new-tiket-judul').val().trim();
	var deskripsi = $('.new-tiket-des').val().trim();
	
	if (deskripsi != "") {
		$.ajax({
			type: "POST",
			url: "/tiket/saveNew/",
			data: {
				deskripsi: deskripsi,
				judul: judul,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
				location.reload();
			}
		});
	}
}

Tiket.dropzoneNewTiket = function () {
	if ($('.dropzone-new-tiket').length) {
		$(".dropzone-new-tiket").dropzone({ 
			url: "/tiket/saveNew/?v"+Math.random(),
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: 5, // MB
			autoProcessQueue: false,
			acceptedFiles: '.jpg,.jpeg,.pdf,.doc,.docx,.png',
			addRemoveLinks: true,
			parallelUploads : 10,
			uploadMultiple:true,
			init: function() {
				var myDropzone = this;
				var submitButton = $(".btn-modal-form-submit")[0];
				
				submitButton.addEventListener("click", function() {
					var judul = $('[name="judul"]').val();
					var msg = $('[name="deskripsi"]').val();
					
					if (msg == "" && myDropzone.getQueuedFiles().length == 0) {
						$('[name="deskripsi"]').focus();
					}
					else {
						if (myDropzone.getQueuedFiles().length > 0) {                        
							myDropzone.processQueue();
						} else { 
							Tiket.newWithoutFile();
						}	
					}
				});
				
				myDropzone.on('sending', function(file, xhr, formData){
					var judul = $('.new-tiket-judul').val();
					var msg = $('.new-tiket-des').val();
					
					formData.append('judul', judul);
					formData.append('deskripsi', msg);
				});

				myDropzone.on("success", function(file) {
					myDropzone.removeFile(file);
					location.reload();
				});
			},
		});
	}
}

Tiket.loadChat = function () {
	if ($('.detail-tiket').length) {
		var id = $('[name="tiket_id"]').val();
		
		$.ajax({
			type: "POST",
			url: "/tiket/chat/",
			data: {
				id: id,
				version: Math.random()				
			},
			dataType: 'html',
			success: function(html){
				$('.main-friend-chat').html(html);
				
				var objDiv = $('.msg-user-chat')[0];
				objDiv.scrollTop = objDiv.scrollHeight;
				
				Guest.keepAuth();
			}
		});
	}
}

$(document).ready(function () {
	// Keep Auth Alive
	window.setInterval(function(){
	  	Guest.keepAuth();
		Guest.keepMenu();
	}, 20000);
	
	Guest.setMenu();
	Guest.keepAuth();
	Tiket.init();
	
	$('html, body').animate({scrollLeft: 0}, 200);
});