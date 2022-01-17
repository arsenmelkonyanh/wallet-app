let CreateWalletManager = {

    /**
     * Initializes create wallet functionality.
     */
    init: function () {
        this.initCreateWallet();
    },

    /**
     * Initialized submit create wallet functionality.
     */
    initCreateWallet: function () {
        let walletForm = $('#createWalletForm');

        let action= walletForm.attr('action');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        let amountField = walletForm.find('[name=amount]');
        let amount;

        walletForm.on('submit', function (ev) {
            ev.preventDefault();

            // modify amount to send amount as numeric
            amount = amountField.val();
            amountField.val(amount.replace(',', '.'));

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                url: action,
                type: 'POST',
                dataType : 'json',
                data: walletForm.serialize()
            }).done(function (response) {
                if (response.redirectTo) {
                    window.location.href = response.redirectTo;
                    return;
                }

                window.location.reload();
            }).fail(function (response) {
                if (response.responseJSON.errors) {
                    window.ErrorHandler.handle(walletForm, response.responseJSON.errors);
                    return;
                }

                window.location.reload();
            });

            return false;
        });
    }
};

$(function () {
    CreateWalletManager.init();
});
