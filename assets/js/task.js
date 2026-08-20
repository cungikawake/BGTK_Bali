$(document).ready(function () {
    $('.priority-item').click(function () {
        var priority = $(this).attr("data-priority");
        var textPriority = $(this).text();
        
        var className = "btn-light-info";

        if (priority == 4) {
            className = "btn-light-danger";
        }
        else if (priority == 3) {
            className = "btn-light-warning";
        }
        else if (priority == 2) {
            className = "btn-light-success";
        }

        $('#task-priority').removeClass("btn-light-info btn-light-danger btn-light-warning btn-light-success");
        $('#task-priority').addClass(className).html(textPriority);

        Loader.start();

        $.ajax({
			type: "POST",
			url: "/admin/task/change_priority",
			data: {
                priority: priority,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
                if (obj.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Gagal mengubah Task Prioritas"
                    });
                }

                Loader.stop();
			}
		});
    });

    $('.status-item').click(function () {
        var status = $(this).attr("data-status");
        var textStatus = $(this).text();
        
        var className = "btn-light";

        if (status == 1) {
            className = "btn-light-danger";
        }
        else if (status == 2) {
            className = "btn-light-info";
        }
        else if (status == 3) {
            className = "btn-light-warning";
        }
        else if (status == 4) {
            className = "btn-light-success";
        }

        $('#task-status').removeClass("btn-light btn-light-info btn-light-danger btn-light-warning btn-light-success");
        $('#task-status').addClass(className).html(textStatus);

        Loader.start();

        $.ajax({
			type: "POST",
			url: "/admin/task/change_status",
			data: {
                status: status,
				version: Math.random()				
			},
			dataType: 'json',
			success: function(obj){
                if (obj.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Gagal mengubah Task Status"
                    });
                }

                Loader.stop();
			}
		});
    });
});