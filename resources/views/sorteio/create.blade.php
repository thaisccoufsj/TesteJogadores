@include('layouts.master')
@section('content')
<div class="well">

    @include('dialogos')
    
    {!! Form::open(['url' => route('registrar_sorteio') , 'class' => 'form-horizontal','method' => 'POST']) !!}
    @csrf
    <fieldset>
        <legend>Adicionar Sorteio</legend>
        <div class="form-group">
            {!! Form::label('id', 'Id:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::text('id', @$Sorteio->id, ['class' => 'form-control', 'style' => 'background-color: rgb(221,221,221)' ,'disabled' => true]) !!}
            </div>
            {!! Form::label('data_jogo', 'Data:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::text('data_jogo', @$Sorteio->data_jogo, ['class' => 'form-control','readonly' => true, 'style' => 'cursor : pointer !important;background-color:#FFF']) !!}
            </div>
             {!! Form::label('hora_jogo', 'Hora:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::text('hora_jogo', @$Sorteio->hora_jogo, ['class' => 'form-control', 'style' => 'cursor : pointer !important;background-color:#FFF']) !!}
            </div>

              {!! Form::label('total_jogadores', 'Jogadores por time:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::number('total_jogadores', @$Sorteio->total_jogadores, ['class' => 'form-control']) !!}
            </div>
        </div>

        <legend>Jogadores confirmados</legend>
        <div class="form-group container">
            
            @foreach($Jogadores as $Jogador)
                <label class = "checkbox-inline">
                    <input name="jogador[]" type = "checkbox" value = "{{$Jogador->id}}" 
                    @if(isset($Jogadores_Selecionados[$Jogador->id]))
                        checked
                    @endif
                    >{{ $Jogador->nome . ($Jogador->goleiro ? " (goleiro)" : "")}}
                </label>
            @endforeach
        </div>

        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                {!! Form::submit('Salvar', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
            </div>
        </div>

    </fieldset>

    {!! Form::close()  !!}

</div>
<script>
    $(document).ready(function(){
        $("#data_jogo").datepicker({
            dateFormat: 'dd/mm/yy',
        });
        $("#hora_jogo").bootstrapMaterialDatePicker({ 
            date: false ,
            shortTime: false,
			format: 'HH:mm'
        }); 
    });

    $('#total_jogadores').keyup(function(e){
        $('#total_jogadores').val($('#total_jogadores').val().replace(/[^0-9]/,""));
    });

</script>