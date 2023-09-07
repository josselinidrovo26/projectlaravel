<div id="changePasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id="changePasswordForm" action="{{ route('cambiar-contrasena') }}">
                @csrf

                <div class="modal-body">
                    @if (session('password_changed'))
            <div class="alert alert-success">
                Contraseña cambiada con éxito.
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Contraseña actual:</label><span class="required confirm-pwd">*</span>
                            <div class="toggle-password">
                                <input class="form-control password-input" id="pfCurrentPassword" type="password"
                                       name="password_current" required>
                                       <span class="eye-icon">
                                        <i class="far fa-eye"></i>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Nueva contraseña:</label><span class="required confirm-pwd">*</span>
                            <div class="toggle-password">
                                <input class="form-control password-input" id="pfNewPassword" type="password"
                                       name="password" required>
                                       <span class="eye-icon">
                                        <i class="far fa-eye"></i>
                                    </span>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Confirmar contraseña:</label><span class="required confirm-pwd">*</span>
                            <div class="toggle-password">
                                <input class="form-control password-input" id="pfNewConfirmPassword" type="password"
                                       name="password_confirmation" required>
                                       <span class="eye-icon">
                                        <i class="far fa-eye"></i>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary" id="btnPrPasswordEditSave"
                                data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing...">
                            Guardar
                        </button>
                        <button type="button" class="btn btn-light ml-1" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
{{--   <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script> --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('.eye-icon').on('click', function () {
            const passwordInput = $(this).siblings('.password-input');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
    });
</script>


<style>
    .toggle-password {
        cursor: pointer;
        position: relative;
    }
    .toggle-password .eye-icon {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
    }

</style>
