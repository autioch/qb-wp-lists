<div class="zkwp-tools-item-list">
    <?php foreach ($this->itemList as $item): ?>
        <div class="zkwp-tools-item">

            <?php $this->echoImage($item) ?>

            <h3>Hodowla <?php echo $item->name; ?></h3> 

            <?php
            $this->echoField($item, 'description');
            $this->echoField($item, 'contact'); 

            $address = $this->fieldArrayToValues($item, array('postal_code', 'city', 'address'));
            if (strlen($address) > 0) {
                echo 'adres:<br />', $address, '<br />';
            }

            $contact2 = $this->fieldArrayToValues($item, array('phone', 'email', 'website'), '<br />');
            if (strlen($contact2) > 0) {
                echo '<p>', $contact2, '</p>';
            }
            ?>
        </div>
        <div class="zkwp-bottom"></div>
    <?php endforeach; ?>
</div>
<p class="zkwp-disclosure">
    Wszelkie informacje zawarte na tej stronie zostały podane przez 
    właścicieli hodowli. W celu aktualizacji danych prosimy o przesłanie informacji na adres 
    <a href="mailto:biuro@zkwp-koszalin.pl">biuro@zkwp-koszalin.pl</a>.
</p>