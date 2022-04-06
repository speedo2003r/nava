"use strict";
var KTDatatablesBasicScrollable = function() {

	var initTable1 = function() {
		var table = $('#kt_table_1').DataTable({
			scrollY: '50vh',
			scrollX: true,
			scrollCollapse: true,
			dom: 't',
			columnDefs: [
				{
					targets: -1,
					orderable: false,
				}
			],
			paging: false,
			"language": {
	            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
	        }
		});

		$('#datatable_search').on( 'keyup', function () {
		    table.search( this.value ).draw();
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesBasicScrollable.init();
});
 