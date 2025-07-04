<form action="{{ url('/admin/data_editor/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Editor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Sebagai</label>
                    <select name="id_level" id="id_level" class="form-control" required>
                        <option value="3" selected>Editor</option>
                    </select>
                    <small id="error-id_level" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <small id="error-nama" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                    <small id="error-username" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <small id="error-password" class="error-text text-danger"></small>
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
    $(document).ready(function () {
        $('#form-tambah').on('submit', function (e) {
            e.preventDefault();

            $('.error-text').text('');
            $('.form-control').removeClass('is-invalid');

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.btn-primary').prop('disabled', true).text('Menyimpan...');
                },
                success: function (response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire('Berhasil', response.message, 'success');
                        dataEditor.ajax.reload();
                    } else {
                        if (response.msgField) {
                            $.each(response.msgField, function (field, message) {
                                $('#error-' + field).text(message[0]);
                                $('#' + field).addClass('is-invalid');
                            });
                        }
                        Swal.fire('Gagal', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                },
                complete: function () {
                    $('.btn-primary').prop('disabled', false).text('Simpan');
                }
            });
        });
    });
</script>
