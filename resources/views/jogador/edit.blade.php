@extends('layouts.master')
@section('content')
<div class="well">

   @include('dialogos')

    {!! Form::open(['url' => route('alterar_jogador',['id' => $Jogador->id]) , 'class' => 'form-horizontal','id'=>'formulario']) !!}
    @csrf
    <fieldset>

        <legend>Visualizar Jogador</legend>

        <!-- Id e nome -->
        <div class="form-group">
            {!! Form::label('id', 'Id:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::text('id', @$Jogador->id, ['class' => 'form-control', 'style' => 'background-color: rgb(221,221,221)' ,'disabled' => true]) !!}
            </div>
            {!! Form::label('nome', 'Nome:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-5">
                {!! Form::text('nome', @$Jogador->nome, ['class' => 'form-control']) !!}
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('nivel', 'Nível:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-10">
                 <div class="radio">
                    {!! Form::label('nivel', '1') !!}
                    {!! Form::radio('nivel', '1', @$Jogador->nivel == 1 ? true : false ) !!}

                </div>
                <div class="radio">
                    {!! Form::label('nivel', '2') !!}
                    {!! Form::radio('nivel', '2', @$Jogador->nivel == 2 ? true : false ) !!}
                </div>
                 <div class="radio">
                    {!! Form::label('nivel', '3') !!}
                    {!! Form::radio('nivel', '3', @$Jogador->nivel == 3 ? true : false ) !!}

                </div>
                <div class="radio">
                    {!! Form::label('nivel', '4') !!}
                    {!! Form::radio('nivel', '4', @$Jogador->nivel == 4 ? true : false ) !!}
                </div>
                 <div class="radio">
                    {!! Form::label('nivel', '5') !!}
                    {!! Form::radio('nivel', '5', @$Jogador->nivel == 5 ? true : false ) !!}

                </div>

            </div>
        </div>

        <div class="form-group">
            {!! Form::label('goleiro', 'É goleiro?', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::checkbox('goleiro', 'goleiro', @$Jogador->goleiro == true ? true : false) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                {!! Form::submit('Salvar', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
                {!! Form::button('Novo', ['class' => 'btn btn-lg btn-success pull-right','style' => 'margin-right: 10px;','onclick' => 'javascript:adicionar()'] ) !!}
                {!! Form::button('Excluir', ['class' => 'btn btn-lg btn-danger pull-right','style' => 'margin-right: 10px;','onclick' => 'javascript:excluir()'] ) !!}
                {!! Form::button('Voltar para listagem', ['class' => 'btn btn-lg btn-primary pull-left','onclick' => "window.location.href='/jogador'"] ) !!}
            </div>
        </div>

    </fieldset>

    {!! Form::close()  !!}

</div>

<script>

    function excluir(){

        if(confirm('Tem certeza que deseja excluir esse jogador?')){
           $('#formulario').attr('action','/jogador/excluir/' + $('#id').val());
           $('#formulario').prepend("<input type='hidden' name='_method' value='delete' />");
           $('#formulario').submit();
        }

    }

    function adicionar(){
        window.location.href = '/jogador/novo';
    }

</script>