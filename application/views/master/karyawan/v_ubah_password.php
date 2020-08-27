<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ubah Username dan Password</h3>
            </div>
            <div class="card-body">
                <form id="form-edit-password">
                    <div class="form-group">
                        <input type="text" class="form-control" id="userName" name="userName" placeholder="User Name">
                        <input type="hidden" value="<?= $karyawan->id_karyawan ?>" id="idKaryawan" name="idKaryawan">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button id="btn-simpan" type="button" class="btn btn-success edit"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#btn-simpan").on('click', function() {
            let validate = $("#form-edit-password").valid();
            if (validate) {
                $("#form-edit-password");
                prosesUbahPassword();
            }
        });

        $("#form-edit-password").validate({
            rules: {
                userName: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                password: {
                    minlength: "Password minimal 6 karakter"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        function prosesUbahPassword() {
            var userName = $('#userName').val();
            var password = $('#password').val();
            var id = $('#idKaryawan').val();
            // alert(userName + " " + password)
            $.ajax({
                type: "post",
                url: "<?= base_url("master/karyawan/prosesEditPassword") ?>",
                beforeSend: function() {
                    swal({
                        title: 'Menunggu',
                        html: 'Memproses data',
                        onOpen: () => {
                            swal.showLoading()
                        }
                    })
                },
                data: {
                    user_name: userName,
                    password: password,
                    id: id,
                },
                success: function(data) {
                    swal({
                        title: 'Berhasil Mengubah Username dan Password',
                        type: 'success'
                    }).then(function() {
                        location.reload();
                    })
                }
            })
        }
    })
</script>