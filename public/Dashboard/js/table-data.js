// $(function(e) {
// 	//file export datatable
// 	var table = $('#example').DataTable({
// 		lengthChange: false,
// 		buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
// 		responsive: true,
// 		language: {
// 			searchPlaceholder: 'Search...',
// 			sSearch: '',
// 			lengthMenu: '_MENU_ ',
// 		}
// 	});
// 	table.buttons().container()
// 	.appendTo( '#example_wrapper .col-md-6:eq(0)' );		
	
// 	$('#example1').DataTable({
// 		language: {
// 			searchPlaceholder: 'Search...',
// 			sSearch: '',
// 			lengthMenu: '_MENU_',
// 		}
// 	});
// 	$('#example2').DataTable({
// 		responsive: true,
// 		language: {
// 			searchPlaceholder: 'Search...',
// 			sSearch: '',
// 			lengthMenu: '_MENU_',
// 		}
// 	});
// 	var table = $('#example-delete').DataTable({
// 		responsive: true,
// 		language: {
// 			searchPlaceholder: 'Search...',
// 			sSearch: '',
// 			lengthMenu: '_MENU_',
// 		}
// 	}); 
//     $('#example-delete tbody').on( 'click', 'tr', function () {
//         if ( $(this).hasClass('selected') ) {
//             $(this).removeClass('selected');
//         }
//         else {
//             table.$('tr.selected').removeClass('selected');
//             $(this).addClass('selected');
//         }
//     } );
 
//     $('#button').click( function () {
//         table.row('.selected').remove().draw( false );
//     } );
	
// 	//Details display datatable
// 	$('#example-1').DataTable( {
// 		responsive: true,
// 		language: {
// 			searchPlaceholder: 'Search...',
// 			sSearch: '',
// 			lengthMenu: '_MENU_',
// 		},
// 		responsive: {
// 			details: {
// 				display: $.fn.dataTable.Responsive.display.modal( {
// 					header: function ( row ) {
// 						var data = row.data();
// 						return 'Details for '+data[0]+' '+data[1];
// 					}
// 				} ),
// 				renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
// 					tableClass: 'table border mb-0'
// 				} )
// 			}
// 		}
// 	} );
// });
$(function(e) {
    // Helper function to initialize DataTable if not already initialized
    function initializeDataTable(selector, options) {
        if (!$.fn.DataTable.isDataTable(selector)) {
            return $(selector).DataTable(options);
        } else {
            return $(selector).DataTable();
        }
    }

    // File export datatable
    var table = initializeDataTable('#example', {
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
    });

    table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

    initializeDataTable('#example1', {
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
    });

    initializeDataTable('#example2', {
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
    });

    var tableDelete = initializeDataTable('#example-delete', {
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
    });

    $('#example-delete tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            tableDelete.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#button').click(function () {
        tableDelete.row('.selected').remove().draw(false);
    });

    // Details display datatable
    initializeDataTable('#example-1', {
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        },
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details for ' + data[0] + ' ' + data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table border mb-0'
                })
            }
        }
    });
});
