<div id="wait" style="display: none">
    <div>
        <img src="img/indicator.gif" />
    </div>
    <div>
        Loading...
    </div>
</div>

<div class="jumbotron">
    <h1>Главная страница</h1>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Получено бабла за месяц</h3>
            </div>
            <div id="monthly-income" class="panel-body text-center">
                
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Потрачено бабла за месяц</h3>
            </div>
            <div id="monthly-expence" class="panel-body text-center">
                
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Баланс за год</h3>
            </div>
            <div id="annual-balance" class="panel-body text-center">
                
            </div>
        </div>
    </div>
</div>
<script>
    var miInProgress = false;
    var meInProgress = false;
    var aiInProgress = false;
    function updateNumber (data, containerId) {
        var sum = 0;
        $(data.updates).each(function (i, e) {
            sum += Number(e.usdAmount);
        });
        $('#' + containerId).html('<h1>$' + sum + '</h1>');
    }
    
    function updateMonthlyIncome(data) {
        updateNumber(data, 'monthly-income');
        miInProgress = false;
    }
    function updateMonthlyExpence(data) {
        updateNumber(data, 'monthly-expence');
        meInProgress = false;
    }
    
    function updateAnnualBalance(data) {
        updateNumber(data, 'annual-balance');
        aiInProgress = false;
    }
    $().ready(function() {
        $('#wait').children().clone()
                .appendTo($('#monthly-income'))
                .clone()
                .appendTo($('#monthly-expence'))
                .clone()
                .appendTo($('#annual-balance'));
        setInterval( function () {
            if (!miInProgress) {
                miInProgress = true;

                $.post('index.php?ctrl=income&action=monthlyIncome', 
                    {},
                    updateMonthlyIncome
                );
            }
            if (!meInProgress) {
                meInProgress = true;

                $.post('index.php?ctrl=expence&action=monthlyExpence', 
                    {},
                    updateMonthlyExpence
                );
            }
            if (!aiInProgress) {
                aiInProgress = true;

                $.post('index.php?ctrl=income&action=annualBalance', 
                    {},
                    updateAnnualBalance
                );
            }
        }, 3000);
    });
</script>