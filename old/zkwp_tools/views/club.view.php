<table class="qbc-table-list js-dt">
    <thead>
        <tr>
            <th>Nazwa sekcji</th>
            <th>Kierownik sekcji</th>
            <th>Działacze</th>
            <th class="qbc-col-100">Dyżury</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->itemList as $item): ?>
            <tr>
                <td><?php echo $item->name ?></td>
                <td><?php echo $item->leader ?></td>
                <td><?php $this->echoList($item->support) ?></td>
                <td class="qbc-col-100"><?php echo $item->duty ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>