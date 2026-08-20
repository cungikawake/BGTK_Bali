var MonitoringLaporanKegiatan = {};

MonitoringLaporanKegiatan.TerimaLaporanSPI = function (elm) {
    var kegiatanId = $(elm).attr("data-kegiatan-id");
    var kegiatanName = $(elm).attr("data-kegiatan-name");
    var tableId = $(elm).closest("table").attr("id");

    Swal.fire({
        text: 'Kegiatan '+ kegiatanName,
        title: 'Terima Laporan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Terima Laporan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
           Loader.start();

            $.ajax({
                type: "POST",
                url: "/admin/laporan/update_status_laporan/?v="+Math.random(),
                data: {
                    kegiatan_id: kegiatanId,
                    status: 1,
                    version: Math.random()				
                },
                dataType: 'json',
                success: function(obj){
                    if (obj.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: obj.msg
                        }).then(function() {

                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses...',
                            text: obj.msg,
                            showConfirmButton: true,
                        });
                    }

					Table.refreshTable(tableId);
                    
                    Loader.stop();
                }
            });
        }
    });
}

MonitoringLaporanKegiatan.SetujuLaporanSPI = function (elm) {
    var kegiatanId = $(elm).attr("data-kegiatan-id");
    var kegiatanName = $(elm).attr("data-kegiatan-name");
    var tableId = $(elm).closest("table").attr("id");

    Swal.fire({
        text: 'Kegiatan '+ kegiatanName,
        title: 'Setuju Laporan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Setuju Laporan',
        cancelButtonText: 'Tolak Laporan',
        cancelButtonColor: '#f44236'
    }).then((result) => {

        var status = 3;
        if (result.value) {
           status = 2;
        }

        Loader.start();

        $.ajax({
            type: "POST",
            url: "/admin/laporan/update_status_laporan/?v="+Math.random(),
            data: {
                kegiatan_id: kegiatanId,
                status: status,
                version: Math.random()				
            },
            dataType: 'json',
            success: function(obj){
                if (obj.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: obj.msg
                    }).then(function() {

                    });
                }
                else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses...',
                        text: obj.msg,
                        showConfirmButton: true,
                    });
                }

                Table.refreshTable(tableId);
                
                Loader.stop();
            }
        });
    });
}

MonitoringLaporanKegiatan.TerimaLaporanKepala = function (elm) {
    var kegiatanId = $(elm).attr("data-kegiatan-id");
    var kegiatanName = $(elm).attr("data-kegiatan-name");
    var tableId = $(elm).closest("table").attr("id");

    Swal.fire({
        text: 'Kegiatan '+ kegiatanName,
        title: 'Terima Laporan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Terima Laporan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
           Loader.start();

            $.ajax({
                type: "POST",
                url: "/admin/laporan/update_status_laporan/?v="+Math.random(),
                data: {
                    kegiatan_id: kegiatanId,
                    status: 4,
                    version: Math.random()				
                },
                dataType: 'json',
                success: function(obj){
                    if (obj.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: obj.msg
                        }).then(function() {

                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses...',
                            text: obj.msg,
                            showConfirmButton: true,
                        });
                    }

					Table.refreshTable(tableId);
                    
                    Loader.stop();
                }
            });
        }
    });
}

MonitoringLaporanKegiatan.SetujuLaporanKepala = function (elm) {
    var kegiatanId = $(elm).attr("data-kegiatan-id");
    var kegiatanName = $(elm).attr("data-kegiatan-name");
    var tableId = $(elm).closest("table").attr("id");

    Swal.fire({
        text: 'Kegiatan '+ kegiatanName,
        title: 'Setuju Laporan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Setuju Laporan',
        cancelButtonText: 'Tolak Laporan',
        cancelButtonColor: '#f44236'
    }).then((result) => {

        var status = 6;
        if (result.value) {
           status = 5;
        }

        Loader.start();

        $.ajax({
            type: "POST",
            url: "/admin/laporan/update_status_laporan/?v="+Math.random(),
            data: {
                kegiatan_id: kegiatanId,
                status: status,
                version: Math.random()				
            },
            dataType: 'json',
            success: function(obj){
                if (obj.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: obj.msg
                    }).then(function() {

                    });
                }
                else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses...',
                        text: obj.msg,
                        showConfirmButton: true,
                    });
                }

                Table.refreshTable(tableId);
                
                Loader.stop();
            }
        });
    });
}

MonitoringLaporanKegiatan.TerimaJilid = function (elm) {
    var kegiatanId = $(elm).attr("data-kegiatan-id");
    var kegiatanName = $(elm).attr("data-kegiatan-name");
    var tableId = $(elm).closest("table").attr("id");

    Swal.fire({
        text: 'Kegiatan '+ kegiatanName,
        title: 'Terima Jilid Laporan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Terima Jilid Laporan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
           Loader.start();

            $.ajax({
                type: "POST",
                url: "/admin/laporan/update_status_laporan/?v="+Math.random(),
                data: {
                    kegiatan_id: kegiatanId,
                    status: 7,
                    version: Math.random()				
                },
                dataType: 'json',
                success: function(obj){
                    if (obj.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: obj.msg
                        }).then(function() {

                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses...',
                            text: obj.msg,
                            showConfirmButton: true,
                        });
                    }

					Table.refreshTable(tableId);
                    
                    Loader.stop();
                }
            });
        }
    });
}

MonitoringLaporanKegiatan.SelesaiJilid = function (elm) {
    var kegiatanId = $(elm).attr("data-kegiatan-id");
    var kegiatanName = $(elm).attr("data-kegiatan-name");
    var tableId = $(elm).closest("table").attr("id");

    Swal.fire({
        text: 'Kegiatan '+ kegiatanName,
        title: 'Selesai Jilid Laporan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Selesai Jilid Laporan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
           Loader.start();

            $.ajax({
                type: "POST",
                url: "/admin/laporan/update_status_laporan/?v="+Math.random(),
                data: {
                    kegiatan_id: kegiatanId,
                    status: 8,
                    version: Math.random()				
                },
                dataType: 'json',
                success: function(obj){
                    if (obj.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: obj.msg
                        }).then(function() {

                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses...',
                            text: obj.msg,
                            showConfirmButton: true,
                        });
                    }

					Table.refreshTable(tableId);
                    
                    Loader.stop();
                }
            });
        }
    });
}
