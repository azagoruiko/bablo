<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Курсы валют</h3>
            </div>
            <div id="rates" class="panel-body text-center">
                <div id="wait" style="display: none">
                    <div>
                        <img src="img/indicator.gif" />
                    </div>
                    <div>
                        Loading...
                    </div>
                </div>
                <table id="rate_table" class="table table-striped table-bordered table-condensed">
                    <?php
                    echo '<tr><th>';
                    foreach ($this->view->currencies as $cur1) {
                        echo "<th>{$cur1['name']}</th>\n";
                    }
                    echo '</tr>';
                    foreach ($this->view->currencies as $cur1) {
                        echo "<tr><td>{$cur1['name']}</td>";
                        foreach ($this->view->currencies as $cur2) {
                            echo "<td id=\"{$cur1['name']}_{$cur2['name']}\"></td>";
                        }
                        echo '</tr>';
                    }
                    
                    ?>
                </table>
            </div>
            <button class="btn btn-info" id="update">Получить курсы</button>
        </div>
    </div>
</div>
<script>
var curs = <?php echo json_encode($this->view->currencies) ?>;
$().ready(function() {
    $('#update').click(function(e, el) {
        $('#rate_table').hide();
        $('#wait').show();
        $(curs).each(function (i, e1) {
            $(curs).each(function (i, e2) {
                $.getJSON('http://rate-exchange.appspot.com/currency?callback=?', {from: e1.name, to: e2.name}, 
                function (data) {
                    $('#rate_table').show();
                    $('#wait').hide();
                    $('#' + e1.name + '_' + e2.name).html(data.rate);
                });
            });
        });
    });
});
</script>