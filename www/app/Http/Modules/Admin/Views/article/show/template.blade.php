<div class="row">
    <div class="col-12">
          <textarea rows="4" type="text"
                    placeholder="Шаблон"
                    class="form-control"
                    name="template">{{ !empty($article) ? $article->template : '' }}</textarea>
    </div>
</div>