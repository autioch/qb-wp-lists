<table class="zkwp-tools-table-view">
    <thead>
        <tr>
            <th>Rodzaj opłaty</th>
            <th>Cena dotyczy</th>
            
            <th class="zkwp-table-col60">Cena</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->itemList as $item): ?>
            <tr>
                <td><?php echo $item->name ?></td>
                <td><?php echo $item->description ?></td>
                
                <td class="zkwp-table-col60"><?php echo $item->value ?></td>                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>