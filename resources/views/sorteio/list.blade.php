@extends('layouts.master')

<div class="well">
    <legend>Sorteios</legend>
    {!! Form::button('Sorteio +', ['class' => 'btn btn-lg btn-success ','style' => 'margin-right: 10px;','onclick' => "javascript:window.location.href = '/sorteio/novo'"] ) !!}
    {!! Form::button('Jogadores', ['class' => 'btn btn-lg btn-info ','style' => 'margin-right: 10px;','onclick' => "javascript:window.location.href = '/jogador'"] ) !!}
    @include('dialogos')
    @include('DataHora')
    @section('content')

        @if (count($Sorteios) > 0)
            <table class="table table-striped table-hover table-bordered ">  

                <!-- Table Headings -->
                <thead class="thead-dark">
                    <th scope="col">#</th>
                    <th scope="col">Total jogadores</th>
                    <th scope="col">Total times</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Ações</th>
                </thead>

                <!-- Table Body -->
                <tbody>

                @foreach($Sorteios as $Sorteio)
                    <tr>
                        <th scope="row">{{$Sorteio->id}}</th>
                        <td>{{$Sorteio->total_jogadores}}</td>
                        <td>{{$Sorteio->total_times}}</td>
                        <td>{{DataUS2BR($Sorteio->data_jogo) }}</td>
                        <td>{{$Sorteio->hora_jogo }}</td>
                        <td>
                            <button type="button" class="btn btn-info" onclick="window.location.href='/sorteio/editar/{{$Sorteio->id}}'">Editar</button>
                            <button type="button" class="btn btn-danger" onclick="excluir('{{$Sorteio->id}}')">Excluir</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h1>Nenhum sorteio cadastrado ainda.</h1>
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
        if(confirm("Tem certeza que deseja excluir esse sorteio e todos seus dados?")){
            $('#id').val(id);
            $('#form_delete').attr('action','/sorteio/excluir/' + id);
            $('#form_delete').submit();
        }
    }
</script>