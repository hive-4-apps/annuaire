import TomSelect from 'tom-select';

jQuery(function ($) {
    $(document).ready(function () {
        // $(".dropdown-trigger").dropdown();

        $('#filter-mobile-localization').formSelect();
        $('#filter-desktop-localization').formSelect();

        const elem1 = document.getElementById('modal-saved');
        const instance1 = M.Modal.init(elem1, {dismissible: false});
        if (instance1 !== null) {
            instance1.open();
        }
        const elem2 = document.getElementById('modal-contact');
        const instance2 = M.Modal.init(elem2, {dismissible: false});
        const elem3 = document.getElementById('modal-sent');
        const instance3 = M.Modal.init(elem3, {dismissible: false});
        if (instance3 !== null) {
            instance3.open();
        }

        $(".filter-localization").on("change", function () {
            let langParam = getUrlParameter('lang');
            langParam = (langParam) ? langParam : 'fr'
            let urlFiltre = "?lang=" + langParam;
            //Region filter
            let fr = $(this).val();
            urlFiltre += '&fr=' + fr;
            //Search filter
            let queryParam = getUrlParameter('q');
            if (!queryParam) {
                queryParam = $('#search-input').val();
            }
            if (queryParam)
                urlFiltre += '&q=' + queryParam;

            window.location.href = urlFiltre;
        });

        $("#switch-country").on("change", function () {
            let href;
            const baseURL = getBaseUrl();
            let filtreRegionParam = getUrlParameter('fr');
            filtreRegionParam = (filtreRegionParam) ? filtreRegionParam : 'br'
            if ($(this).is(':checked')) {
                if( !baseURL.includes("/membres") ){
                    href = $('#route_br').val();
                    href += '&fr=' + filtreRegionParam;
                }else{
                    href = $('#route_br').val();
                }
            } else {
                if( !baseURL.includes("/membres") ){
                    href = $('#route_fr').val();
                    href += '&fr=' + filtreRegionParam;
                }else{
                    href = $('#route_fr').val();
                }
            }
            // alert(href);
            window.location.href = href;
        });

        $('.btn-contact').on('click', function () {
            $('#member_contact_form_member_reference').val($(this).prev().val());
        });
    });
});

function getCurrentUrl() {
    return window.location.href;
}

function getBaseUrl() {
    var getUrl = window.location;
    return getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
}

function getUrlParameter(param, url) {
    if (!url) url = location.href;
    param = param.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + param + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(url);
    return results == null ? null : results[1];
}
