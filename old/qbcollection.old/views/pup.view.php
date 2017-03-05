<table class="zkwp-tools-table-view">
    <thead>
        <tr>
            <th>Rasa</th>
            <th>Telefon</th>
            <th>Strona</th>
            <th>E-mail</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->data as $pup): ?>
            <tr>
                <td>
                    <?php $this->googleLink(trim($pup['name']), 'Obejrzyj rasę w google') ?>
                    <span><?php echo trim($pup['name']) ?></span>
                </td>
                <td><?php $this->formatPhoneNumbers($pup['phone']); ?></td>
                <td><?php $this->webLink(trim($pup['website'])) ?></td>
                <td><?php $this->formatEmailAddresses($pup['email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>   