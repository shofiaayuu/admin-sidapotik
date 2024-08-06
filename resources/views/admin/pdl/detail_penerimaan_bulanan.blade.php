@extends('admin.layout.main')
@section('title', 'Detail Penerimaan Bulanan PDL - Smart Dashboard')

@section('content')
    {{-- <style>
    .dt-buttons{
        text-align: center;
    }
</style> --}}
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Penerimaan PDL</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">PDL</a></li>
                        <li class="breadcrumb-item active">Penerimaan</li>
                        <li class="breadcrumb-item active">Detail penerimaan Berdasarkan Penerimaan Bulanan PDL</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid chart-widget">

        <div class="row">
            <div class="col-xl-12">
                <div class="col-xl-12">
                    <div class="card o-hidden">
                        <div class="card-header pb-0">
                            <h6>Detail Penerimaan Berdasarkan Penerimaan Bulanan PDL </h6>
                            <h6></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-detail-penerimaan-bulanan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NPWD</th>
                                            <th>Nama Objek Pajak</th>
                                            <th>Nama Wajib Pajak</th>
                                            <th>Alamat Objek Pajak</th>
                                            <th>Alamat Wajib Pajak</th>
                                            <th>Tahun SPT</th>
                                            <th>Bulan SPT</th>
                                            <th>Nominal</th>
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

        function table_detail_penerimaan_bulanan() {
            let tahun = "{{ $tahun }}";
            let bulan = "{{ $bulan }}";
            let kecamatan = "{{ $kecamatan }}";
            let kelurahan = "{{ $kelurahan }}";
            let pajak = "{{ $pajak }}";
            var table = $(".table-detail-penerimaan-bulanan").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center'B><'col-sm-12 col-md-3'>>" +
                        "<'row'<'col-sm-12'tr>>" + // Add table
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [{
                    "extend": 'excel',
                    "text": '<i class="fa fa-file-excel-o" style="color: white;"> Export Excel</i>',
                    "titleAttr": 'Export to Excel',
                    "filename": 'Detail Penerimaan Bulanan PDL',
                    "action": newexportaction
                }, ],
                processing: true,
                serverSide: true,
                responsive: true,
                searchDelay: 2000,
                ajax: {
                    url: '{{ route('pdl.penerimaan.datatable_detail_penerimaan_perbulan') }}',
                    type: 'GET',
                    data: {
                        "tahun": tahun,
                        "bulan": bulan,
                        "kecamatan": kecamatan,
                        "kelurahan": kelurahan,
                        "pajak": pajak,
                    }
                },
                columns: [{
                        data: 'no',
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'npwd',
                        name: 'npwd'
                    },
                    {
                        data: 'nama_op',
                        name: 'nama_op'
                    },
                    {
                        data: 'nama_wp',
                        name: 'nama_wp'
                    },
                    {
                        data: 'alamat_op',
                        name: 'alamat_op'
                    },
                    {
                        data: 'alamat_wp',
                        name: 'alamat_wp'
                    },
                    {
                        data: 'masa_pajak_tahun',
                        name: 'masa_pajak_tahun'
                    },
                    {
                        data: 'masa_pajak_bulan',
                        name: 'masa_pajak_bulan'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal'
                    },
                ],
                order: [
                    [0, 'desc']
                ],
            });
        }
        document.addEventListener("DOMContentLoaded", function() {
            var bulan_array = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            ];

            var status = "{{ $bulan }}";
            var bulan = bulan_array[parseInt(status) - 1];
            document.querySelector('.card-header h6:nth-child(2)').textContent = "Bulan Pajak : " + bulan;
        });



        $(document).ready(function() {

            table_detail_penerimaan_bulanan();
        })
    </script>
@endsection
