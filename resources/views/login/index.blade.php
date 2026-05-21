@extends('layouts.layout')

@section('title', 'Login')

@section('css')
<style>
    .main {
        padding: unset;
        background: #fff;
    }
    .col-form-label{
        min-width: 105px;
    }
    .login-group{
        border: 1px solid #00175a;
    }
    .login-title{
        font-size: 35px;
        color:#00175a;
        text-transform: uppercase;
    }
    #msg_error{
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9375rem;
        color: #dc2626;
        text-align: center;
        line-height: 1.4;
    }
    #msg_error:not(:empty) {
        min-height: 1.25rem;
    }
    .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
        }
        .logo-gradient {
            background: linear-gradient(135deg, #00a83b, #006e25);
        }
        body {
            background-color: #f5f5f5;
        }
    /* Nút hiện/ẩn: full chiều cao ô, icon giữa dọc + sát phải (không còn khoảng trống lớn do căn giữa vùng vuông) */
    .login-password-field {
        position: relative;
    }
    #togglePassword {
        position: absolute;
        top: 0.375rem;
        right: 0;
        bottom: 0;
        width: 2.25rem;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 0 0.375rem 0 0.125rem;
        margin: 0;
        border: 0;
        background: transparent;
        cursor: pointer;
        color: #64748b;
        border-radius: 0 0.375rem 0.375rem 0;
        z-index: 10;
        line-height: 0;
        box-sizing: border-box;
    }
    #togglePassword .material-symbols-outlined,
    #togglePassword #eyeIcon {
        font-size: 22px !important;
        line-height: 1 !important;
        width: 22px;
        height: 22px;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        user-select: none;
    }
</style>
@endsection

@section('content')
<!-- Main Content Area -->
<main class="flex-grow flex justify-center items-center" style="min-height: 100vh;">
  <div class="flex flex-col items-center">
    <!-- SONXI Logo Above Card -->
    <div class="mb-6 flex flex-col items-center"><img alt="SONXI Logo" class="h-auto object-contain mb-4 shadow-none w-64" src="{{ asset('/images/sonxi.png') }}"/></div>
    <!-- Login Card -->
    <div class="w-[480px] bg-white border border-slate-200 rounded-sm shadow-sm p-12">
      <h2 class="text-[#0056b3] font-headline text-xl font-bold text-center mb-10 uppercase tracking-wide">ĐĂNG NHẬP</h2>
      <form class="space-y-6">
        <!-- Employee ID Field -->
        <div class="space-y-2">
          <label class="block text-sm font-semibold text-slate-700" for="login_id">Mã nhân viên</label>
          <input class="w-full h-11 px-3.5 bg-white border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500/30 focus:border-[#0056b3] transition-colors outline-none text-base text-slate-900 placeholder:text-slate-400" id="login_id" name="login_id" type="text" autocomplete="username"/>
        </div>
        <!-- Password Field -->
        <div class="space-y-2">
          <label class="block text-sm font-semibold text-slate-700" for="password">Mật khẩu</label>
          <div class="relative login-password-field">
            <input class="w-full h-11 pl-3.5 pr-9 bg-white border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500/30 focus:border-[#0056b3] transition-colors outline-none text-base text-slate-900 placeholder:text-slate-400" id="password" name="password" placeholder="••••••••" type="password" autocomplete="current-password"/>
            <button id="togglePassword" type="button" aria-label="Hiện hoặc ẩn mật khẩu">
              <span id="eyeIcon" class="material-symbols-outlined">visibility_off</span>
            </button>
          </div>
          <span class="text-danger err-msg"></span>
        </div>
        <span class="text-danger mb-3" id="msg_error"></span>
        <!-- Login Button -->
        <div class="pt-4 flex justify-center">
          <a class="w-2/3 min-h-11 py-2.5 px-4 bg-[#0056b3] text-white text-sm font-semibold rounded-md hover:bg-[#004491] active:scale-[0.98] transition-all duration-200" style="display:flex; justify-content:center; align-items:center; cursor:pointer" onclick="login()">
            Đăng nhập
          </a>
        </div>
      </form>
    </div>
  </div>
</main>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            const emailInput = $('#email');
            const passwordInput = $('#password');
            const loginButton = $('#loginButton');

            $('#login_id, #password').on('keydown', function (event) {
                if (event.key === 'Enter') {
                    login();
                }
            });

            // warning caps lock
            passwordInput.on('keyup', function(e) {
                var capsLockActivated = e.originalEvent.getModifierState('CapsLock');
                if (capsLockActivated) {
                    $('#msg_error').html(`<i class='bx bxs-error text-warning me-2'></i>Caps Lock is on`)
                    $('#msg_error').css('opacity', 1);
                } else {
                    $('#msg_error').html('')
                    $('#msg_error').css('opacity', 0);
                }
            });

            loginButton.on('click', function () {
                login();
            });
        });

        function loginVali() {
            let loginId = $('#login_id');
            let password = $('#password');
            let isVali = true
    
            let errMsg = $('#msg_error');
            if (errMsg) {
                $('#msg_error').css('opacity', 0);
                errMsg.html('')
            }
            
            // check required
            if (loginId.val() == "" || password.val() == "") {
                isVali = false
                if (errMsg) {
                    $('#msg_error').css('opacity', 1);
                    errMsg.html(msgComon.E0007)
                }
            }
            
            // check valid email
            // if (isVali == true) {
            //     const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            //     if (!emailRegex.test(email.val())) {
            //         isVali = false
            //         if (errMsg) {
            //             $('#msg_error').css('opacity', 1);
            //             errMsg.html(msgComon.E0002)
            //         }
            //     }
            // }

            return isVali
        }
    
        function login() {
            if (!loginVali()) {
                return
            }
            loadStart();
            let login_id = $('#login_id').val();
            let password = $('#password').val();
            var loginUrl = "{{ route('login.submit') }}";
            $.ajax({
                method: "POST",
                url: loginUrl,
                data: {
                    login_id: login_id, 
                    password: password
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    if(response.success){
                        window.location.href = '{{ route('dashboard.index') }}';
                    }
                },
                error: (e) => {
                    let msg = msgComon.E0000;
                    if (e.responseJSON && e.responseJSON.message) {
                        msg = e.responseJSON.message;
                    }
                    $('#msg_error').html(msg);
                    $('#msg_error').css({ opacity: 1, color: '#dc2626' });
                }
            }).always(function() {
                loadEnd();
            });//end ajax
        }

        function loadStart() {
            $("#loading").removeAttr("hidden");
        }

        function loadEnd() {
            $("#loading").attr("hidden", "hidden");
        }
        $('#togglePassword').on('click', function () {
            const input = $('#password');
            const icon = $('#eyeIcon');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.text('visibility');
            } else {
                input.attr('type', 'password');
                icon.text('visibility_off');
            }
        });
    </script>
@endsection
