@if(isset($erro))
    <div class="alert alert-danger" role="alert" >
        {{$erro }}
    </div>
@endif

@if(isset($aviso))
    <div class="alert alert-primary" role="alert">
        {{$aviso }}
    </div>
@endif

@if(isset($sucesso))
    <div class="alert alert-success" role="alert">
        {{$sucesso}}
    </div>
@endif

@if(isset($mensagem))
    <div class="alert alert-primary" role="alert">
        {{$mensagem}}
    </div>
@endif