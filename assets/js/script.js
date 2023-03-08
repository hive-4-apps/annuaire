import TomSelect from 'tom-select';

jQuery(function ($) {
    $(document).ready(function () {
        // $(".dropdown-trigger").dropdown();

        //Seulement en admin
        // $('select').formSelect();

        $(".filter-localization").on("change", function (){
            let langParam = getUrlParameter('lang');
            langParam = (langParam) ? langParam : 'fr'
            let fr = $(this).val();
            let urlFiltre = "?lang=" + langParam;
            urlFiltre +=  '&fr=' + fr;
            let queryParam = getUrlParameter('q');
            if( !queryParam ){
                queryParam = $('#search-input').val();
            }
            if( queryParam )
                urlFiltre +=  '&q=' + queryParam;
            window.location.href = urlFiltre;
        });

        $("#switch-country").on("change", function (){
            let href;
            let filtreRegionParam = getUrlParameter('fr');
            filtreRegionParam = (filtreRegionParam) ? filtreRegionParam : 'br'
           if( $(this).is(':checked')){
               href = $('#route_br').val();
               href += '&fr=' + filtreRegionParam;
           }else{
               href = $('#route_fr').val();
               href += '&fr=' + filtreRegionParam;
           }
            window.location.href = href;
        });
    });
});

function getUrlParameter ( param, url ) {
    if (!url) url = location.href;
    param = param.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+ param +"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( url );
    return results == null ? null : results[1];
}
