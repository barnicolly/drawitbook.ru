<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Редактирование изображения</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-12 form-group">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="main-tab"
                               data-toggle="tab" href="#main" role="tab" aria-controls="main"
                               aria-selected="true">Основная информация
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="integrate-vk-tab" data-toggle="tab" href="#integrate-vk" role="tab"
                               aria-controls="integrate-vk"
                               aria-selected="false">Интеграция ВК
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-12">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="main" role="tabpanel" aria-labelledby="main-tab">
                            <div class="col-12">
                                123
                            </div>
                        </div>
                        <div class="tab-pane fade" id="integrate-vk" role="tabpanel" aria-labelledby="integrate-vk-tab">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>vk_id</th>
                                        <th>Описание</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vkAlbums as $vkAlbum)
                                        <tr data-vk-album-id="{{ $vkAlbum->id }}">
                                            <td>{{ $vkAlbum->id }}</td>
                                            <td>{{ $vkAlbum->album_id }}</td>
                                            <td>{{ $vkAlbum->description }}</td>
                                            <td>
                                                <button type="button" class="btn btn-link add-to-vk-album">
                                                    Добавить в альбом
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>