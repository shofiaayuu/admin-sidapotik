@extends('admin.layout.main')
@section('title', 'Objek Pajak PDL - Smart Dashboard')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Objek Pajak PDL</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">PDL</a></li>
                    <li class="breadcrumb-item active">Objek Pajak</li>
                    <li class="breadcrumb-item active">Detail Pendaftaran dan Penutupan OP</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid chart-widget">
    <div class="row">
        <div class="col-xl-12">
            <div class="col">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h6>Detail Pendaftaran dan Penutupan OP</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-detail">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="text-align: center;">NO</th>
                                        <th rowspan="2" style="text-align: center;">NOP</th>
                                        <th rowspan="2" style="text-align: center;">NPWPD</th>
                                        <th rowspan="2" style="text-align: center;">Nama Rekening</th>
                                        <th rowspan="2" style="text-align: center;">Nama Subjek Pajak</th>
                                        <th rowspan="2" style="text-align: center;">Alamat Subjek Pajak</th>
                                        <th rowspan="2" style="text-align: center;">Nama Objek Pajak</th>
                                        <th rowspan="2" style="text-align: center;">Alamat Objek Pajak</th>
                                        <th rowspan="2" style="text-align: center;">Tanggal Daftar</th>
                                        <th rowspan="2" style="text-align: center;">Tanggal Tutup</th>
                                        <th colspan="2" style="text-align: center;">Contact Person</th>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Nomor Telepon</th>
                                    </tr>
                                </thead>
                            </table>			
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
@endsection

@section('js')
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script>

function formatRupiah(angka) {
            var options = {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 2,
            };
            var formattedNumber = angka.toLocaleString('ID', options);
            return formattedNumber;
        }

        function newexportaction(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function(e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function(e, settings) {
                    // Call the original action function
                    if (button[0].className.indexOf('buttons-copy') >= 0) {
                        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                        $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-print') >= 0) {
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                    }
                    dt.one('preXhr', function(e, s, data) {
                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                        // Set the property to what it was before exporting.
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });
                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                    setTimeout(dt.ajax.reload, 0);
                    // Prevent rendering of the full data to the DOM
                    return false;
                });
            });
            // Requery the server with the new one-time export settings
            dt.ajax.reload();
        };
    function table_detail_daftar_tutup(){
        let kategori = "{{$kategori}}";
        let bulan = "{{$bulan}}";
        let tahun = "{{$tahun}}";
       var table = $(".table-detail").DataTable({
            dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center'B><'col-sm-12 col-md-3'>>" +
                            "<'row'<'col-sm-12'tr>>" + // Add table
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                "extend": 'excel',
                "text": '<i class="fa fa-file-excel-o" style="color: white;"> Export Excel</i>',
                "titleAttr": 'Export to Excel',
                "filename": 'Pelaporan daftar tutup PDL',
                "action": newexportaction
            }, ],
			processing: true,
	        serverSide: true,
	        responsive: true,
	        searchDelay: 2000,
            ajax: {
                url: '{{ route('pdl.op.datatable_detail_daftar_tutup_op') }}',
                type: 'GET',
                data: {
                  "kategori":kategori,
                  "bulan":bulan,
                  "tahun":tahun
                }
            },
	        columns: [
	            {data: 'no', name: 'no'},
                {data: 'nop', name: 'nop'},
	            {data: 'npwpd', name: 'npwpd'},
	            {data: 'nama_rekening', name: 'nama_rekening'},
                {data: 'nama_subjek_pajak', name: 'nama_subjek_pajak'},
                {data: 'alamat_subjek_pajak', name: 'alamat_subjek_pajak'},
	            {data: 'nama_objek_pajak', name: 'nama_objek_pajak'},
	            {data: 'alamat_objek_pajak', name: 'alamat_objek_pajak'},
                {data: 'tanggal_daftar', name: 'tanggal_daftar'},
                {data: 'tanggal_tutup', name: 'tanggal_tutup'},
	            {data: 'nama_contact_person', name: 'nama_contact_person'},
	            {data: 'telp_contact_person', name: 'telp_contact_person'}
	        ],
            order: [[0, 'asc'],[1, 'asc']],
		});
    }

    
	$(document).ready(function(){
        table_detail_daftar_tutup();
	})
</script>
@endsection