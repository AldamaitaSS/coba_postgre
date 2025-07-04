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
    <form action="{{ url('/admin/galeri/' . $galeri->id_galeri . '/update_ajax') }}" method="POST" id="form-edit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Galeri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Gambar</label>
                        <input type="text" name="nama_galeri" id="nama_galeri" value="{{ $galeri->nama_galeri }}" class="form-control" required>
                        <small id="error-nama_galeri" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Upload</label>
                        <input type="date" name="tanggal_upload" id="tanggal_upload" value="{{ $galeri->tanggal_upload }}" class="form-control" required readonly>
                        <small id="error-tanggal_upload" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Upload gambar</label>
                        <input type="file" name="upload_gambar" id="upload_gambar" class="form-control">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file</small>
                        <small id="error-upload_gambar" class="error-text form-text text-danger"></small>
                        @if($galeri->upload_gambar)
                            <div class="mt-2">
                                <small>File saat ini: {{ $galeri->upload_gambar }}</small>
                                <br>
                                <img src="{{ asset('storage/gambar/' . $galeri->upload_gambar) }}" width="100px" class="img-thumbnail mt-1">
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
                
                // Validasi nama galeri
                if ($('#nama_galeri').val().trim() === '') {
                    $('#error-nama_galeri').text('Nama galeri harus diisi');
                    $('#nama_galeri').addClass('is-invalid');
                    isValid = false;
                }
                
                // Validasi file (optional untuk edit)
                var fileInput = $('#upload_gambar')[0];
                if (fileInput.files && fileInput.files.length > 0) {
                    var file = fileInput.files[0];
                    var fileSize = file.size;
                    var fileName = file.name.toLowerCase();
                    var validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    var fileExtension = fileName.split('.').pop();
                    
                    if (!validExtensions.includes(fileExtension)) {
                        $('#error-upload_gambar').text('Format file harus JPG, JPEG, PNG, atau GIF');
                        $('#upload_gambar').addClass('is-invalid');
                        isValid = false;
                    }
                    
                    if (fileSize > 10485760) { // 10MB
                        $('#error-upload_gambar').text('Ukuran file maksimal 10MB');
                        $('#upload_gambar').addClass('is-invalid');
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
                                dataGaleri.ajax.reload();
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