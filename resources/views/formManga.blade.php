@extends("layouts.master")

@section('content')
    <form method="POST" action="{{ route('validManga') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <h1> </h1>
        <div class="col-md-12 card card-body bg-light">
            <div class="form-group">
                <label class="col-md-3">Titre : </label>
                <div class="col-md-6">
                    <input type="text" name="titre" value="{{$manga->titre}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="col-md-3">identifiant: </label>
                    <div class="col-md-6">
                        <input type="hidden" name="id" value="{{ $manga->id_manga }}">
                        <br>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Genre : </label>
                <div class="col-md-6">
                    <select class="form-select" @error('Genre') border-danger @enderror name="Genre">
                        <option value="" disabled>Sélectionner un genre</option>
                        @foreach($genres as $genre)
                            <option value="{{$genre->id_genre}}" @if ($manga->id_genre == $genre->id_genre) selected @endif>
                                {{$genre->lib_genre}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Dessinateur : </label>
                <div class="col-md-6">
                    <select class="form-select" @error('Dessinateur') border-danger @enderror name="Dessinateur">
                        <option value="" disabled selected>Sélectionner un Dessinateur</option>
                        @foreach($dessinateurs as $dessinateur)
                            <option value="{{$dessinateur->id_dessinateur}}" @if ($manga->id_dessinateur == $dessinateur->id_dessinateur) selected @endif>
                                {{$dessinateur->nom_dessinateur ." ". $dessinateur->prenom_dessinateur}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Scenariste : </label>
                <div class="col-md-6">
                    <select class="form-select" @error('Scenariste') border-danger @enderror name="Scenariste">
                        <option value="" disabled selected>Sélectionner un Scenariste</option>
                        @foreach($scenaristes as $scenariste)
                            <option value="{{$scenariste->id_scenariste}}" @if ($manga->id_scenariste == $scenariste->id_scenariste) selected @endif>
                                {{$scenariste->nom_scenariste." ".$dessinateur->prenom_scenariste}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3">Prix : </label>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="prix" value="{{$manga->prix}}" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Couverture</label>
                <div class="col-md-6">
                    <input type="hidden" name="MAX_FILE_SIZE" value="204800">
                    <input type="file" accept="image/*" name="couv" class="form-control">
                </div>
            </div>

            <hr>
            <div class="form-group">
                <div class="col-md-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        Valider
                    </button>
                    <button type="button" class="btn btn-secondary"
                            onclick="if (confirm('Annuler la saisie ?')) window.location='{{ url('/listerMangas') }}'; ">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
