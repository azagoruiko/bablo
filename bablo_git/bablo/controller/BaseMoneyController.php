<?php

namespace bablo\controller;

class BaseMoneyController extends BaseController {
    use serviceInject\ExpenceServiceTrait;
    
    protected function getSelectedMonth($year, $month) {
        $selectedMonth = $this->getRequest()->getPostValue('months');
        if (empty($selectedMonth)) {
            $selectedMonth = implode(',', [$month, $year]);
        }
        return $selectedMonth;
    }
    
    protected function getMonthArray($year, $month) {
        $months = [];
        for ($i=0; $i<=12; $i++){
            $months["$month,$year"]=date("M", mktime(0, 0, 0, $month, 1, $year))." $year";
            $month--;
            if ($month==0) {
                $month=12;
                $year--;
            }
        }
        return $months;
    }
    
    protected function getSelectedYearMonth() {
        $month = $this->getRequest()->getPostValue('months');
        if (empty($month)) {
            return [null, null];
        } else {
            return explode(',', $this->getRequest()->getPostValue('months'));
        }
    }
    
    protected function getTodayYearMonth() {
        $today = date ('Y,m');
        return explode(',', $today);
    }
    
    protected function prepareMoneyReportForm() {
        list($year, $month)=$this->getTodayYearMonth();
        $this->view->selectedMonth = $this->getSelectedMonth($year, $month);
        $this->view->months = $this->getMonthArray($year, $month);
    }
}
