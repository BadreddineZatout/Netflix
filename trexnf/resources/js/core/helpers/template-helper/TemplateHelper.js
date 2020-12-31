export default class TemplateHelper {
    /**
     * Prevent dropdown menu from closing inside click
     * */
    static preventDropdownMenuCloseOnInsideClick() {
        $(document).on('click.bs.dropdown.data-api', '.dropdown.keep-inside-clicks-open', function (e) {
            e.stopPropagation();
        });
    }
}
