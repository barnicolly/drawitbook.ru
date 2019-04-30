@extends('layouts.admin')

@push('scripts')
    <script src="{{ buildUrl('build/plugins/ckeditor/ckeditor.js') }}" defer></script>
    <script src="{{ buildUrl('build/js/admin/article/show.js') }}" defer></script>
@endpush

@section('content')
    <div class="container">
        <div class="col-12 ">
            <h4>
                {{ !empty($article) ? 'Редактирование': 'Создание' }}
            </h4>
        </div>
        <div class="col-12 form-group">
            <button type="button" class="btn btn-sm btn-success save-article">
                Сохранить
            </button>
            <a class="btn btn-sm btn-link back-article-list" href="{{ route('show_articles') }}">
                К списку статей
            </a>
            <button type="button" class="btn btn-sm btn-link preview-article" {{ empty($article) ? 'disabled': '' }}>
                Предпросмотр
            </button>
        </div>
        <div class="col-12 form-group">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="metadata-tab"
                       data-toggle="tab" href="#metadata" role="tab" aria-controls="metadata"
                       aria-selected="true">Метаданные
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="template-tab" data-toggle="tab" href="#template" role="tab"
                       aria-controls="template"
                       aria-selected="false">Шаблон
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pictures-tab" data-toggle="tab" href="#pictures" role="tab"
                       aria-controls="pictures"
                       aria-selected="false">Изображения <span
                                class="count-pictures badge badge-secondary"><?= !empty($article) ? $article->pictures->count() : '' ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <form id="saveArticle" class="col-12">
            <input type="hidden" name="id" value="{{ !empty($article) ? $article->id: 0 }}">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="metadata" role="tabpanel" aria-labelledby="metadata-tab">
                    <div class="col-12">
                        @include('Admin::article.show.meta', ['article' => !empty($article) ? $article : []])
                    </div>
                </div>
                <div class="tab-pane fade" id="template" role="tabpanel" aria-labelledby="template-tab">
                    <div class="col-12">
                        Шаблон
                    </div>
                    <div class="col-12">
                        @include('Admin::article.show.template', ['article' => !empty($article) ? $article : []])
                    </div>
                </div>
                <div class="tab-pane fade" id="pictures" role="tabpanel" aria-labelledby="pictures-tab">
                    <div class="col-12">
                        @include('Admin::article.show.pictures.index', ['article' => !empty($article) ? $article : []])
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection