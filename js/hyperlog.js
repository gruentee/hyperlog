/**
 * ownCloud - hyperlog
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Constantin Kraft <constantin@websolutions.koeln>
 * @copyright Constantin Kraft 2017
 */

(function ($, OC) {
    $(document).ready(function () {
        // log file name field
        var $fieldLogFileName = $('#logFileName')
        var oldVal = $fieldLogFileName.val()
        $fieldLogFileName.blur(function () {
            var currentVal = $(this).val()
            var $indicator = $('#indicator i');
            if (oldVal === currentVal)
                return;
            var url = OC.generateUrl('/apps/hyperlog/ajax/updateLogFileName')
            var data = {
                logFileName: $(this).val()
            }
            $indicator.toggleClass('icon-loading')
            $.post(url, data).success(function (response) {
                $indicator.toggleClass('icon-loading')
                    .addClass('icon-checkmark')
                $fieldLogFileName.removeClass('error')
            })
                .fail(function (response) {
                    $fieldLogFileName.addClass('error')
                    $indicator.removeClass('icon-loading')
                    $indicator.addClass('icon-close')
                    console.log(response)
                })
        })
        // hook check-boxes
        var $checkboxes = $('#hookSettings .checkbox');
        // setup
        var url = OC.generateUrl('/apps/hyperlog/ajax/getHookStates')
        $.get(url).success(function (response) {
            states = response
            $checkboxes.each(function () {
                var checked = states[this.id] === 'active';
                $(this).attr('checked', checked)
            });
        }).fail(function (response) {
            console.error(response)
        })

        // click handlers
        $checkboxes.click(function () {
            var url = OC.generateUrl('/apps/hyperlog/ajax/setHookStatus');
            var status = $(this).is(':checked') ? 'active' : 'inactive'
            ;var hook = this.id;
            var data = {
                hook: hook,
                status: status
            }
            $.post(url, data).success(function (response) {
                $(this).parent().addClass('visual-feedback success');
            })
                .error(function (response) {
                    console.error(response)
                    $(this).parent().addClass('visual-feedback error')
                })
        })
    })

})(jQuery, OC)