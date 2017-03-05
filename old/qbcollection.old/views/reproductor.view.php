<div class="zkwp-tools-item-list">
    <?php foreach ($this->itemList as $item): ?>
        <div class="zkwp-tools-item">
            <?php $this->echoImage($item) ?>
            <h3>
                <?php
                echo $item->name;
                if ($item->nickname) {
                    echo ' ', $item->nickname;
                }
                ?>
            </h3>
            <?php
            echo '<p> ur. ', $this->formatDate($item, 'birth'), '<br />';
            echo 'nr. rej.: ', $item->registration, ', nr. rod.: ', $item->lineage, '<br />';
            echo ' (', $item->father, ' - ', $item->mother, ')<br />';

            $this->echoField($item, 'coat', 'Umaszczenie: '); //reproduktor, champion
            $this->echoField($item, 'test', 'Badania: '); //reproduktor, champion
            $this->echoField($item, 'training', 'Wyszkolenie: '); //reproduktor, champion

            if ($item->title) { //reproduktor, champion
                echo '<p>Tytuły: </p>', $this->echoList($item->title, "\n");
            }

            $this->echoField($item, 'person', 'Właściciel: '); //reproduktor, champion

            $address = $this->fieldArrayToValues($item, ['postal_code', 'city', 'address'], ' ');
            if (mb_strlen($address) > 0) {
                echo '<p>', $address, '</p>';
            }

            $contact = $this->fieldArrayToValues($item, ['phone', 'email', 'website'], '<br/>');
            if (mb_strlen($contact) > 0) {
                echo '<p>', $contact, '</p>';
            }
            ?>
        </div>
        <div class="zkwp-bottom"></div>
    <?php endforeach; ?>
</div>
<p class="zkwp-disclosure">
    Wszelkie informacje zawarte na tej stronie zostały podane przez 
    właścicieli psów. W celu aktualizacji danych prosimy o przesłanie informacji na adres 
    <a href="mailto:biuro@zkwp-koszalin.pl">biuro@zkwp-koszalin.pl</a>.
</p>