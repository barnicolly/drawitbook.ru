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
                            <a class="nav-link active" id="integrate-vk-tab" data-toggle="tab" href="#integrate-vk"
                               role="tab"
                               aria-controls="integrate-vk"
                               aria-selected="true">Интеграция ВК
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-12">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane show active" id="integrate-vk" role="tabpanel"
                             aria-labelledby="integrate-vk-tab">
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
                                        <tr data-vk-album-id="{{ $vkAlbum['id'] }}">
                                            <td>{{ $vkAlbum['id'] }}</td>
                                            <td>{{ $vkAlbum['album_id'] }}</td>
                                            <td>{{ $vkAlbum['description'] }}</td>
                                            <td>
                                                @if ($issetInVkAlbums && in_array($vkAlbum['id'], $issetInVkAlbums, true))
                                                    <button type="button" class="btn btn-link remove-from-vk-album">
                                                        Убрать из альбома
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-link add-to-vk-album">
                                                        Добавить в альбом
                                                    </button>
                                                @endif
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
