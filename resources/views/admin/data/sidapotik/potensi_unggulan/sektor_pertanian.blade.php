@extends('admin.layout.main')
@section('title', 'Daftar Info Peluang - Admin Sidapotik')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Sektor Pertanian</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Daftar Data</a></li>
                    <li class="breadcrumb-item active">Daftar Sektor Pertanian</li>
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
                            <label for="" style="font-size: 20px;font-weight: bold;">Tabel Daftar Sektor Pertanian</label>
                            <a href="{{route('data.simpan_sektor_umkm')}}" class="btn btn-primary btn-tambah-data"><i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Komoditas</th>
                                    <th>Alamat</th>
                                    <th>Nilai Aset</th>
                                    <th>Bidang Usaha</th>
                                    <th>Kapasitas Produksi</th>
                                    <th>Tenaga Kerja</th>
                                    <th>Pimpinan</th>
                                    <th>Nomor Telepon</th>
                                    <th>Email</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modalForm">
    <form id="dataForm" method="POST">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 20px;font-weight: bold;">Tambah Daftar Info Peluang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
	        ajax: '{{ route('data.get_data_sektor_umkm') }}',
	        columns: [
                {data: 'id', name: 'id', orderable: false, searchable: false, render : function(data, type, row, meta){
			  		return meta.row+1;
			  	}},
	            {data: 'nama', name: 'nama'},
                {data: 'alamat', name: 'alamat'},
                {data: 'nilai_aset', name: 'nilai_aset'},
	            {data: 'bidang_usaha', name: 'bidang_usaha'},
                {data: 'kapasitas_produksi', name: 'kapasitas_produksi'},
                {data: 'tenaga_kerja', name: 'tenaga_kerja'},
                {data: 'pimpinan', name: 'pimpinan'},
                {data: 'no_telp', name: 'no_telp'},
                {data: 'email', name: 'email'},
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
                    url: '{{ route('data.simpan_sektor_umkm') }}',
                    type: 'POST',
                    data: {
                        "nama": $('#dataForm #nama').val(),
                        "alamat": $('#dataForm #alamat').val(),
                        "nilai_aset": $('#dataForm #nilai_aset').val(),
                        "bidang_usaha": $('#dataForm #bidang_usaha').val(),
                        "kapasitas_produksi": $('#dataForm #kapasitas_produksi').val(),
                        "tenaga_kerja": $('#dataForm #tenaga_kerja').val(),
                        "pimpinan": $('#dataForm #pimpinan').val(),
                        "no_telp": $('#dataForm #no_telp').val(),
                        "email": $('#dataForm #email').val(),
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
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('get_data_sektor_umkm') }}/" + id + "/edit",
                type: 'GET',
                success: function(response) {
                    $('#dataForm #nama').val(response.result.tahun);
                    $('#dataForm #alamat').val(response.result.prospek_bisnis);
                    $('#dataForm #nilai_aset').val(response.result.nama);
                    $('#dataForm #bidang_usaha').val(response.result.biaya_investasi);
                    $('#dataForm #kapasitas_produksi').val(response.result.biaya_oprasional);
                    $('#dataForm #tenaga_kerja').val(response.result.keterangan);
                    $('#dataForm #pimpinan').val(response.result.biaya_oprasional);
                    $('#dataForm #no_telp').val(response.result.keterangan);
                    $('#dataForm #email').val(response.result.keterangan);
                    $('#modalForm').modal('show');
                    var idNew = response.result.id;
                    $('.edit-data').off('click').on('click', function() {
                        $.ajax({
                            url: "{{ url('get_data_sektor_umkm') }}/" + idNew,
                            type: 'PUT',
                            data: {
                                "nama": $('#dataForm #nama').val(),
                                "alamat": $('#dataForm #alamat').val(),
                                "nilai_aset": $('#dataForm #nilai_aset').val(),
                                "bidang_usaha": $('#dataForm #bidang_usaha').val(),
                                "kapasitas_produksi": $('#dataForm #kapasitas_produksi').val(),
                                "tenaga_kerja": $('#dataForm #tenaga_kerja').val(),
                                "pimpinan": $('#dataForm #pimpinan').val(),
                                "no_telp": $('#dataForm #no_telp').val(),
                                "email": $('#dataForm #email').val(),


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
                        url: '{{ route('data.hapus_sektor_umkm') }}',
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

</script>
@endsection
