@extends('layouts.master')

<div class="well">
    <legend>Jogadores</legend>
    {!! Form::button('Inicio', ['class' => 'btn btn-lg btn-info ','style' => 'margin-right: 10px;','onclick' => "javascript:window.location.href = '/'"] ) !!}
    {!! Form::button('Novo', ['class' => 'btn btn-lg btn-success ','style' => 'margin-right: 10px;','onclick' => "javascript:window.location.href = '/jogador/novo'"] ) !!}
   @include('dialogos')

    @section('content')

        @if (count($jogadores) > 0)
            <table class="table table-striped table-hover table-bordered ">  

                <!-- Table Headings -->
                <thead class="thead-dark">
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Nível</th>
                    <th scope="col">Goleiro ?</th>
                    <th scope="col">Ações</th>
                </thead>

                <!-- Table Body -->
                <tbody>

                @foreach($jogadores as $jogador)
                    <tr>
                        <th scope="row">{{$jogador->id}}</th>
                        <td>{{$jogador->nome}}</td>
                        <td>{{$jogador->nivel}}</td>
                        <td>{{$jogador->goleiro == 1 ? "Sim" : "Não" }}</td>
                        <td>
                            <button type="button" class="btn btn-info" onclick="window.location.href='/jogador/editar/{{$jogador->id}}'">Editar</button>
                            <button type="button" class="btn btn-danger" onclick="excluir('{{$jogador->id}}')">Excluir</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
       
            
        @endif

        <form id='form_delete' style='display:none' method='POST'>
            @csrf
            @method('DELETE')
            <input type='text' id='id'>
        </form>
    @endsection
</div>

<script>
    function excluir(id){
        if(confirm("Tem certeza que deseja excluir esse jogador?")){
            $('#id').val(id);
            $('#form_delete').attr('action','/jogador/excluir/' + id);
            $('#form_delete').submit();
        }
    }
</script>