@extends('layouts.admin')

@push('scripts')
    <script src="{{ buildUrl('build/js/admin.min.js') }}" defer></script>
    <script src="{{ buildUrl('build/js/admin/moderate/main.js') }}" defer></script>
@endpush
@push('styles')
    <link rel="stylesheet" href="{{ buildUrl('build/css/admin.min.css') }}">
@endpush

@section('content')
    <div class="col-12">
        <div class="row">
            <div class="col-7">
                @include('Admin::moderate.moderate-table', ['images' => $images])
            </div>
            <div class="col-md-5 sidebar">
                <div class="row">
                    <div class="col-12">
                        <div class="row form-group">
                            <?php $columns = 2;
                            $pie = ceil(count($popular) / $columns);
                            $chunkedPopular = array_chunk($popular, $pie);
                            ?>
                            @foreach($chunkedPopular as $popular)
                                <div class="col-6">
                                    @foreach($popular as $tag)
                                        <div class="row popular-tag-container">
                                            <div class="col-8 content popular-tag">{{ $tag }}</div>
                                            <div class="col-2">
                                                <button type="button" class=" btn btn-xs copyToClipboard">
                                                    <span class="fa fa-copy"></span>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-12">
                                @include('Admin::moderate.moderate-panel')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
