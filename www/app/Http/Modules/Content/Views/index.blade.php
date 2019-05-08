@extends('layouts.base')

@section('content')
    <div class="row form-group">
        <div class="col-12" ><div style="height: 200px; background-color: black"></div></div>
    </div>
    <div class="row">
        <div class="col-12">
            @include('Content::template.stack_grid', ['pictures' => $pictures, 'showAllTags' => true])
        </div>
    </div>
@endsection




