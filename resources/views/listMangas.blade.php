@extends('layouts.master')
@section('content')
    <h1></h1>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Couverture</th>
            <th>titre</th>
            <th>genre</th>
            <th>nom_dessinateur</th>
            <th>nom_scenariste</th>
            <th>prix</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        @foreach($mangas as $manga)
            <tr>
                <td class="col-xs-2"><img class="img-thumbnail" src="{{ url('/assets/images') }}/{{$manga->couverture}}"></td>
                <td>{{$manga->titre}}</td>
                <td>{{$manga->lib_genre}}</td>
                <td>{{$manga->nom_dessinateur}}</td>
                <td>{{$manga->nom_scenariste}}</td>
                <td>{{$manga->prix}}</td>
                <td><a href = "{{ url("/editerManga/".$manga->id_manga) }}">Modiffier</a></td>
                <td>
                    <a onclick="return confirm('Supprimer ce manga ?')"
                       href="{{url('/supprimeManga/'.$manga->id_manga)}}"><i class="bi"></i>Supprimer</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
