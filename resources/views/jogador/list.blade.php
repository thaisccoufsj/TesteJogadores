@extends('layouts.master')

<div class="well">
    <legend>Jogadores</legend>
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
                </thead>

                <!-- Table Body -->
                <tbody>

                @foreach($jogadores as $jogador)
                    <tr>
                        <th scope="row">{{$jogador->id}}</th>
                        <td>{{$jogador->nome}}</td>
                        <td>{{$jogador->nivel}}</td>
                        <td>{{$jogador->goleiro == 1 ? "Sim" : "Não" }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
       
            
        @endif

    @endsection
</div>
