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
            <label for="logFileName">Dateiname der Log-Datei.</label>
        </p>
        <p>
            <input type="text" id="logFileName" name="logFileName" value="<?php p($_['logFileName']); ?>">
            <span id="indicator"><i>&nbsp;</i></span>
        </p>
    </div>
    <div class="app-settings">
        <fieldset id="hookSettings">
            <legend><h3>Ereignisse, die protokolliert werden sollen</h3></legend>
            <h4>Datei-Operationen</h4>
            <input type="checkbox" id="postWrite" class="checkbox"><label for="postWrite">Datei/Ordner
                geschrieben</label>
            <input type="checkbox" id="postCreate" class="checkbox"><label for="postCreate">Datei/Ordner
                erstellt</label>
            <input type="checkbox" id="postDelete" class="checkbox"><label for="postDelete">Datei/Ordner
                gelöscht</label>
            <input type="checkbox" id="postTouch" class="checkbox"><label for="postTouch">Datei/Ordner angesehen</label>
            <input type="checkbox" id="postCopy" class="checkbox"><label for="postCopy">Datei/Ordner kopiert</label>
            <input type="checkbox" id="postRename" class="checkbox"><label for="postRename">Datei/Ordner
                umbenannt</label>
        </fieldset>
    </div>
</div>
