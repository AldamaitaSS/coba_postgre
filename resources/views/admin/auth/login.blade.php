<!DOCTYPE html> 
<html lang="en"> 
<head> 
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <title>Login Admin</title> 
 <!-- Google Font: Source Sans Pro -->
 <!-- Font Awesome -->
 <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
 <!-- icheck bootstrap -->
 <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
 <!-- SweetAlert2 -->
 <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

 <style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden; /* Mencegah scroll */
    }

    body {
        background-color: #ffffff; 
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        position: relative; /* Untuk elemen pseudo */
        
    }

    .login-box {
        width: 500px;
        padding: 40px;
        background-color: rgb(255, 255, 255);
        border-radius: 8px;
    }

    .login-box-msg {
        text-align: center; /* Pastikan teks berada di tengah secara horizontal */
        margin-top: 10px; /* Tambahkan jarak atas jika diperlukan */
        margin-bottom: 20px; /* Tambahkan jarak bawah jika diperlukan */
        font-size: 16px; /* Ukuran teks yang lebih proporsional */
        color: #333;
    }

    /* Elemen pseudo untuk dekorasi latar belakang */
    .container::before, .container::after {
        content: "";
        position: absolute;
        background-color: white;
        opacity: 0.2;
        border-radius: 15px;
    }

    .card-header{
      background-color: #ffffff;
      border-bottom: none;
    }

    .container::before {
        width: 300px;
        height: 300px;
        top: -40px;
        left: -300px;
    }

    .container::after {
        width: 300px;
        height: 300px;
        bottom: -40px;
        right: -300px;
    }

    .logo-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 120px;
        margin-bottom: 15px;
    }

    h1 {
        color: #B22222;
        font-weight: bold;
        text-align: center;
        font-size: 55px;
    }

    .form-control {
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 15px;
        font-size: 16px;
    }

    .btn-primary {
        background-color: #B22222;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        padding: 10px 10px;
        width: 250px;
        margin: 75px -200px -10px;
        outline: none;
    }

    .btn-primary:focus, .btn-primary:active {
        outline: none; /* Menghilangkan focus outline biru */
        box-shadow: none; /* Menghilangkan shadow ketika di-klik */
        background-color: #F94F1B; /* Warna tetap oranye */
        transform: translateY(4px); /* Efek timbul ke dalam */
    }

    .btn-primary:hover {
        background-color: #B22222;
    }

    .btn-primary:focus-visible {
        outline: none;
        box-shadow: none;
    }

    .login-text {
        text-align: center;
        font-size: 20px;
        margin-top: 10px;
    }

    .input-group .form-control {
      border-right: none;
    }

    #username {
      border-top-left-radius: 1px !important;
      border-bottom-left-radius: 1px !important;
      border-right: none !important;
    }
    .input-group .form-control {
      border-right: none;
    }
    .input-group-append .input-group-text {
      border-top-right-radius: 1px;
      border-bottom-right-radius: 1px;
      border-left: none;
      background-color: #ffffff;
    }

    .input-group-text {
      border-top-right-radius: 1px;
      border-bottom-right-radius: 1px;
      background-color: #ffffff;
      border-left: none;
    }

    #passwordInput {
      border-top-left-radius: 1px;
      border-bottom-left-radius: 1px;
      border-right: none;
    }

  </style>
</head> 

<body class="hold-transition login-page">
    <div class="container">
        <div class="login-box">
            <div class="card-header text-center">
              <a href="{{ url('/admin/') }}">
                {{-- <img src="{{ asset('logo_biru.png') }}" class="logo" alt="Logo"> --}}
              </a>
              <h1>ARTIKELin!</h1>
            </div>
            <div class="card-body">
              <p class="login-box-msg">Login Sebagai Admin</p>
              <form action="{{ url('/admin/login') }}" method="POST" id="form-login">
                @csrf
                <div class="input-group mb-3">
                  <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                  <small id="error-username" class="text-danger"></small>
                </div>
                <div class="input-group">
                  <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Password" />
                  <span class="input-group-text toggle-password" onclick="togglePassword()">
                    <i class="fa fa-eye" id="toggleIcon"></i>
                  </span>
                  <small id="error-password" class="text-danger"></small>  
                </div>       
                <div class="row">
                  <div class="col-8">
                    <br>
                    <div class="icheck-primary">
                      <input type="checkbox" id="remember">
                      <label for="remember">Ingat Saya</label>
                    </div>
                  </div>
                  <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block"><b>Login</b></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>

<!-- /.login-box -->
<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script>
  function togglePassword() {
    const passwordInput = document.getElementById("passwordInput");
    const toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleIcon.classList.remove("fa-eye");
      toggleIcon.classList.add("fa-eye-slash");
    } else {
      passwordInput.type = "password";
      toggleIcon.classList.remove("fa-eye-slash");
      toggleIcon.classList.add("fa-eye");
    }
  }
</script>

<script> 
  $.ajaxSetup({ 
    headers: { 
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
    } 
  }); 
 
  $(document).ready(function() { 
    $("#form-login").validate({ 
      rules: { 
        username: {required: true, minlength: 4, maxlength: 20}, 
        password: {required: true, minlength: 6, maxlength: 20} 
      }, 
      submitHandler: function(form) { // ketika valid, maka bagian yg akan dijalankan 
        $.ajax({ 
          url: form.action, 
          type: form.method, 
          data: $(form).serialize(), 
          success: function(response) { 
            if(response.status){ // jika sukses 
              Swal.fire({ 
                  icon: 'success', 
                  title: 'Berhasil', 
                  text: response.message, 
              }).then(function() { 
                  window.location = response.redirect; 
              }); 
            }else{ // jika error 
              $('.error-text').text(''); 
              $.each(response.msgField, function(prefix, val) { 
                  $('#error-'+prefix).text(val[0]); 
              }); 
              Swal.fire({ 
                  icon: 'error', 
                  title: 'Terjadi Kesalahan', 
                  text: response.message 
              }); 
            } 
          } 
        }); 
        return false; 
      }, 
      errorElement: 'span', 
      errorPlacement: function (error, element) { 
        error.addClass('invalid-feedback'); 
        element.closest('.input-group').append(error); 
      }, 
      highlight: function (element, errorClass, validClass) { 
        $(element).addClass('is-invalid'); 
      }, 
      unhighlight: function (element, errorClass, validClass) { 
        $(element).removeClass('is-invalid'); 
      } 
    }); 
  }); 
</script>
</body> 
</html> 