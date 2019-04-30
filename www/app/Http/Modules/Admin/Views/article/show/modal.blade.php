<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Создание записи</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="articlePictureModal">
                    <input type="hidden" name="id" value="{{ !empty($relation) ? $relation->id : 0 }}">
                    <div class="row form-group">
                        <label class="col-4 control-label">
                            Заголовок
                        </label>
                        <div class="col-8">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Заголовок"
                                   name="caption"
                                   value="{{ !empty($relation) ? $relation->caption : '' }}"
                            />
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-4 control-label">
                            Порядок сортировки
                        </label>
                        <div class="col-8">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Порядок сортировки"
                                   name="sort_id"
                                   value="{{ !empty($relation) ? $relation->sort_id : 1 }}"
                            />
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-4 control-label">
                            Идентификатор изображения
                        </label>
                        <div class="col-8">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Идентификатор изображения"
                                   name="picture_id"
                                   value="{{ !empty($relation) ? $relation->picture_id : '' }}"
                            />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success save-modal-button">Сохранить</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>