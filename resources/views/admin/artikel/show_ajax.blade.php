@empty($artikel)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/admin/artikel') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Artikel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        @if($artikel->gambar)
                            <div class="text-center">
                                @if(in_array(strtolower(pathinfo($artikel->gambar, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/gambar/' . $artikel->gambar) }}" 
                                        alt="Gambar Artikel" 
                                        class="img-fluid rounded shadow-sm"
                                        style="max-height: 400px;">
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-file"></i> Format file tidak didukung untuk preview.
                                        <a href="{{ asset('storage/gambar/' . $artikel->gambar) }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-info ml-2">
                                            <i class="fas fa-external-link-alt"></i> Buka File
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle"></i> Gambar Tidak Tersedia
                            </div>
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th width="30%">Jenis Artikel</th>
                                <td>{{ $artikel->id_jenis }}</td>
                            </tr>
                            <tr>
                                <th>Judul</th>
                                <td>{{ $artikel->judul }}</td>
                            </tr>
                            <tr>
                                <th>Isi Artikel</th>
                                <td>{{ $artikel->isi_Artikel}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endempty