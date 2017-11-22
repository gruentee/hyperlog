<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 20.11.17
 * Time: 18:18
 */
script('hyperlog', 'hyperlog');
style('hyperlog', 'hyperlog');
?>

<div class="section" id="hyperlog">
    <h2 class="app-name">HyperLog</h2>
    <p><em>Hier können Einstellungen für das Logging vorgenommen werden.</em>
    </p>
    <div class="app-settings">
        <p>
            <label for="logFileName">Dateiname der Log-Datei. Die Log-Datei liegt im data-Verzeichnis.</label>
        </p>
        <p>
            <input type="text" id="logFileName" name="logFileName" value="<?php p($_['logFileName']); ?>">
            <span id="indicator"><i>&nbsp;</i></span>
        </p>
    </div>
    <div class="app-settings">
        <fieldset>
            <legend><h3>Ereignisse, die protokolliert werden sollen</h3></legend>
            <input type="checkbox" id="hookFileWrite"><label for="hookFileWrite">Datei geschrieben</label>
            <input type="checkbox" id="hookFileCreate"><label for="hookFileCreate">Datei erstellt</label>
            <input type="checkbox" id="hookFileDelete"><label for="hookFileDelete">Datei gelöscht</label>
            <input type="checkbox" id="hookFileTouch"><label for="hookFileTouch">Datei angesehen</label>
            <input type="checkbox" id="hookFileCopy"><label for="hookFileCopy">Datei kopiert</label>
            <input type="checkbox" id="hookFileMove"><label for="hookFileMove">Datei verschoben</label>
        </fieldset>
    </div>
</div>
