<form action="{{ url('/admin/artikel/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Artikel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Jenis Artikel</label>
                    <select name="id_jenis" id="id_jenis" class="form-control" required>
                        <option value="1" selected>Softnews</option>
                        <option value="2" selected>Hardnews</option>
                    </select>
                    <small id="error-id_jenis" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" id="judul" class="form-control" required>
                    <small id="error-judul" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Isi Artikel</label>
                    <textarea name="isi_Artikel" class="form-control" rows="5" required></textarea>
                    <small class="text-danger" id="error-isi_Artikel"></small>
                </div>
                <div class="form-group">
                    <label>Upload Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/jpeg,image/jpg,image/png,application/pdf">
                    <small id="error-gambar" class="error-text form-text text-danger"></small>
                    <small class="form-text text-muted">Format: JPG, JPEG, PNG, PDF. Max: 10MB</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        
        // Handle form submission tanpa jQuery Validate
        $("#form-tambah").on('submit', function(e) {
            e.preventDefault();
            
            // Reset error messages
            $('.error-text').text('');
            $('.form-control').removeClass('is-invalid');
            
            var isValid = true;
            
            if ($('#judul').val().trim() === '') {
                $('#error-judul').text('Nama artikel harus diisi');
                $('#judul').addClass('is-invalid');
                isValid = false;
            }
            
            // Validasi file
            var fileInput = $('#gambar')[0];
            if (!fileInput.files || fileInput.files.length === 0) {
                $('#error-gambar').text('File gambar harus diupload');
                $('#gambar').addClass('is-invalid');
                isValid = false;
            } else {
                var file = fileInput.files[0];
                var fileSize = file.size;
                var fileName = file.name.toLowerCase();
                var validExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
                var fileExtension = fileName.split('.').pop();
                
                if (!validExtensions.includes(fileExtension)) {
                    $('#error-gambar').text('Format file harus JPG, JPEG, PNG, atau PDF');
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