(function ($) {

    var dataTableConfig, datePickerConfig, imageHelpMessage;

    dataTableConfig = {
        bPaginate: false,
        bStateSave: true,
        sDom: '<"qbc-search"fi>t',
        bAutoWidth: false,
        oLanguage: {
            sZeroRecords: 'Brak wyników',
            sInfo: '',
            sInfoEmpty: '0 pozycji',
            sInfoFiltered: 'Znaleziono _TOTAL_ pozycji',
            sSearch: 'Szukaj:'
        }
    };

    datePickerConfig = {
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        closeText: "Zamknij",
        showButtonPanel: true,
        currentText: "Dzisiaj",
        dayNamesMin: ["Ni", "Po", "Wt", "Śr", "Cz", "Pt", "So"],
        minDate: new Date(2000, 0, 1),
        monthNamesShort: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"]
    };

    imageHelpMessage = '<span class="qbca-image-help">?' +
            '<div>Wprowadź <strong>URL pliku</strong> z listy wstawionych w zakładce Media.' +
            '<br/>URL znajdziesz edytując obraz, w ramce "Zapisz", po prawej stronie ekranu.' +
            '<br/><a target="_blank" href="/zkwp/wp-admin/upload.php">Otwórz "Media" w nowym oknie</a>' +
            '</div>' +
            '</span>';

    function listDeleteConfirm() {
        return confirm('Czy na pewno usunąć wybraną pozycję?');
    }

    function editDeleteConfirm() {
        return confirm('Czy na pewno usunąć?');
    }

    function unveilSetup() {
        var th = 200, $w = $(window);
        $('.qbc-item-image').unveil().filter(function () {
            var $e = $(this),
                    wt = $w.scrollTop(),
                    wb = wt + $w.height(),
                    et = $e.offset().top,
                    eb = et + $e.height();

            return eb >= wt - th && et <= wb + th;
        }).trigger('unveil');
    }

    $(function () {

        /* Enhanced admin tables */
        $('.js-datatable').dataTable(dataTableConfig);

        /* Add search icon */
        $('.qbc-search').prepend('<span class="qbci-search"/>');

        /* jQuery UI Datepicker */
        $().datepicker && $('.qbf-date').datepicker(datePickerConfig);

        /* List delete confirmation */
        $('.js-datatable').on('click', '.js-delete', listDeleteConfirm);

        /* Edit delete confirmation */
        $('#qbca_form-delete').on('click', editDeleteConfirm);

        /* Images information */
        $('#qbca_form-image').after(imageHelpMessage);

        /* Lazy load images */
        $().unveil && $(document).ready(unveilSetup);

        /* Make every table row link to edition */
        $('.js-datatable').on('click', 'td', function () {
            window.location = $(this).parent().find('.js-edit').attr('href');
        });
        
        $('.js-dt').dataTable(dataTableConfig);


        /* select auto reload */
        $('.qb-wp-lists-key').on('change', function () {
            $(this).closest('.qb-wp-lists-key-form').submit();
        });
        $('.js-plain-search').addClass('is-hidden');



    });

}(jQuery));
