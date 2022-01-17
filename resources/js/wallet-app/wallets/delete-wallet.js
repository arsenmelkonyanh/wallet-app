let DeleteWalletManager = {

    /**
     * Initializes delete wallet functionality.
     */
    init: function () {
        this.initDeleteWallet();
    },

    /**
     * Initialized submit delete wallet functionality.
     */
    initDeleteWallet: function () {
        let action;
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        let deleteWalletButtons = $('.f_delete-wallet');

        deleteWalletButtons.on('click', function () {
            action = $(this).attr('data-action');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                url: action,
                type: 'DELETE',
                dataType : 'json'
            }).done(function () {
                window.location.reload();
            }).fail(function () {
                window.location.reload();
            });

        });
    }
};

$(function () {
    DeleteWalletManager.init();
});
