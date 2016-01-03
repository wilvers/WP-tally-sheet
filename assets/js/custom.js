console.log("include tally js");
var tallySheet = {
    init: function () {
        if (tallySheet.data === undefined) {
            tallySheet.data = {items: []};
        }
        if (tallySheet.data.items === undefined) {
            tallySheet.data.items = [];
        }
        $(function () {
            $("#tally-sheet-save").click(function (event) {
                event.preventDefault();
                tallySheet.save();
            });
            $("#tally-sheet-cancel").click(function (event) {
                event.preventDefault();
                tallySheet.resetForm();
                $("#message").hide();
                $("#tally-sheet-cancel").hide();
                $("#tally-sheet-save").hide();
                $("#tally-sheet-add").show();
            });
            $("#tally-sheet-add").click(function (event) {
                event.preventDefault();
                tallySheet.add();
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
                $('#tally-sheet-comment').val(tallySheet.data.items[i].comment);
            }
        }
        $("#message").hide();
        $("#tally-sheet-save").show();
        $("#tally-sheet-cancel").show();
        $("#tally-sheet-add").hide();
    },
    getItem: function () {
        var item = {
            id: "",
            worker: $('#tally-sheet-worker').val().toUpperCase(),
            date: $('#tally-sheet-date').val(),
            start: $('#tally-sheet-start').val(),
            end: $('#tally-sheet-end').val(),
            imputation: $('#tally-sheet-imputation').val(),
            total: "",
            comment: $('#tally-sheet-comment').val()
        };
//        console.log($('#tally-sheet-comment').val());
        if (item.worker == "" || item.date == "" | item.imputation == "") {
            tallySheet.setMessage("invalid form");
            return false;
        }
        item.id = item.worker + item.date.replace(/-/g, "");
        var diff = tallySheet.hourToInt(item.end) - tallySheet.hourToInt(item.start);
        item.total = diff;
        return item;
    },
    save: function () {
        //console.log('update', $('#tally-sheet-id').val());
        var item = tallySheet.getItem();
        var updated = false;
        var a, b = -1;
        for (var i in tallySheet.data.items) {
            //si id est présent dans data
            if ($('#tally-sheet-id').val() == tallySheet.data.items[i].id) {
                tallySheet.data.items[i] = item;
                updated = true;
                a = i;
            }
            //si nouvel id est présent dans data
            if (tallySheet.data.items[i].id == item.id && updated != true) {
                tallySheet.data.items[i] = item;
                updated = true;
                b = i;
            }
        }
        if (updated) {
            console.log(a, b);
            if (a != -1 && b != -1) {
                //$("#tr_" + item.id).remove();
                tallySheet.data.items[a] = {};
            }
        }
        tallySheet.updateTr($('#tally-sheet-id').val(), item, true);

        console.log(tallySheet.data.items);
        $("#message").hide();

        tallySheet.resetForm();
        $("#tally-sheet-save").hide();
        $("#tally-sheet-cancel").hide();
        $("#tally-sheet-add").show();
    },
    add: function () {
        var item = tallySheet.getItem();
        for (var i in tallySheet.data.items) {
            //si id est présent dans data mise à jour
            if (tallySheet.data.items[i].id == item.id) {
                tallySheet.data.items[i] = item;
                tallySheet.updateTr(item.id, item, true);
                tallySheet.resetForm();
                return;
            }
        }
        if (tallySheet.data.items === undefined) {
            tallySheet.data.items = [];
        }
        console.log(tallySheet);
        //si pas présent add
        tallySheet.data.items.push(item);
        var tr = $('#tally-sheet-template').prop('outerHTML').replace('tally-sheet-template', 'tr_{{id}}');
        $.each(item, function (key, value) {
            var patt = new RegExp('{{' + key + '}}', 'g');
            tr = tr.replace(patt, item[key]);
        });
        tallySheet.resetForm();
//        $('#tally-sheet-template').parent().append(tr);
        $(tr).insertBefore('#tally-sheet-template');
        $("#tr_" + item.id).css("background", "lightsteelblue");

        $("#message").hide();
        console.log(tallySheet.data.items);
    },
    delete: function (current) {
        for (var i in tallySheet.data.items) {
            if (current == tallySheet.data.items[i].id) {
                tallySheet.data.items[i] = {};
            }
        }
        $("#tr_" + current).remove();
        $("#message").hide();
        $("#tally-sheet-save").hide();
        $("#tally-sheet-cancel").hide();
        $("#tally-sheet-add").show();
        tallySheet.resetForm();
    },
    send: function () {
        //console.log($.param(tallySheet.data));
        $.ajax({
            type: "POST",
            url: tallySheet.urlSubmit,
            data: $.param(tallySheet.data),
            success: function (r, s, t) {
                console.log(r);
                tallySheet.setSuccess(r.msg);
            },
            dataType: ""
        });
    },
    resetForm: function () {
        //console.log("reset");
        $('#tally-sheet-id').val("");
        // $('#tally-sheet-date').val(tallySheet.now());
        //$('#tally-sheet-start').val("08:30");
        // $('#tally-sheet-end').val("17:00");
        $('#tally-sheet-worker').val('');
        //$('#tally-sheet-imputation').val("");
        $('#tally-sheet-comment').val("");
    },
    hourToInt: function (hour) {
        h = parseInt(hour.split()[0]) * 60;
        m = parseInt(hour.split()[1]);
        return h + m;
    },
    updateTr: function (id, item, trexist) {
        var tr = $("#tr_" + id);
        $.each(item, function (key, value) {
            //console.log(key);
            tr.find("#td_" + key).html(value);
        });
        console.log(trexist);
        if (trexist)
            tr.css("background", "lightgreen");
    },
    setMessage: function (message) {
        $("#message").html(message).show();
    },
    setSuccess: function (message) {
        $("#success").html(message).show();
    }
};
tallySheet.init();