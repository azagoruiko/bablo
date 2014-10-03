<?php
header('Content-type: text/json');
echo json_encode($this->view->getRaw());
