<table class="zkwp-tools-table-view">
    <thead>
        <tr>
            <th>Nazwa sekcji</th>
            <th>Kierownik sekcji</th>
            <th>Działacze</th>
            <th class="zkwp-table-col100">Dyżury</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->itemList as $item): ?>
            <tr>
                <td><?php echo $item->name ?></td>
                <td><?php echo $item->leader ?></td>
                <td><?php $this->echoList($item->support) ?></td>
                <td class="zkwp-table-col100"><?php echo $item->duty ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>