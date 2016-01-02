console.log("include tally js");
var tallySheet = {
    init: function () {
        $(function () {
            $("#tally-sheet-save").click(function (event) {
                event.preventDefault();
                tallySheet.save();
            });
            $("#tally-sheet-send").click(function (event) {
                event.preventDefault();
                tallySheet.send();
            });
        });
    },
    now: function () {
        var today = new Date();
        return today.toISOString().substring(0, 10);
    },
    setUpdate: function (current) {
        for (var i in tallySheet.data.items) {
            if (current == tallySheet.data.items[i].id) {
                $('#tally-sheet-id').val(tallySheet.data.items[i].id);
                $('#tally-sheet-date').val(tallySheet.data.items[i].date);
                $('#tally-sheet-start').val(tallySheet.data.items[i].start);
                $('#tally-sheet-end').val(tallySheet.data.items[i].end);
                $('#tally-sheet-worker').val(tallySheet.data.items[i].worker);
                $('#tally-sheet-imputation').val(tallySheet.data.items[i].imputation);
            }
        }
    },
    getItem: function () {
        var item = {
            id: "",
            worker: $('#tally-sheet-worker').val().toUpperCase(),
            date: $('#tally-sheet-date').val(),
            start: $('#tally-sheet-start').val(),
            end: $('#tally-sheet-end').val(),
            total: ""
        };
        item.id = item.worker + item.date.replace(/-/g, "");
        var diff = tallySheet.hourToInt(item.end) - tallySheet.hourToInt(item.start);
        item.total = diff;
        return item;
    },
    save: function () {
        var item = tallySheet.getItem();
        var updated = false;
        var a, b = -1;
        for (var i in tallySheet.data.items) {
            //si id est présent dans data
            if ($('#tally-sheet-id').val() == tallySheet.data.items[i].id) {
                //&& item.id == $('#tally-sheet-id').val()
                tallySheet.data.items[i] = item;
                updated = true;
                a = i;
            }
            //si nouvel id est présent dans data
            if (tallySheet.data.items[i].id == item.id) {
                tallySheet.data.items[i] = item;
                updated = true;
                b = i;
            }
        }
        if (updated) {
            if (a != -1 && b != -1)
                tallySheet.data.items[i] = {};
        } else {
            tallySheet.data.items.push(tallySheet.getItem());
        }
        console.log(tallySheet.data.items);
        tallySheet.resetForm();
    },
    delete: function (current) {
        for (var i in tallySheet.data.items) {
            if (current == tallySheet.data.items[i].id) {
                tallySheet.data.items[i] = {};
            }
        }
        tallySheet.resetForm();
    },
    send: function () {
        console.log("send");
    },
    resetForm: function () {
        $('#tally-sheet-id').val();
        $('#tally-sheet-date').val(tallySheet.now());
        $('#tally-sheet-start').val("08:30");
        $('#tally-sheet-end').val("17:00");
        $('#tally-sheet-worker').val("PWS");
        //$('#tally-sheet-imputation').val();
    },
    hourToInt: function (hour) {
        h = parseInt(hour.split()[0]) * 60;
        m = parseInt(hour.split()[1]);
        return h + m;
    }
};
tallySheet.init();