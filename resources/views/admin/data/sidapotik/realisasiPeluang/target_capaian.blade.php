@extends('admin.layout.main')
@section('title', 'Target & Capaian - Admin Sidapotik')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Target & Capaian</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Daftar Data</a></li>
                    <li class="breadcrumb-item active">Target & Capaian</li>
                </ol>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid chart-widget">
    <div class="row">
        <div class="col-xl-12">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                        <label for="" style="font-size: 20px;font-weight: bold;">Tabel Target & Capaian</label>
                        <<a href="{{route('data.simpan_target_capaian')}}" class="btn btn-primary btn-tambah-data"><i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tahun</th>
                                    <th>Target</th>
                                    <th>Capaian</th>
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
<!-- Container-fluid Ends-->

<!-- Modal -->
<!--add data -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalForm">
    <form id="dataForm" method="POST">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 20px;font-weight: bold;">Tambah Target & Capaian</h5>
                    <button type="button" id="closeModalBtn" class="close" data-dismiss="modal" aria-label="Close">
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
                            <label for="target">Target</label>
                            <input type="text" class="form-control" id="target" name="target" placeholder="Input Target">
                        </div>
                        <div class="form-group">
                            <label for="capaian">Capaian</label>
                            <input type="text" class="form-control" id="capaian" name="capaian" placeholder="Input Capaian">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary simpan-data" >Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!--edit data -->
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
                            <label for="edit_tahun">Tahun</label>
                            <select class="form-control" id="edit_tahun" name="tahun">
                                @foreach (range(date('Y'), 2010) as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_target">Target</label>
                            <input type="text" class="form-control" id="edit_target" name="target" placeholder="Input Target">
                        </div>
                        <div class="form-group">
                            <label for="edit_capaian">Capaian</label>
                            <input type="text" class="form-control" id="edit_capaian" name="capaian" placeholder="Input Capaian">
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

    $(document).ready(function(){
        $('#exampleModal').modal('show');
    });
    function Datatable() {
        var table = $(".datatable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('data.get_data_target_capaian') }}',
            columns: [
                {data: 'no', name: 'no', orderable: false, searchable: false, render: function(data, type, row, meta) {
                    return meta.row + 1;
                }},
                {data: 'tahun', name: 'tahun'},
                {data: 'target', name: 'target'},
                {data: 'capaian', name: 'capaian'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
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
                    url: '{{ route('data.simpan_target_capaian') }}',
                    type: 'POST',
                    data: {
                        "tahun": $('#dataForm #tahun').val(),
                        "target": $('#dataForm #target').val(),
                        "capaian": $('#dataForm #capaian').val(),
                    },
                    success: function(response) {
                        console.log("Button tambah data clicked");

                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.success,
                        });
                        $('#modalForm').modal('hide');
                        $('.datatable').DataTable().ajax.reload();
                        window.location.href = '{{ route("data.target_capaian") }}';

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
                url: "{{ url('/get_data_target_capaian') }}/" + id + "/edit",
                type: 'GET',
                success: function(response) {
                    $('#editForm #edit_tahun').val(response.result.tahun);
                    $('#editForm #edit_target').val(response.result.target);
                    $('#editForm #edit_capaian').val(response.result.capaian);
                    $('#editModal').modal('show');

                    var idNew = response.result.id;
                    $('.edit-data').off('click').on('click', function() {
                        $.ajax({
                            url: "{{ url('get_data_target_capaian') }}/" + idNew,
                            type: 'PUT',
                            data: {
                                "tahun": $('#editForm #edit_tahun').val(),
                                "target": $('#editForm #edit_target').val(),
                                "capaian": $('#editForm #edit_capaian').val(),
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: response.success,
                                });
                                $('#editModal').modal('hide');
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
                if (willDelete.value) {
                    $.ajax({
                        url: '{{ route('data.hapus_target_capaian') }}',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: response.success,
                            });
                            $('.datatable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: xhr.responseJSON.error,
                            });
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
        $('#closeModalBtn, #closeModal,#simpan-data').click(function(){
            window.location.href = '{{ route("data.target_capaian") }}';
        });
    });

</script>

@endsection
