<?php

class zkwpAdminPup {

    private $options = array();

    private function getOptions() {
        $this->options['department'] = get_option('zkwp_pup_department', '09');
        $this->options['cache_duration'] = get_option('zkwp_pup_cache_duration', 30);
        $this->options['cache'] = get_option('zkwp_pup_cache', ZKWP_TOOLS_DIR . 'pup-cache');
    }

    public function getPage() {
        $this->getOptions();
        ?>
        <div class="wrap">        
            <form method="post" action="options.php">
                <?php
                settings_fields('zkwp_pup_options');
                do_settings_sections('zkwp_pup');
                submit_button();
                ?>
            </form>
			<p>Aktualna ścieżka:</p>
			<p><?php echo __FILE__ ?></p>
        </div>            
        <?php
    }

    public function sanitize($input) {
        return $input;
    }

    public function sectionCallback() {
        echo '<p>Lista szczeniąt jest pobierana ze strony głównej ZKWP.</p>'
        , '<p>Poniżej znajdują się ustawienia związane z pobieraniem oraz przechowywaniem listy.</p>';
    }

    public function cacheDurationCallback() {
        echo '<input name="zkwp_pup_cache_duration" id="zkwp_pup_cache_duration" type="number" value="', $this->options['cache_duration'], '"/>'
        , '<br/>Czas w minutach, po jakim lista zostanie na nowo pobrana. '
        , '<br/>Pobranie można też wymusić poprzez usunięcie pliku cache.';
    }

    public function departmentCallback() {
        echo '<input name="zkwp_pup_department" id="zkwp_pup_department" type="text" value="', $this->options['department'], '" />'
        , '<br/>Identyfikator oddziału na stronie ZKWP z listą szczeniąt';
    }

    public function cacheCallback() {
        echo '<textarea name="zkwp_pup_cache" id="zkwp_pup_cache">', $this->options['cache'], '</textarea>'
        , '<br/>Lokalizacja pliku cache, który przechowuje listę szczeniąt.';
    }

}
