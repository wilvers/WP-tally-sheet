<div class="tally-sheet-admin" >
    <h1>Tally Sheet:</h1>
    <?php echo $this->formUrl; ?>
    <form id="tally-sheet-admin" name="tally-sheet-admin" method="post">
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
            <button id="tally-sheet-save">update</button>
            <button id="tally-sheet-send">Send</button>
        </p>
    </form>
    <div class="tally-sheet-admin-data">
        <table>
            <?php
            $json = json_decode($this->jsonData);
            foreach ($json->items as $key => $value) {
                ?>
                <tr>
                    <td><?php echo $value->id; ?></td>
                    <td><?php echo $value->date; ?></td>
                    <td><?php echo $value->imputation; ?></td>
                    <td><?php echo $value->worker; ?></td>
                    <td><?php echo $value->start; ?></td>
                    <td><?php echo $value->end; ?></td>
                    <td><button onclick="tallySheet.setUpdate('<?php echo $value->id; ?>')">update</button></td>
                    <td><button onclick="tallySheet.delete('<?php echo $value->id; ?>')">delete</button></td>
                </tr>
            <?php } ?>
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

</style>
<script>

    tallySheet.data = <?php echo $this->jsonData; ?>;
</script>