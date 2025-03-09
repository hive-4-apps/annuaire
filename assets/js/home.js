jQuery(function ($) {
    $(document).ready(function () {

        // Vérifie si l'utilisateur a déjà cliqué pour fermer le toast
        var toastHasBeenClosed = localStorage.getItem('toastClosed');

        // Si l'utilisateur n'a jamais fermé le toast, on l'affiche
        if (!toastHasBeenClosed) {
            M.toast({
                displayLength: 100000,
                html: '<div><h4 style="margin: 2px 0 0 0;">Avis IMPORTANT sur l’utilisation de l’annuaire</h4>' +
                    '\n' +
                    'Cet annuaire ainsi que les informations qu’il contient ont pour unique finalité de connecter des membres de la communauté française et francophone au Brésil.\n' +
                    '\n' +
                    'Les informations sont partagées par les membres dans l’optique d’um usage exclusivement personnel.\n' +
                    '\n' +
                    'Toute utilisation abusive ou commerciale de ces informations est expressément interdite.\n' +
                    '\n' +
                    'Nous demandons à tous les usagers et visiteurs de respecter la finalité de cet annuaire et d’utiliser les données qu’il contient de manière éthique et responsable.</div>'+
                    '<button class="btn-flat toast-action">Fermer</button>'
            });

            // Quand l'utilisateur clique sur le bouton de fermeture, on note cette action dans le localStorage
            $('.toast-action').on('click', function () {
                var toastElement = document.querySelector('.toast');
                var toastInstance = M.Toast.getInstance(toastElement);
                toastInstance.dismiss();

                // Ajoute une entrée dans le local storage pour indiquer que le toast a été fermé
                localStorage.setItem('toastClosed', true);
            })
        }

    });
});
