$(function () {
    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        //dom: '<"datatable-header"f<"dt-buttons">l><"datatable-scroll"t><"datatable-footer"ip>',
        // dom: '<"datatable-header datatable-header-accent"lfB><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '_INPUT_',
            lengthMenu: '_MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' },
            "processing": "DataTables is currently busy",
            "sEmptyTable": "No data available in table", //Data tidak tersedia
            "sInfoEmpty": "Showing 0", //Menampilkan
            "sLengthMenu": "Show _MENU_ entries", //Item per halaman
            "sInfoFiltered": " - from _MAX_ entries", //- dari total _MAX_ entri
            "sInfo": "Total: _TOTAL_ entries", //entri
            "sProcessing": "Processing...",
            "sZeroRecords": "No matching records found" //Tidak ditemukan data yang cocok,
        },
        "lengthMenu": [
            [10, 20, 30, 50, 100, 150, -1],
            [10, 20, 30, 50, 100, 150, "All"]
        ],
        "bStateSave": true,
        "pageLength": 30, // default records per page
        "autoWidth": false, // disable fixed width and enable fluid table
        "processing": true, // enable/disable display message box on record load
        "serverSide": true, // enable/disable server side ajax loading
        dom:
            '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
            '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
            '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
            '>t' +
            '<"d-flex justify-content-between mx-2 row mb-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        lengthMenu: [
            [10, 20, 30, 50, 100, 150, -1],
            [10, 20, 30, 50, 100, 150, "All"]
        ],
        buttons: [{
            extend: 'collection',
            className: 'btn btn-sm btn-outline-secondary dropdown-toggle me-2',
            text: feather.icons['external-link'].toSvg({
                class: 'font-small-4 me-50'
            }) + 'Export',
            buttons: [{
                extend: 'print',
                text: feather.icons['printer'].toSvg({
                    class: 'font-small-4 me-50'
                }) + 'Print',
                className: 'dropdown-item',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'csv',
                text: feather.icons['file-text'].toSvg({
                    class: 'font-small-4 me-50'
                }) + 'Csv',
                className: 'dropdown-item',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'excel',
                text: feather.icons['file'].toSvg({
                    class: 'font-small-4 me-50'
                }) + 'Excel',
                className: 'dropdown-item',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                text: feather.icons['clipboard'].toSvg({
                    class: 'font-small-4 me-50'
                }) + 'Pdf',
                className: 'dropdown-item',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'copy',
                text: feather.icons['copy'].toSvg({
                    class: 'font-small-4 me-50'
                }) + 'Copy',
                className: 'dropdown-item',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            }
            ],
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
                $(node).parent().removeClass('btn-group');
                setTimeout(function () {
                    $(node).closest('.dt-buttons').removeClass('btn-group').addClass(
                        'd-inline-flex mt-50');
                }, 50);
            }
        },
        ],
    });

    $.fn.dataTableExt.oPagination.iFullNumbersShowPages = 10;
});

var http_codes = {
    100: 'Continue',
    101: 'Switching Protocols',
    102: 'Processing',
    103: 'Checkpoint',
    200: 'OK',
    201: 'Created',
    202: 'Accepted',
    203: 'Non-Authoritative Information',
    204: 'No Content',
    205: 'Reset Content',
    206: 'Partial Content',
    207: 'Multi-Status',
    300: 'Multiple Choices',
    301: 'Moved Permanently',
    302: 'Found',
    303: 'See Other',
    304: 'Not Modified',
    305: 'Use Proxy',
    306: 'Switch Proxy',
    307: 'Temporary Redirect',
    400: 'Bad Request',
    401: 'Unauthorized',
    402: 'Payment Required',
    403: 'Forbidden',
    404: 'Not Found',
    405: 'Method Not Allowed',
    406: 'Not Acceptable',
    407: 'Proxy Authentication Required',
    408: 'Request Timeout',
    409: 'Conflict',
    410: 'Gone',
    411: 'Length Required',
    412: 'Precondition Failed',
    413: 'Request Entity Too Large',
    414: 'Request-URI Too Long',
    415: 'Unsupported Media Type',
    416: 'Requested Range Not Satisfiable',
    417: 'Expectation Failed',
    418: 'I\'m a teapot',
    422: 'Unprocessable Entity',
    423: 'Locked',
    424: 'Failed Dependency',
    425: 'Unordered Collection',
    426: 'Upgrade Required',
    449: 'Retry With',
    450: 'Blocked by Windows Parental Controls',
    500: 'Internal Server Error',
    501: 'Not Implemented',
    502: 'Bad Gateway',
    503: 'Service Unavailable',
    504: 'Gateway Timeout',
    505: 'HTTP Version Not Supported',
    506: 'Variant Also Negotiates',
    507: 'Insufficient Storage',
    509: 'Bandwidth Limit Exceeded',
    510: 'Not Extended'
};

$.ajaxSetup({
    //cache: false,
    global: true,
    async: true,
    timeout: 20000,
    method: 'GET',
    error: function (x, t, e) {
        document.getElementById("overlay").style.display = "none";

        alert("Error " + x.status + ": " + http_codes[x.status]);
    },
    beforeSend: function () {
        document.getElementById("overlay").style.display = "block";
    },
    complete: function () {
        document.getElementById("overlay").style.display = "none";
    }
});

function _reset() {
    $(".form-validate").each((i, item) => {
        $(item)[0]?.reset();
    });
    $(".select2").val("").trigger("change");
    $("#id").attr("value", null);
    $(".checkbox").removeAttr("checked");

    $("label.error").hide();
    $("input").removeClass("error");
    $("select").removeClass("error");
    $(".error").remove();

    $("#frm")[0].reset();
    for (var instanceName in CKEDITOR.instances)
        CKEDITOR.instances[instanceName].setData('');
}
