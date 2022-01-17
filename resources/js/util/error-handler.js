window.ErrorHandler = {

    /**
     * Handles form errors.
     *
     * Adds has-error class to each field with error and
     * set error message under each field with error.
     *
     * @param form
     * @param errors
     */
    handle: function (form, errors) {
        let field;

        for (let fieldName in errors) {
            if (errors.hasOwnProperty(fieldName)) {
                field = form.find('[name="' + fieldName + '"]');

                field.addClass('has-error');

                field.next().text(errors[fieldName][0]);
            }
        }
    }
};
