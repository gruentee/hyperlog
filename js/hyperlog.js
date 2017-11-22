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

        $('#logFileName').blur(function () {
            var url = OC.generateUrl('/apps/hyperlog/ajax/updateLogFileName');
            var data = {
                logFileName: $(this).val()
            };
            $('#indicator i').toggleClass('icon-loading')
            // TODO: add spinning "loading" indicator icon
            $.post(url, data).success(function (response) {
                $('#indicator i').toggleClass('icon-loading')
                    .addClass('icon-checkmark')
                $('#logFileName').removeClass('error')
            })
                .fail(function (response) {
                    $('#logFileName').addClass('error');
                    $('#indicator i').removeClass('icon-loading')
                    $('#indicator i').addClass('icon-close')
                    console.log(response);
                })
        })
    });

})(jQuery, OC);