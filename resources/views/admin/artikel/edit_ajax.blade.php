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
    <form action="{{ url('/admin/artikel/' . $artikel->id_artikel . '/update_ajax') }}" method="POST" id="form-edit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Artikel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jenis Artikel</label>
                        <input type="text" name="id_jenis" id="id_jenis" value="{{ $artikel->id_jenis }}" class="form-control" required>
                        <small id="error-id_jenis" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="judul" id="judul" value="{{ $artikel->judul }}" class="form-control" required>
                        <small id="error-judul" class="error-text form-text text-danger"></small>
                    </div>
                    <div>
                        <label>Isi Artikel</label>
                        <textarea name="isi_Artikel" class="form-control" rows="5" required>{{ $artikel->isi_Artikel }}</textarea>
                        <small id="error-isi_Artikel" class="error-text form-text text-denger"></small>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="gambar" id="gambar" class="form-control">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file</small>
                        <small id="error-gambar" class="error-text form-text text-danger"></small>
                        @if($artikel->gambar)
                            <div class="mt-2">
                                <small>File saat ini: {{ $artikel->gambar }}</small>
                                <br>
                                <img src="{{ asset('storage/gambar/' . $artikel->gambar) }}" width="100px" class="img-thumbnail mt-1">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            // Set tanggal hari ini otomatis
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            $('#tanggal_upload').val(today);
            
            // Handle form submission
            $("#form-edit").on('submit', function(e) {
                e.preventDefault();
                
                // Reset error messages
                $('.error-text').text('');
                $('.form-control').removeClass('is-invalid');
                
                var isValid = true;
                
                // Validasi nama artikel
                if ($('#nama_artikel').val().trim() === '') {
                    $('#error-nama_artikel').text('Nama artikel harus diisi');
                    $('#nama_artikel').addClass('is-invalid');
                    isValid = false;
                }
                
                // Validasi file (optional untuk edit)
                var fileInput = $('#gambar')[0];
                if (fileInput.files && fileInput.files.length > 0) {
                    var file = fileInput.files[0];
                    var fileSize = file.size;
                    var fileName = file.name.toLowerCase();
                    var validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    var fileExtension = fileName.split('.').pop();
                    
                    if (!validExtensions.includes(fileExtension)) {
                        $('#error-gambar').text('Format file harus JPG, JPEG, PNG, atau GIF');
                        $('#gambar').addClass('is-invalid');
                        isValid = false;
                    }
                    
                    if (fileSize > 10485760) { // 10MB
                        $('#error-gambar').text('Ukuran file maksimal 10MB');
                        $('#gambar').addClass('is-invalid');
                        isValid = false;
                    }
                }
                
                if (isValid) {
                    var formData = new FormData(this);
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('.btn-primary').prop('disabled', true).text('Menyimpan...');
                        },
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataArtikel.ajax.reload();
                            } else {
                                if (response.msgField) {
                                    $.each(response.msgField, function(field, message) {
                                        $('#error-' + field).text(message[0]);
                                        $('#' + field).addClass('is-invalid');
                                    });
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan sistem'
                            });
                        },
                        complete: function() {
                            $('.btn-primary').prop('disabled', false).text('Simpan');
                        }
                    });
                }
            });
            
            // Clear error when input changes
            $('.form-control').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).closest('.form-group').find('.error-text').text('');
            });
        });
    </script>
@endempty