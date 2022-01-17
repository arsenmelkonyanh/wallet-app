let CreateRecordManager = {

    /**
     * Initializes create record functionality.
     */
    init: function () {
        this.initTransferToAnotherWalletCheckbox();
        this.initDisableSelectedWallet();
        this.initCreateRecord();
    },

    /**
     * Initialized transfer to another checkbox.
     */
    initTransferToAnotherWalletCheckbox: function () {
        let fromLabelIsNotTransfer = $('#fromLabelIsNotTransfer');
        let fromLabelIsTransfer = $('#fromLabelIsTransfer');

        let typeFieldContainer = $('#typeFieldContainer');
        let typeSelect = typeFieldContainer.find('.f_type-select');

        let toFieldContainer = $('#toFieldContainer');
        let toField = toFieldContainer.find('.f_to-select');

        let fromWalletSelect = $('#from');
        let toWalletSelect = $('#to');

        let fromWallets = $('.f_from-wallet');
        let toWallets = $('.f_to-wallet');

        $('#isTransfer').on('change', function () {
            if (this.checked) {
                // change {from} wallet label
                fromLabelIsNotTransfer.addClass('is--hidden');
                fromLabelIsTransfer.removeClass('is--hidden');

                // hide and disable type select
                typeFieldContainer.addClass('is--hidden');
                typeSelect.removeAttr('required');
                typeSelect.attr('disabled', 'disabled');

                // show and enable {to} wallet field
                toFieldContainer.removeClass('is--hidden');
                toField.removeAttr('disabled');
                toField.attr('required', 'required');

                // enable all wallets in {to} wallets select box
                toWallets.removeAttr('disabled');

                // in case if {from} wallet selected disabled current {from} value in {to} wallets
                if (fromWalletSelect.val()) {
                    $('.f_to-wallet[value="' + fromWalletSelect.val() + '"]').attr('disabled', 'disabled');
                }

                return;
            }

            // change {from} wallet label
            fromLabelIsNotTransfer.removeClass('is--hidden');
            fromLabelIsTransfer.addClass('is--hidden');

            // show and enable type select
            typeFieldContainer.removeClass('is--hidden');
            typeSelect.removeAttr('disabled');
            typeSelect.attr('required', 'required');

            // hide and disable {to} wallet field
            toFieldContainer.addClass('is--hidden');
            toField.attr('disabled', 'disabled');
            toField.removeAttr('required');

            // enable all wallets to select
            fromWallets.removeAttr('disabled');
            toWallets.removeAttr('disabled');
            toWalletSelect.val('0');
        });
    },

    /**
     * Disables selected wallet in another select box.
     */
    initDisableSelectedWallet: function () {
        let walletSelects = $('.f_wallet-select');

        if (walletSelects.length < 2) {
            return;
        }

        let isTransferCheckbox = $('#isTransfer');
        let fromWallets = $('.f_from-wallet');
        let toWallets = $('.f_to-wallet');

        walletSelects.on('change', function () {
            if (!isTransferCheckbox.is(':checked')) {
                return;
            }

            // in case if {from} wallet is selected, disable corresponding {to} wallet
            if ($(this).hasClass('f_from-select')) {
                toWallets.removeAttr('disabled');
                $('.f_to-wallet[value="' + $(this).val() + '"]').attr('disabled', 'disabled');

                return;
            }

            // in case if {to} wallet is selected, disable corresponding {from} wallet
            fromWallets.removeAttr('disabled');
            $('.f_from-wallet[value="' + $(this).val() + '"]').attr('disabled', 'disabled');
        });

    },

    /**
     * Initialized submit create record functionality.
     */
    initCreateRecord: function () {
        let recordForm = $('#createRecordForm');

        let action = recordForm.attr('action');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        let amountField = recordForm.find('[name=amount]');
        let amount;

        recordForm.on('submit', function (ev) {
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
                dataType: 'json',
                data: recordForm.serialize()
            }).done(function (response) {
                if (response.redirectTo) {
                    window.location.href = response.redirectTo;
                    return;
                }

                window.location.reload();
            }).fail(function (response) {
                if (response.responseJSON.errors) {
                    window.ErrorHandler.handle(recordForm, response.responseJSON.errors);
                    return;
                }

                window.location.reload();
            });

            return false;
        });
    }
};

$(function () {
    CreateRecordManager.init();
});
