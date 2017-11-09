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
        $('#hello').click(function () {
            alert('Hello from your script file');
        });

        $('#echo').click(function () {
            var url = OC.generateUrl('/apps/hyperlog/echo');
            var data = {
                echo: $('#echo-content').val()
            };

            $.post(url, data).success(function (response) {
                $('#echo-result').text(response.echo);
            });

        });
    });

})(jQuery, OC);