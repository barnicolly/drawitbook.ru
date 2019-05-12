<div>
    На модерации ост.: {{ $countNonModeratedRecords - $images->count()}}
</div>
<div>
    <div class="d-inline">
        <button type="button" class="btn btn-info btn-sm refresh-page">Обновить страницу</button>
    </div>
    <div class="d-inline">
        <button type="button" class="btn btn-info btn-sm select-all">Выделить все</button>
    </div>
</div>
<div>
    <div class="operation-with-selected" style="display: none">
        <button type="button" class="btn btn-danger btn-sm delete-selected">Удалить выбранные</button>
    </div>
    <div class="operation-with-selected" style="display: none">
        <button type="button" class="btn btn-default btn-sm unselect-all">Снять выделение</button>
    </div>
</div>
