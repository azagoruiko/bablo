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
    $.get('index.php', {action: 'getIncomeUpdates', since: sinceWhen, ctrl: 'income'},
        function (data) {
            $('#incomes_table').append(data);
            sinceWhen = $('#incomes_table tr').last().children().first().text();
        });
    $(document)
            .ajaxStart(function () {ajaxInProgress = true; console.log('start');})
            .ajaxComplete(function () {ajaxInProgress = false; console.log('complete');});
    
}

$().ready(function() {
    sinceWhen = $('#incomes_table tr').last().children().first().text();
    setInterval(getIncomeUpdates, 2000);
    
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