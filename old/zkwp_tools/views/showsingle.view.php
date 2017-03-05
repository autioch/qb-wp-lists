<?php foreach ($this->itemList as $item): ?>
    <div class="qbc-item">
        <?php
        if ($item->map_check && $item->map) {
            echo '<div style="float:right;padding-left: 2%;background:#fff">', stripslashes($item->map), '</div>';
        }
        ?>
        <h3><?php echo $item->title ?></h3>
        <ul class="qbc-list-dash">
            <?php
            $this->echoChapterLink($item, 'sponsors', 'Sponsorzy i Patroni');
            $this->echoChapterLink($item, 'fees', 'Opłaty');
            $this->echoChapterLink($item, 'judges', 'Proponowana obsada sędziowska');
            $this->echoChapterLink($item, 'breed_list', 'Podział ras');
            $this->echoChapterLink($item, 'finals', 'Konkurencje finałowe');
            $this->echoChapterLink($item, 'downloads', 'Materiały do pobrania (plany, spisy, wyniki)');
            $this->echoChapterLink($item, 'events', 'Imprezy towarzyszące');
            ?>
        </ul>
        <div class="zkwp-bottom"></div>
        <h4>Termin i miejsce</h4>
        <?php $this->formatDate($item, 'show_date', 'Termin wystawy: ') ?>
        <?php if ($item->city || $item->location) { ?>
            <p>Miejsce wystawy: <?php echo $item->city, ' ', $item->location ?></p>
        <?php } ?>

        <?php if (($item->app_date_check && $item->app_date && ($item->app_date > 0)) || ($item->app_website_check && $item->app_website)) { ?>
            <h4>Zgłoszenia</h4>
            <?php
            if ($item->app_date_check && $item->app_date && ($item->app_date > 0)) {
                $today = date("Ymd");
                $appDate = date("Ymd", strtotime($item->app_date));
                $this->formatDate($item, 'app_date', 'Termin nadsyłania zgłoszeń' . (($today > $appDate) ? ' upłynął dnia ' : ': '));
            }

            if ($item->app_website_check && $item->app_website) {
                ?>
                <p>Zgłoszenia przyjmujemy za pośrednictwem 
                    <a target="_blank" href="http://<?php echo $item->app_website ?>"><?php echo $item->app_website ?></a>.
                </p>
                <?php
            }

            echo '<div class="zkwp-bottom"></div>';
        }

        $this->echoChapter($item, 'sponsors', 'Sponsorzy i Patroni');

        if ($item->fees_check && $item->fees) {
            echo '<a name="chapter-fees" id="chapter-fees"></a>'
            , '<h4>Opłaty</h4>'
            , '<p>', $item->fees, '</p>';
            if ($item->fees_notice) {
                echo '<p style="color:#d00">', $item->fees_notice, '</p>';
            }
            ?>
            <br/>
            <p>Każdy zgłoszony pies/suka podlega opłacie, bez względu na to, czy zostanie wystawiony, czy też nie.</p>
            <p>Konto bankowe dla wystawców krajowych:</p>
            <p>Bank Polska Kasa Opieki S.A. Grupa PeKaO S.A. II O/Koszalin</p>
            <p>72 1240 3653 1111 0000 4543 4664</p>
            <br/>
            <p>Dla wystawców zagranicznych (Foreign Exhibitors)</p>
            <p>Bank Polska Kasa Opieki S.A. Grupa PeKaO S.A. II O/Koszalin</p>
            <p>IBAN: PL 72 1240 3653 1111 0000 4543 4664</p>
            <p>Code Swift (code BIC) - PKOPPLPW</p>            
            <?php
            echo '<div class="zkwp-bottom"></div>';
        }

        if ($item->judges_check && $item->judges) {
            echo '<a name="chapter-judges" id="chapter-judges"></a>'
            , '<h4>Proponowana obsada sędziowska</h4>'
            , '<p>', $item->judges, '</p>';
            if ($item->judges_prop) {
                echo '<p><em>Uwaga! Skład sędziowski może ulec zmianie.</em></p>';
            }
            echo '<div class="zkwp-bottom"></div>';
        }

        $this->echoChapter($item, 'breed_list', 'Podział ras');
        $this->echoChapter($item, 'finals', 'Konkurencje finałowe');
        $this->echoChapter($item, 'downloads', 'Materiały do pobrania');
        $this->echoChapter($item, 'events', 'Imprezy towarzyszące');

        $this->pageTopLink();
        ?>
    </div>

    <?php
endforeach;
