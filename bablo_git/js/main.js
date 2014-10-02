function setErrorField(field, error)  {
    if (error) {
        $(field).parent().addClass("has-error");
    } else {
        $(field).parent().removeClass("has-error");
    }
}

function clearForm(errorBox) {
    errorBox.empty();
    $('#addIncome input').parent().removeClass('has-error');    
}

function setErrorState(errorFields, errors, errorBox) {
    errorBox.empty();
    $(errors).each( function (i, f) {errorBox.append('<div>' + f + '</div>')} );
    $(errorFields).each(function (i, f) { setErrorField(f, true); });
}

var sinceWhen = 0;
var ajaxInProgress = false;

function getIncomeUpdates() {
    if (ajaxInProgress) return;
    $.post('index.php?ctrl=income&action=getIncomeUpdates', {
            since: sinceWhen,
            months: $('[name=months]').val()},
        function (data) {
            $('#incomes_table').append(data);
            sinceWhen = findLastId();
        });
    $(document)
            .ajaxStart(function () {ajaxInProgress = true; console.log('start');})
            .ajaxComplete(function () {ajaxInProgress = false; console.log('complete');});
    
}

function findLastId() {
    var table = $('#incomes_table tr');
    if (!table) {
        return -1;
    } else {
        var max = 0;
        table.each( function (i, e) {
            var el = $(e).children().first();
            if (Number(el.text()) > max) max = Number(el.text());
        });
        return max;
    }
}

$().ready(function() {
    sinceWhen = findLastId();
    if (sinceWhen != -1) {
        if (!sinceWhen) {
            sinceWhen = 0;
        }
        setInterval(getIncomeUpdates, 2000);
    }
    
    $('#addIncome').validate({
        highlight: function (element, cssClass) {
            setErrorField($(element), true);
        },
        errorContainer: '#messages',
        errorLabelContainer: '#messages',
        unhighlight: function (element, cssClass) {
            setErrorField($(element), false);
        }
    });
});