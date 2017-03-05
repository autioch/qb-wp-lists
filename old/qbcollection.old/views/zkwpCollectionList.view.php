<h3 class="zkwp-tools-title">
    <?php echo $this->title, ' (', $this->db->num_rows, ') ' ?>
</h3>
<?php echo $this->showMessages() ?>
<a class="zkwp-tools-add" href="?page=<?php echo $this->page ?>&action=add">
    <span class="icon-icon-add" style="font-weight:normal"></span>
    Dodaj nowy rekord
</a>
<table class="zkwp-tools-table-list">
    <thead>
        <tr>
            <?php foreach ($this->listColumns as $key => $value): ?>
                <th><?php echo $value ?></th>
            <?php endforeach; ?>
            <th class="zkwp-table-col100">Aktywny</th>
            <th class="zkwp-table-col100">Edytuj</th>
            <th class="zkwp-table-col100">Usuń</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itemList as $item) : ?>
            <tr>
                <?php foreach ($this->listColumns as $key => $value): ?>
                    <td><?php echo $item->$key ?></td>
                <?php endforeach; ?>     
                <td><?php echo $item->active ? 'Tak' : '' ?></td>
                <td><?php echo $this->getEditLink($item->id) ?></td>
                <td><?php echo $this->getDeleteLink($item->id) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>