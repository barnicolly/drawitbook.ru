<div class="mon-place {{ $isDummy ? 'dummy': '' }}"
     data-loaded="false"
     data-integrated="{{ $integratedText }}"
     data-configuration-key="{{ $configurationKey }}"
     id="{{ $id }}">
    <?= $isDummy ? $id: '' ?>
</div>
