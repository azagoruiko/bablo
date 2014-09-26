function setErrorField(field, error)  {
    if (error) {
        field.parentNode.className += " has-error";
    } else {
        field.parentNode.className 
            = field.parentNode.className.replace(" has-error", "");
    }
}

function clearForm(errorBox) {
    errorBox.innerHTML = "<div></div>";
    var allFields = document.getElementById('addIncome').getElementsByTagName('input');
    //allFields.insertAfter(document.getElementsByName('source_id'));
    for (var i=0; i< allFields.length; i++) {
        setErrorField(allFields[i], false);
    }
    var select = document.getElementsByName('source_id');
    setErrorField(select[0], false);
    
}

function setErrorState(errorFields, errors, errorBox) {
    errorBox.innerHTML = "<div></div>";
    for (var i = 0; i < errors.length; i++) {
        errorBox.innerHTML += '<div>' + errors[i] + '</div>';
    }
    for (var i = 0; i < errorFields.length; i++) {
        setErrorField(errorFields[i], true);
    }
}

var sinceWhen = 1485;
var ajaxInProgress = false;

function getIncomeUpdates() {
    var ajax = new window.XMLHttpRequest;
    ajax.open('GET', 'index.php?action=getIncomeUpdates&since=' + sinceWhen, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200 && !ajaxInProgress) {
            document.getElementById('incomes_table').innerHTML += ajax.responseText;
            // поиск максимального id
            var trs = document.getElementById('incomes_table').getElementsByTagName('tr');
            for (var i = 0; i < trs.length; i++) {
                if (sinceWhen < Number(trs[i].children[0].innerHTML)) {
                    sinceWhen = Number(trs[i].children[0].innerHTML);
                }
            }
            ajaxInProgress = false;
        }
    };
    ajaxInProgress = true;
    ajax.send();
    
    
}

window.onload = function() {
    setInterval(getIncomeUpdates, 2000);
    
    var incomeForm = document.getElementById('addIncome');
    if (incomeForm) {
        
        incomeForm.addEventListener('submit', function(a, b) {
            clearForm(document.getElementById('messages'));
            var els = document.getElementsByName('amount');
            var errorFields = [];
            var errors = [];
            amount = els[0].value;
            if (!isFinite(amount) || amount === '') {
                errorFields.push(els[0]);
                errors.push('Please enter a number');   
            }
            
            var els1 = document.getElementsByName('source_id');
            var els2 = document.getElementsByName('date');
            
            if (els1[0].selectedOptions.length == 0) {
                errorFields.push(els1[0]);
                errors.push('Please at least one source'); 
            }
            
            if (els2[0].value === '') {
                errorFields.push(els2[0]);
                errors.push('Please select a date'); 
            }
            
            if (errors.length > 0) {
                setErrorState(errorFields, errors, document.getElementById('messages'));
                event.preventDefault();
            } else {
                clearForm(document.getElementById('messages'));
            }
        });
    }
}


