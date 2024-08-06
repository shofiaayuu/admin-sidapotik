@extends('admin.layout.main')
@section('title', 'Sektor Ketenagakerjaan- Admin Sidapotik')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Sektor Ketenagakerjaan</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Daftar Data</a></li>
                    <li class="breadcrumb-item active">Sektor Ketenagakerjaan</li>
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
                            <label for="" style="font-size: 20px;font-weight: bold;">Sektor Ketenagakerjaan</label>
                            <a href="{{route('data.simpan_sektor_ketenagakerjaan')}}" class="btn btn-primary btn-tambah-data"><i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Lembaga</th>
                                    <th>Alamat</th>
                                    <th>Jenis Pelatihan</th>
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
<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalForm">
    <form id="dataForm" method="POST">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 20px;font-weight: bold;">Sektor Ketenagakerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" id="closeModalBtn" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid" style="font-size: 17px;font-weight: 600;">
                        <div class="form-group">
                            <label for="nama_lembaga">Nama Lembaga</label>
                            <input type="text" class="form-control" id="nama_lembaga" name="nama_lembaga" placeholder="Input Nama Lembaga">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Input Alamat">
                        </div>
                        <div class="form-group">
                            <label for="jenis_pelatihan">Jenis Pelatihan</label>
                            <input type="text" class="form-control" id="jenis_pelatihan" name="jenis_pelatihan" placeholder="Input Jenis Pelatihan">
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
	        ajax: '{{ route('data.get_data_sektor_ketenagakerjaan') }}',
	        columns: [
                {data: 'id', name: 'id', orderable: false, searchable: false, render : function(data, type, row, meta){
			  		return meta.row+1;
			  	}},
	            {data: 'nama_lembaga', name: 'nama_lembaga'},
                {data: 'alamat', name: 'alamat'},
                {data: 'jenis_pelatihan', name: 'jenis_pelatihan'},
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
                    url: '{{ route('data.simpan_sektor_ketenagakerjaan') }}',
                    type: 'POST',
                    data: {
                        "nama_lembaga": $('#dataForm #nama_lembaga').val(),
                        "alamat": $('#dataForm #alamat').val(),
                        "jenis_pelatihan": $('#dataForm #jenis_pelatihan').val(),
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.success,
                        });
                        $('#modalForm').modal('hide');
                        $('.datatable').DataTable().ajax.reload();
                        window.location.href = '{{ route("data.sektor_ketenagakerjaan") }}';

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
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('get_data_sektor_ketenagakerjaan') }}/" + id + "/edit",
                type: 'GET',
                success: function(response) {
                    $('#dataForm #nama_lembaga').val(response.result.nama_lembaga);
                    $('#dataForm #alamat').val(response.result.alamat);
                    $('#dataForm #jenis_pelatihan').val(response.result.jenis_pelatihan);
                    $('#modalForm').modal('show');
                    var idNew = response.result.id;
                    $('.edit-data').off('click').on('click', function() {
                        $.ajax({
                            url: "{{ url('get_data_sektor_ketenagakerjaan') }}/" + idNew,
                            type: 'PUT',
                            data: {
                                "nama_lembaga": $('#dataForm #nama_lembaga').val(),
                                "alamat": $('#dataForm #alamat').val(),
                                "jenis_pelatihan": $('#dataForm #jenis_pelatihan').val(),
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
                        url: '{{ route('data.hapus_sektor_ketenagakerjaan') }}',
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
            window.location.href = '{{ route("data.sektor_ketenagakerjaan") }}';
        });
    });
</script>
@endsection
