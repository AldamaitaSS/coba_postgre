@extends('admin.layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            {{-- <h3 class="card-title">{{ $page->title }}</h3> --}}
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/admin/artikel/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Data</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_artikel">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Artikel</th>
                        <th>Jenis Artikel</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection


@push('js')
<script>
    function modalAction(url) {
        $('#myModal').load(url, function() {
            $(this).modal('show');
        });
    }

    var dataArtikel;

    $(document).ready(function() {
        dataArtikel = $('#table_artikel').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('/admin/artikel/list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "judul",
                    name: "judul"
                },
                {
                    data: "id_jenis",
                    name: "id_jenis"
                },
                {
                    data: "gambar",
                    name: "gambar",
                    render: function(data) {
                        if(data) {
                            return '<img src="{{ asset('storage/gambar') }}/'+ data +'" width="100px" class="img-thumbnail">';
                        }
                        return '-';
                    }
                },
                {
                    data: "aksi",
                    name: "aksi",
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [
                { width: "5%", targets: 0 },  // Kolom No
                { width: "25%", targets: 1 }, 
                { width: "15%", targets: 2 }, 
                { width: "25%", targets: 3 }, // Kolom Gambar
                { width: "15%", targets: 4, className: "text-center"}  // Kolom Aksi
            ],
            autoWidth: false
        });
    });
</script>
@endpush