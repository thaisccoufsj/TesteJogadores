@include('layouts.master')
@section('content')
<div class="well">

    @include('dialogos')
    
    {!! Form::open(['url' => "/sorteio/editar/$Sorteio->id" , 'class' => 'form-horizontal','method' => 'POST','id'=>'formulario']) !!}
    @csrf
    @method('PATCH')
    <fieldset>
        <legend>Editar Sorteio</legend>
        <div class="form-group">
            {!! Form::label('id', 'Id:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::text('id', @$Sorteio->id, ['class' => 'form-control', 'style' => 'background-color: rgb(221,221,221)' ,'disabled' => true]) !!}
            </div>
            {!! Form::label('data_jogo', 'Data:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::text('data_jogo', DataUS2BR(@$Sorteio->data_jogo), ['class' => 'form-control','readonly' => true, 'style' => 'cursor : pointer !important;background-color:#FFF']) !!}
            </div>
             {!! Form::label('hora_jogo', 'Hora:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::text('hora_jogo', substr(@$Sorteio->hora_jogo,0,5), ['class' => 'form-control', 'style' => 'cursor : pointer !important;background-color:#FFF']) !!}
            </div>

              {!! Form::label('total_jogadores', 'Jogadores por time:', ['class' => 'col-lg-1 control-label']) !!}
            <div class="col-lg-1">
                {!! Form::number('total_jogadores', @$Sorteio->total_jogadores, ['class' => 'form-control']) !!}
            </div>
        </div>

        <legend>Jogadores</legend>
        
            
       
            @foreach($Times as $idTime=>$Time)
               <div  style='border:1px solid #B0B0B0;margin:5px;padding:5px;border-radius:5px;'>
                <span style='font-size:15px;font-weight:bold;'>Time {{$idTime + 1}} | Força : {{$Time->forca}} </span><br>
                @foreach($Time->jogadores as $Jogador)
                    <label class = "checkbox-inline">
                        <input name="jogador[]" type="checkbox" value="{{$Jogador->id}}" checked> {{ $Jogador->nome . ($Jogador->goleiro ? " (goleiro)" : "")}}
                    </label>
                @endforeach
                </div>
            @endforeach

           <div  style='border:1px solid #B0B0B0;margin:5px;padding:5px;border-radius:5px;'>
                 <span style='font-size:15px;font-weight:bold;'>Jogadores não confirmados</span><br>
                @foreach($Jogadores as $Jogador)
                    @if(array_search($Jogador,$Jogadores_Selecionados) === FALSE)
                         <label class = "checkbox-inline">
                            <input name="jogador[]" type="checkbox" value="{{$Jogador->id}}"> {{ $Jogador->nome . ($Jogador->goleiro ? " (goleiro)" : "")}}
                        </label>
                    @endif
                @endforeach
            </div>

       

       <div class="form-group">
            <div class="col-lg-12 ">
                {!! Form::submit('Salvar', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
                {!! Form::button('Excluir', ['class' => 'btn btn-lg btn-danger pull-right','style' => 'margin-right: 10px;','onclick' => 'javascript:excluir()'] ) !!}
                {!! Form::button('Novo', ['class' => 'btn btn-lg btn-success pull-right','style' => 'margin-right: 10px;','onclick' => 'javascript:adicionar()'] ) !!}
                {!! Form::button('Voltar para listagem', ['class' => 'btn btn-lg btn-primary pull-left','onclick' => "window.location.href='/'"] ) !!}
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

    function excluir(){
        if(confirm('Tem certeza que deseja excluir esse sorteio?')){
           $('#formulario').attr('action','/sorteio/excluir/' + $('#id').val());
           $("[name='_method']").val('DELETE');
           $('#formulario').submit();
        }
    }

    function adicionar(){
        window.location.href = '/sorteio/novo';
    }

</script>