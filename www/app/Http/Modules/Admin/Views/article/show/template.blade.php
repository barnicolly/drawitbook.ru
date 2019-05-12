<div class="row">
    <div class="col-12">
    <span>
        $artList$
    </span>
    </div>
    <div class="col-12">
          <textarea rows="20" type="text"
                    id="template-editor"
                    placeholder="Шаблон"
                    class="form-control">{{ !empty($article) ? $article->template : '' }}</textarea>
    </div>
</div>