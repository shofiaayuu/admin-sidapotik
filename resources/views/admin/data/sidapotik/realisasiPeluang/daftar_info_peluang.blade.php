@extends('admin.layout.main')
@section('title', 'Daftar Info Peluang - Admin Sidapotik')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Daftar Info Peluang</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Daftar Data</a></li>
                    <li class="breadcrumb-item active">Daftar Info Peluang</li>
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
                    <!-- <div class="card-header pb-0">
                        <h6>Tunggakan Bedasarkan Level</h6>
                    </div> -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                            <label for="" style="font-size: 20px;font-weight: bold;">Tabel Daftar Info Peluang</label>
                            <a href="{{route('data.simpan_daftar_info_peluang')}}" class="btn btn-primary btn-tambah-data"><i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tahun</th>
                                    <th>Prospek Bisnis</th>
                                    <th>Nama</th>
                                    <th>Biaya Investasi</th>
                                    <th>Biaya Operasional</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
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
<!-- Container-fluid Ends-->

<!-- Modal -->
<!-- add data -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalForm">
    <form id="dataForm" method="POST">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 20px;font-weight: bold;">Tambah Daftar Info Peluang</h5>
                    <button type="button" class="close" id="closeModalBtn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid" style="font-size: 17px;font-weight: 600;">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select class="form-control" id="tahun" name="tahun">
                                @foreach (range(date('Y'), 2010) as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prospek_bisnis">Prospek Bisnis</label>
                            <input type="text" class="form-control" id="prospek_bisnis" name="prospek_bisnis" placeholder="Input Prospek Bisnis">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Input Nama">
                        </div>
                        <div class="form-group">
                            <label for="biaya_investasi">Biaya Investasi</label>
                            <input type="text" class="form-control" id="biaya_investasi" name="biaya_investasi" placeholder="Input Biaya Investasi">
                        </div>
                        <div class="form-group">
                            <label for="biaya_oprasional">Biaya Operasional</label>
                            <input type="text" class="form-control" id="biaya_oprasional" name="biaya_oprasional" placeholder="Input Biaya Operasional">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input Keterangan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary simpan-data">Simpan</button>
                    <button type="button" class="btn btn-primary edit-data">Edit</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- edit data -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <form id="editForm" method="POST">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 20px;font-weight: bold;">Edit Target & Capaian</h5>
                    <button type="button" class="close" id="closeModalBtn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid" style="font-size: 17px;font-weight: 600;">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select class="form-control" id="tahun" name="tahun">
                                @foreach (range(date('Y'), 2010) as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prospek_bisnis">Prospek Bisnis</label>
                            <input type="text" class="form-control" id="prospek_bisnis" name="prospek_bisnis" placeholder="Input Prospek Bisnis">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Input Nama">
                        </div>
                        <div class="form-group">
                            <label for="biaya_investasi">Biaya Investasi</label>
                            <input type="text" class="form-control" id="biaya_investasi" name="biaya_investasi" placeholder="Input Biaya Investasi">
                        </div>
                        <div class="form-group">
                            <label for="biaya_oprasional">Biaya Operasional</label>
                            <input type="text" class="form-control" id="biaya_oprasional" name="biaya_oprasional" placeholder="Input Biaya Operasional">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input Keterangan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary edit-data">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function Datatable(){
       var table = $(".datatable").DataTable({
            "dom": 'lfrtip',
			processing: true,
	        serverSide: true,
	        responsive: true,
	        searchDelay: 2000,
	        ajax: '{{ route('data.get_data_daftar_info_peluang') }}',
	        columns: [
                {data: 'tahun', name: 'tahun', orderable: false, searchable: false, render : function(data, type, row, meta){
			  		return meta.row+1;
			  	}},
	            {data: 'tahun', name: 'tahun'},
                {data: 'prospek_bisnis', name: 'prospek_bisnis'},
                {data: 'nama', name: 'nama'},
	            {data: 'biaya_investasi', name: 'biaya_investasi'},
                {data: 'biaya_oprasional', name: 'biaya_oprasional'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'action', name: 'action', orderable: false, searchable: false}


	        ],
            // order: [[0, 'desc']],
		});
    }


	function showHideButton(value) {
        if (value === "tambah") {
            $('.edit-data').addClass('d-none');
            $('.simpan-data').removeClass('d-none');
        } else {
            $('.simpan-data').addClass('d-none');
            $('.edit-data').removeClass('d-none');
        }
    }

    function tambahData() {
        $('body').on('click', '.btn-tambah-data', function(e) {
            e.preventDefault();
            showHideButton("tambah");
            $('#modalForm').modal('show');
            $('.simpan-data').off('click').on('click', function() {
                $.ajax({
                    url: '{{ route('data.simpan_daftar_info_peluang') }}',
                    type: 'POST',
                    data: {
                        "tahun": $('#dataForm #tahun').val(),
                        "prospek_bisnis": $('#dataForm #prospek_bisnis').val(),
                        "nama": $('#dataForm #nama').val(),
                        "biaya_investasi": $('#dataForm #biaya_investasi').val(),
                        "biaya_oprasional": $('#dataForm #biaya_oprasional').val(),
                        "keterangan": $('#dataForm #keterangan').val(),
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.success,
                        });
                        $('#modalForm').modal('hide');
                        $('.datatable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        showErrors(xhr.responseJSON.errors);
                    }
                });
            });
        });
    }

    function editData() {
        $('body').on('click', '.btn-edit-data', function(e) {
            e.preventDefault();
            showHideButton("edit");
            $('#editModal').modal('show');
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('get_data_daftar_info_peluang') }}/" + id + "/edit",
                type: 'GET',
                success: function(response) {
                    $('#dataForm #tahun').val(response.result.tahun);
                    $('#dataForm #prospek_bisnis').val(response.result.prospek_bisnis);
                    $('#dataForm #nama').val(response.result.nama);
                    $('#dataForm #biaya_investasi').val(response.result.biaya_investasi);
                    $('#dataForm #biaya_oprasional').val(response.result.biaya_oprasional);
                    $('#dataForm #keterangan').val(response.result.keterangan);
                    $('#modalForm').modal('show');
                    var idNew = response.result.id;
                    $('.edit-data').off('click').on('click', function() {
                        $.ajax({
                            url: "{{ url('get_data_daftar_info_peluang') }}/" + idNew,
                            type: 'PUT',
                            data: {
                                "tahun": $('#dataForm #tahun').val(),
                                "prospek_bisnis": $('#dataForm #prospek_bisnis').val(),
                                "nama": $('#dataForm #nama').val(),
                                "biaya_investasi": $('#dataForm #biaya_investasi').val(),
                                "biaya_oprasional": $('#dataForm #biaya_oprasional').val(),
                                "keterangan": $('#dataForm #keterangan').val(),
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: response.success,
                                });
                                $('#modalForm').modal('hide');
                                $('.datatable').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                showErrors(xhr.responseJSON.errors);
                            }
                        });
                    });
                }
            });
        });
    }

    function hapusData() {
        $('body').on('click', '.btn-hapus-data', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Ingin menghapus data ini!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '{{ route('data.hapus_daftar_info_peluang') }}',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: response.success,
                            });
                            $('.datatable').DataTable().ajax.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Batal",
                        text: "Batal menghapus data!",
                    });
                }
            });
        });
    }

    function showErrors(errors) {
        if (Array.isArray(errors)) {
            var errorMessages = "<ul>";
            $.each(errors, function(key, value) {
                errorMessages += "<li>" + value + "</li>";
            });
            errorMessages += "</ul>";
            Swal.fire({
                icon: "error",
                title: "Gagal",
                html: errorMessages,
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Gagal",
                text: errors,
            });
        }
        $('#modalForm').modal('hide');
    }

    $(document).ready(function() {
        Datatable();
        tambahData();
        editData();
        hapusData();
    });
    $(document).ready(function(){
        $('#closeModalBtn, #closeModal').click(function(){
            window.location.href = '{{ route("data.daftar_info_peluang") }}';
        });
    });

</script>
@endsection
