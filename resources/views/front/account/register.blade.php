@extends('front.layout.app')
@section('main_Shop')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Register</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">    
                <form action="" id="userForm" method="post">
                    <h4 class="modal-title">Register Now</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="password_confirmation" id="confirmPassword" name="password_confirmation">
                    </div>
                    <div class="form-group small">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div> 
                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form>			
                <div class="text-center small">Already have an account? <a href="login.php">Login Now</a></div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('add_scriptJs')
<script>
    // Função executada quando o formulário com o ID "userForm" é enviado
    $("#userForm").submit(function(event) {
        // Impede o envio padrão do formulário
        event.preventDefault();
        $("button[type=submit]").prop('disabled', true)
        // Captura o elemento do formulário
        var element = $(this);

        // Requisição AJAX para enviar os dados do formulário para a rota 'categories.store'
        $.ajax({
            url: '{{ route('account.processRegister') }}',
            type: 'post',
            data: element.serializeArray(), // Serializa os dados do formulário
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false)
                // Verifica se a resposta indica sucesso
                if (response['status'] == true) {
                    window.location.href = "{{ route('account.login') }}"
                    // Remove quaisquer classes de validação e mensagens de erro para o campo 'name'
                    $("#name").removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html("");
                    // Remove quaisquer classes de validação e mensagens de erro para o campo 'email'
                    $("#email").removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html("");
                         // Remove quaisquer classes de validação e mensagens de erro para o campo 'password'
                    $("#password").removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html("");
                } else {
                    // Caso haja erros na resposta, captura os erros
                    var errors = response['errors'];
                    // Verifica se há erro no campo 'name'
                    if (errors['name']) {
                        // Adiciona classe de erro e exibe a mensagem de erro para o campo 'name'
                        $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                            .html(errors['name']);
                    } else {
                        // Remove classes de erro e mensagem de erro para o campo 'name'
                        $("#name").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                    }

                    // Verifica se há erro no campo 'email'
                    if (errors['email']) {
                        // Adiciona classe de erro e exibe a mensagem de erro para o campo 'email'
                        $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                            .html(errors['email']);
                    } else {
                        // Remove classes de erro e mensagem de erro para o campo 'email'
                        $("#email").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                    }
                     // Verifica se há erro no campo 'password'
                     if (errors['password']) {
                        // Adiciona classe de erro e exibe a mensagem de erro para o campo 'password'
                        $("#password").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                            .html(errors['password']);
                    } else {
                        // Remove classes de erro e mensagem de erro para o campo 'password'
                        $("password").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                    }
                }
            },
            error: function(jqXHR, exception) {
                // Se ocorrer um erro na requisição, exibe uma mensagem de erro no console
                console.log("something went wrong");
            }
        });
    });

</script>
    
@endsection