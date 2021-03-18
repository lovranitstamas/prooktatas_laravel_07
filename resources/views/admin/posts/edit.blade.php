@extends('admin.layout.admin-layout')

@section('content')

    <h4>Poszt szerkesztése</h4>

    @if(session()->has('message'))
        <h3>{{session('message')}}</h3>
    @else
        <form action="{{route('admin.posts.update', $note->id)}}"
              method="POST"
              enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            @csrf

            <div class="form-group">
                Tartalom:
                <textarea cols="10" rows="15" name="content"
                          class="form-control">{{old('content') ?: $note->content}}</textarea>
                @if($errors->first('content'))
                    <p style="color:red">
                        {{$errors->first('content')}}
                    </p>
                @endif
            </div>

            <div class="form-group">
                Publikálás dátuma:
                @if ($note->public_at)
                    <input type="date" name="public_at"
                           value="{{old('public_at')?: $note->removeTime($note->public_at)}}">
                @else
                    <input type="date" name="public_at"
                           value="{{old('public_at')}}">
                @endif
            </div>

            <div class="form-group">
                Címkék:
                <br>
                <select name="tags[]" multiple>
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}" {{$note->hasTag($tag->id)? 'selected': ''}}
                        >{{$tag->name}}</option>
                    @endforeach
                </select>
            </div>

            {{--in_array($tag->id, old('tags', []))--}}

            <div class="form-group {{$errors->first('attachment') ? 'has-error': ''}}">
                <label for="exampleInputFile">Kép kiválasztása</label>
                <input type="file" name="attachment" id="exampleInputFile">

                @if($errors->first('attachment'))
                    <span class="help-block text-danger">{{$errors->first('attachment')}}</span>
                @endif
            </div>

            <div class="form-group">
                <input type="submit" value="Modosítás" class="btn btn-primary">
            </div>

        </form>
    @endif
@stop
