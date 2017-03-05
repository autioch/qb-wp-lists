(function($) {
    $(function() {

        /* select auto reload */
        $('.zkwp-tools-key').on('change', function() {
            $(this).closest('.zkwp-tools-form').submit();
        });
        $('.zkwp-tools-select-search').hide();

        /* enhanced admin tables */
        $('.zkwp-tools-table-list,.zkwp-tools-table-view').dataTable({
            bPaginate: false,
            bStateSave: true,
            sDom: '<"zkwp-tools-search"fi><"clear">t',
            bAutoWidth: false,
            oLanguage: {
                sZeroRecords: 'Brak wyników',
                sInfo: '',
                sInfoEmpty: '0 pozycji',
                sInfoFiltered: 'Znaleziono _TOTAL_ pozycji',
                sSearch: 'Szukaj:'
            }
        });

        /* datepicker */
        $().datepicker && $('.qbf-date').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            closeText: "Zamknij",
            showButtonPanel: true,
            currentText: "Dzisiaj",
            dayNamesMin: ["Ni", "Po", "Wt", "Śr", "Cz", "Pt", "So"],
            minDate: new Date(2000, 0, 1),
            monthNamesShort: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"]
        });

        /* deletion confirmation on list*/
        $('.zkwp-table-list').on('click', '.zkwp-tools-delete', function() {
            return confirm('Czy na pewno usunąć wybraną pozycję?');
        });

        /* deletion confirmation on edit*/
        $('#zkwp_form-delete').on('click', function() {
            return confirm('Czy na pewno usunąć?');
        });


        $(".zkwp-tools-table-list td:not(:has(>a))").click(function() {
            window.location = $(this).parent().find('.zkwp-tools-edit').attr('href');
        }).css('cursor', 'pointer');

        /* Lazy load images */
        $().unveil && $(document).ready(function() {

            var th = 200, $w = $(window);
            $('.zkwp-tools-item-image').unveil().filter(function() {
                var $e = $(this),
                        wt = $w.scrollTop(),
                        wb = wt + $w.height(),
                        et = $e.offset().top,
                        eb = et + $e.height();

                return eb >= wt - th && et <= wb + th;
            }).trigger('unveil');
        });

        /* Images information */
        var formImage = $('#zkwp_form-image');
        if (formImage.length) {
            formImage.after('<span class="zkwp-tools-image-help">?' +
                    '<div>Wprowadź <strong>URL pliku</strong> z listy wstawionych w zakładce Media.'+
                    '<br/>URL znajdziesz edytując obraz, w ramce "Zapisz", po prawej stronie ekranu.' +
                    '<br/><a target="_blank" href="/zkwp/wp-admin/upload.php">Otwórz "Media" w nowym oknie</a>' +
                    '</div>' +
                    '</span>');
        }


    });

}(jQuery));