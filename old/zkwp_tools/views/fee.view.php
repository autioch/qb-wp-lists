<table class="qbc-table-list js-dt">
    <thead>
        <tr>
            <th>Rodzaj opłaty</th>
            <th>Cena dotyczy</th>            
            <th class="qbc-col-60">Cena</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->itemList as $item): ?>
            <tr>
                <td><?php echo $item->name ?></td>
                <td><?php echo $item->description ?></td>                
                <td class="qbc-col-60"><?php echo $item->value ?></td>                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>