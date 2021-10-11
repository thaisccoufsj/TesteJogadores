@extends('layouts.master')
@section('content')
<div class="well">

   @extends('dialogos')

    {!! Form::open(['url' => route('registrar_jogador') , 'class' => 'form-horizontal']) !!}
    @csrf
    <fieldset>

        <legend>Adicionar Jogador</legend>

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
            </div>
        </div>

    </fieldset>

    {!! Form::close()  !!}

</div>