<?php

namespace PioCMS\Utils;

class Pagination {

    public $itemsPerPage;
    public $range;
    public $currentPage;
    public $total;
    public $textNav;
    public $itemSelect;
    private $_navigation;
    private $_link;
    private $_pageNumHtml;
    private $_itemHtml;

    /**
     * Constructor
     */
    public function __construct($page) {
        //set default values
        $this->itemsPerPage = 5;
        $this->range = 5;
        $this->currentPage = $page;
        $this->total = 0;
        $this->textNav = false;
        $this->itemSelect = array(5, 25, 50, 100, 'All');
        //private values
        $this->_navigation = array(
            'next' => 'Next',
            'pre' => 'Pre',
            'ipp' => 'Item per page'
        );
        $this->_link = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
        $this->_pageNumHtml = '';
        $this->_itemHtml = '';
    }

    public function setURL($url) {
        $this->_link = filter_var($url, FILTER_SANITIZE_STRING);
    }

    /**
     * paginate main function
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @return              type
     */
    public function paginate() {
        //get page numbers
        $this->_pageNumHtml = $this->_getPageNumbers();
        //get item per page select box
        $this->_itemHtml = $this->_getItemSelect();
    }

    /**
     * return pagination numbers in a format of UL list
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @param               type $parameter
     * @return              string
     */
    public function pageNumbers() {
        if (empty($this->_pageNumHtml)) {
            exit('Please call function paginate() first.');
        }
        return $this->_pageNumHtml;
    }

    /**
     * return jump menu in a format of select box
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @return              string
     */
    public function itemsPerPage() {
        if (empty($this->_itemHtml)) {
            exit('Please call function paginate() first.');
        }
        return $this->_itemHtml;
    }

    /**
     * return page numbers html formats
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @return              string
     */
    private function _getPageNumbers() {
        $html = '<ul>';
        //previous link button
        if ($this->textNav && ($this->currentPage > 1)) {
            echo '<li><a href="' . str_replace('{page}', ($this->currentPage - 1), $this->_link) . '"';
            echo '>' . $this->_navigation['pre'] . '</a></li>';
        }
        //do ranged pagination only when total pages is greater than the range
        if ($this->total > $this->range) {
            $start = ($this->currentPage <= $this->range) ? 1 : ($this->currentPage - $this->range);
            $end = ($this->total - $this->currentPage >= $this->range) ? ($this->currentPage + $this->range) : $this->total;
        } else {
            $start = 1;
            $end = $this->total;
        }
        //loop through page numbers
        for ($i = $start; $i <= $end; $i++) {
            echo '<li';
            if ($i == $this->currentPage)
                echo " class='active'";
            echo '><a href="' . str_replace('{page}', ($i), $this->_link) . '">' . $i . '</a></li>';
        }
        //next link button
        if ($this->textNav && ($this->currentPage < $this->total)) {
            echo '<li><a href="' . str_replace('{page}', ($this->currentPage + 1), $this->_link) . '"';
            echo '>' . $this->_navigation['next'] . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * return item select box
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @return              string
     */
    private function _getItemSelect() {
        $items = '';
        $ippArray = $this->itemSelect;
        foreach ($ippArray as $ippOpt) {
            $items .= ($ippOpt == $this->itemsPerPage) ? "<option selected value=\"$ippOpt\">$ippOpt</option>\n" : "<option value=\"$ippOpt\">$ippOpt</option>\n";
        }
        return "<span class=\"paginate\">" . $this->_navigation['ipp'] . "</span>
            <select class=\"paginate\" onchange=\"window.location='$this->_link?current=1&item='+this[this.selectedIndex].value;return false\">$items</select>\n";
    }

    public function convertToArray() {
        return array('totalPage' => $this->total);
    }

}
