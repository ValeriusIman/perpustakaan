<!-- /.login-logo -->
<div class="login-box">
    <div class="login-logo">
        <b>SI</b> Perpustakaan
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">
                Masuk untuk memulai sesi Anda</p>

            <?= $this->session->flashdata('message') ?>

            <form id="form-registration" method="POST" action="<?= base_url('auth/login') ?>">
                <div class="input-group mb-3">
                    <input type="text" name="userName" id="userName" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="password" id="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                </div> -->
                <div class="row">
                    <button id="btn-login" type="submit" class="btn btn-primary btn-block">Masuk</button>
                </div>
                </p>
                <div align="center">
                    Username : admin <br>
                    Password : 123456
                </div>
            </form>

            <!-- /.social-auth-links -->

        </div>
        <!-- /.login-card-body -->
        <!-- <div class="card">
            
        </div> -->
    </div>
</div>


<!-- /.login-box -->
<script>
    $(function() {
        $("#btn-login").on('click', function() {
            let validate = $("#form-registration").valid();
            if (validate) {
                $("#form-registration").submit();
            }
        });
        $("#form-registration").validate({
            rules: {
                userName: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 5
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
    });
</script>