<div class="tally-sheet-admin" >
    <h1>Tally Sheet:</h1>
    <?php echo $this->formUrlAjax; ?>
    <form id="tally-sheet-admin-form" name="tally-sheet-admin-form" method="post">
        <div id="message" class="tally-sheet-message"></div>
        <div id="success" class="tally-sheet-success"></div>
        <input type="hidden" value="" id="tally-sheet-id" name="tally-sheet-id">
        <p>
            <label for="date">date:</label>
            <input type="text" value="<?php echo date("Y-m-d"); ?>" id="tally-sheet-date" name="tally-sheet-date">
            <label for="start">start:</label>
            <input type="text" value="08:30" id="tally-sheet-start" name="tally-sheet-start">
            <label for="end">end:</label>
            <input type="text" value="17:30" id="tally-sheet-end" name="tally-sheet-end">
        </p>
        <p>
            <label for="imputation">poste:</label>
            <input type="text" value="" id="tally-sheet-imputation" name="tally-sheet-imputation">
            <label for="worker">worker:</label>
            <input type="text" value="PWS" id="tally-sheet-worker" name="tally-sheet-worker">
            <label for="comment">comment:</label>
            <textarea id="tally-sheet-comment" name="tally-sheet-comment"></textarea>
        </p>
        <p>
            <button id="tally-sheet-save" style="display: none;">update</button>
            <button id="tally-sheet-cancel" style="display: none;">cancel</button>
            <button id="tally-sheet-add">add</button>
            <button id="tally-sheet-send">Send</button>
        </p>
    </form>
    <div class="tally-sheet-admin-data">
        <table>
            <tr id="">
                <th>ID</th>
                <th>Date</th>
                <th>Poste</th>
                <th>Worker</th>
                <th>Start</th>
                <th>End</th>
                <th>Comment</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            $json = json_decode($this->jsonData);
            foreach ($json->items as $key => $value) {
                ?>
                <tr id="tr_<?php echo $value->id; ?>">
                    <td id="td_id"><?php echo $value->id; ?></td>
                    <td id="td_date"><?php echo $value->date; ?></td>
                    <td id="td_imputation"><?php echo $value->imputation; ?></td>
                    <td id="td_worker"><?php echo $value->worker; ?></td>
                    <td id="td_start"><?php echo $value->start; ?></td>
                    <td id="td_end"><?php echo $value->end; ?></td>
                    <td id="td_comment"><?php echo $value->comment; ?></td>
                    <td><button onclick="tallySheet.setUpdate('<?php echo $value->id; ?>')">update</button></td>
                    <td><button onclick="tallySheet.delete('<?php echo $value->id; ?>')">delete</button></td>
                </tr>
            <?php } ?>
            <tr id="tally-sheet-template">
                <td id="td_id">{{id}}</td>
                <td id="td_date">{{date}}</td>
                <td id="td_imputation">{{imputation}}</td>
                <td id="td_worker">{{worker}}</td>
                <td id="td_start">{{start}}</td>
                <td id="td_end">{{end}}</td>
                <td id="td_comment">{{comment}}</td>
                <td><button onclick="tallySheet.setUpdate('{{id}}')">update</button></td>
                <td><button onclick="tallySheet.delete('{{id}}')">delete</button></td>
            </tr>
        </table>
    </div>
</div>

<style>
    .tally-sheet-admin div{
        margin-top: 30px;
    }
    .tally-sheet-admin label{
        display:inline-block;
        width: 80px;
    }
    div.tally-sheet-admin-data table,tr,td{
        border: solid white 1px;
        border-collapse: collapse;
        min-width: 50px;
        padding: 5px;
    }
    div.tally-sheet-admin-data tr:nth-child(even) {background: #CCC}
    div.tally-sheet-admin-data tr:nth-child(odd) {background: #FFF}
    .tally-sheet-message {
        padding:  5px 10px;
        border: 1px solid slategrey;
        background: lightgrey;
        display: none;
    }
    .tally-sheet-success {
        padding: 5px 10px;
        border: 1px solid green;
        background: lightgreen;
        color: green;
        display: none;
        max-width: 500px;
        margin: 10px 0px;
    }
    #tally-sheet-template{
        display:none;
    }
</style>
<script>
                            tallySheet.urlSubmit = "<?php echo $this->formUrlAjax; ?>";
                            tallySheet.data = <?php echo $this->jsonData; ?>;
</script>