<div class="row form-group">
    <label class="col-4 control-label">
        Заголовок
    </label>
    <div class="col-8">
        <input type="text"
               class="form-control"
               placeholder="Заголовок"
               name="title"
               value="{{ !empty($article) ? $article->title : '' }}"
        />
    </div>
</div>
<div class="row form-group">
    <label class="col-4 control-label">
        Описание
    </label>
    <div class="col-8">
        <textarea rows="4" type="text"
                  placeholder="Описание"
                  class="form-control"
                  name="description">{{ !empty($article) ? $article->description : '' }}</textarea>
    </div>
</div>
<div class="row form-group">
    <label class="col-4 control-label">
        Ключевые слова
    </label>
    <div class="col-8">
        <textarea rows="1"
                  placeholder="Ключевые слова"
                  class="form-control"
                  name="key_words">{{ !empty($article) ? $article->key_words : '' }}</textarea>
    </div>
</div>
<div class="row form-group">
    <label class="col-4 control-label">
        Ссылка
    </label>
    <div class="col-7">
        <input type="text"
               class="form-control"
               placeholder="Ссылка"
               name="link"
               value="{{ !empty($article) ? $article->link : '' }}"
        />
    </div>
    <div class="col-1">
        <button type="button" class="btn btn-sm btn-success get-seo-translit">
            translit
        </button>
    </div>
</div>
<div class="row form-group">
    <label class="col-4 control-label">
        Показывать
    </label>
    <div class="col-8">
        <input type="checkbox"
               name="is_show"
               {{ !empty($article->is_show) ? 'checked' : '' }}
        />
    </div>
</div>