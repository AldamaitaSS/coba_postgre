@empty($galeri)
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
                <a href="{{ url('/admin/galeri') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Galeri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        @if($galeri->upload_gambar)
                            <div class="text-center">
                                @if(in_array(strtolower(pathinfo($galeri->upload_gambar, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/gambar/' . $galeri->upload_gambar) }}" 
                                        alt="Gambar Galeri" 
                                        class="img-fluid rounded shadow-sm"
                                        style="max-height: 400px;">
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-file"></i> Format file tidak didukung untuk preview.
                                        <a href="{{ asset('storage/gambar/' . $galeri->upload_gambar) }}" 
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
                                <th width="30%">Nama Gambar</th>
                                <td>{{ $galeri->nama_galeri }}</td>
                            </tr>
                            <tr>
                                <th width="30%">Tanggal Upload</th>
                                <td>{{ date('d F Y', strtotime($galeri->tanggal_upload)) }}</td>
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