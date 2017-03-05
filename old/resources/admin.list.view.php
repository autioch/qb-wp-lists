<a class="qbcol-add" href="?page=<?php echo $this->page ?>&action=add">Dodaj nowy rekord</a>
<table class="qbcol-table-list">
    <thead>
        <tr>
            <?php foreach ($this->listColumns as $key => $value): ?>
                <th><?php echo $value ?></th>
            <?php endforeach; ?>
            <th class="qbcol-w100">Aktywny</th>
            <th class="qbcol-w100">Edytuj</th>
            <th class="qbcol-w100">Usuń</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itemList as $item) : ?>
            <tr>
                <?php foreach ($this->listColumns as $key => $value): ?>
                    <td><?php echo $item->$key ?></td>
                <?php endforeach; ?>     
                <td>
                    <?php echo $item->active ? 'Tak' : '' ?>
                </td>
                <td>
                    <a class="qbcol-edit" title="Edytuj rekord" href="?page=<?php echo $this->page ?>&action=edit&id=<?php echo $item->id ?>"></a>
                </td>
                <td>
                    <?php echo $this->getDeleteLink($item->id) ?>
                    <a class="qbcol-delete" title="Usuń rekord" href="?page=<?php echo $this->page ?>&action=delete&id=<?php echo $item->id ?>"></a>                    
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>