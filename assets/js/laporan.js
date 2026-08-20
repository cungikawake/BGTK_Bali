var Laporan = {};

Laporan.bootgridPenugasanList = function () {
	$("#grid-penugasan-list").bootgrid({
		rowCount: 15,
		ajax: true,
		post: function () {
			return {
				id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
			};
		},
		url: "/admin/laporan/data_penugasan",
		templates: {
			pagination: "",
			//actionDropDown: "",
			//search: "",
			infos: ""
		},
		converters: {
			currency: {
				from: function (value) { return +value; },
				to: function (value) { return 'Rp. '+parseFloat(value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }
			},
			tugas: {
				from: function (value) { return +value; },
				to: function (value) { return value+' kali'; }
			},
			tugas_hari: {
				from: function (value) { return +value; },
				to: function (value) { return value+' hari'; }
			}
		},
		labels: {
			search: "Nama Petugas"
		}
	}).on("loaded.rs.jquery.bootgrid", function() {
		/* Executes after data is loaded and rendered */
		grid.find(".command-edit").on("click", function(e)
		{
			alert("You pressed edit on row: " + $(this).data("row-id"));
		}).end().find(".command-delete").on("click", function(e)
		{
			alert("You pressed delete on row: " + $(this).data("row-id"));
		});
	});
}

Laporan.bootgridPenugasanList();