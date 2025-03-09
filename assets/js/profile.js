jQuery(function ($) {
    $(document).ready(function () {
        if( $('#btn-toggle-password').length > 0 ){
            let $memberFormPasswordFirst = $('#member_form_password_first');
            let $memberFormPasswordSecond = $('#member_form_password_second');
            $memberFormPasswordFirst.prop( 'disabled', true );
            $memberFormPasswordSecond.prop( 'disabled', true );
            $memberFormPasswordFirst.hide();
            $('label[for=member_form_password_first]').hide();
            $memberFormPasswordSecond.hide();
            $('label[for=member_form_password_second]').hide();
            $('#btn-toggle-password').on( 'click', function (){
                if( $(this).hasClass('active') ){
                    $(this).removeClass('active');
                    $(this).text('Changer de mot de passe');
                    $memberFormPasswordFirst.hide();
                    $('label[for=member_form_password_first]').hide();
                    $memberFormPasswordSecond.hide();
                    $('label[for=member_form_password_second]').hide();
                    $memberFormPasswordFirst.prop( 'disabled', true );
                    $memberFormPasswordSecond.prop( 'disabled', true );
                }else{
                    $(this).addClass('active');
                    $(this).text('Ne pas changer de mot de passe');
                    $memberFormPasswordFirst.show();
                    $('label[for=member_form_password_first]').show();
                    $memberFormPasswordSecond.show();
                    $('label[for=member_form_password_second]').show();
                    $memberFormPasswordFirst.prop( 'disabled', false );
                    $memberFormPasswordSecond.prop( 'disabled', false );
                }
            });
        }
    });
});
