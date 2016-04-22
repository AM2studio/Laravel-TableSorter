<?php

namespace AM2Studio\Laravel\TableSorter;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Config;

class TableSorter
{
    //template for links
    private $templateConfig;
    //template for disabled links
    private $templateDisabledConfig;

    //default sort_by variable in url (sort_by)
    private $sort_by_variable;
    //default sort_type variable in url (sort_type)
    private $sort_type_variable;

    //classes which plugin uses for links
    private $order_active_class;
    private $order_asc_class;
    private $order_desc_class;
    private $order_next_asc_class;
    private $order_next_desc_class;

    public function __construct()
    {
        //load from app config
        $this->templateConfig = (Config::get('table-sorter.template')) ? Config::get('table-sorter.template') : '<th class="%s"><a href="%s"> %s </a></th>';
        $this->templateDisabledConfig = (Config::get('table-sorter.templateDisabled')) ? Config::get('table-sorter.templateDisabled') : '<th class="%s"> %s </th>';
        $this->sort_by_variable = (Config::get('table-sorter.sort_by_variable')) ? Config::get('table-sorter.sort_by_variable') : 'sort_by';
        $this->sort_type_variable = (Config::get('table-sorter.sort_type_variable')) ? Config::get('table-sorter.sort_type_variable') : 'sort_type';
        $this->order_active_class = (Config::get('table-sorter.order_active_class')) ? Config::get('table-sorter.order_active_class') : 'order-active';
        $this->order_asc_class = (Config::get('table-sorter.order_asc_class')) ? Config::get('table-sorter.order_asc_class') : 'order-asc';
        $this->order_desc_class = (Config::get('table-sorter.order_desc_class')) ? Config::get('table-sorter.order_desc_class') : 'order-desc';
        $this->order_next_asc_class = (Config::get('table-sorter.order_next_asc_class')) ? Config::get('table-sorter.order_next_asc_class') : 'order-next-asc';
        $this->order_next_desc_class = (Config::get('table-sorter.order_next_desc_class')) ? Config::get('table-sorter.order_next_desc_class') : 'order-next-desc';
    }

    public function sortTable($data)
    {
        $headings = $data['headings'];
        $paginator = $data['paginator'];
        $config = (isset($data['config'])) ? $data['config'] : [];

        //load from headings
        $sort_by = (isset($config['sort_by'])) ? $config['sort_by'] : Request::get($this->sort_by_variable);
        $sort_type = (isset($config['sort_type'])) ? $config['sort_type'] : Request::get($this->sort_type_variable);
        $template = (isset($config['template'])) ? $config['template'] : $this->templateConfig;
        $templateDisabled = (isset($config['templateDisabled'])) ? $config['templateDisabled'] : $this->templateDisabledConfig;

        $string = '';
        foreach ($headings as $heading) {
            $name = (isset($heading['name']))  ? $heading['name'] : '';
            $title = (isset($heading['title'])) ? $heading['title'] : '';
            $sort = (isset($heading['sort']))  ? $heading['sort'] : true;

            if ($sort_by != $name) {
                $sort_type_this = 'ASC';
            } else {
                if ($sort_type == 'ASC') {
                    $sort_type_this = 'DESC';
                } else {
                    $sort_type_this = 'ASC';
                }
            }

            $class = '';
            if ($sort_by == $name) {
                if ($sort_type_this == 'ASC') {
                    //$class .= 'order-active order-desc ';
                    $class .= $this->order_active_class.' '.$this->order_desc_class.' ';
                } else {
                    //$class .= 'order-active order-asc ';
                    $class .= $this->order_active_class.' '.$this->order_asc_class.' ';
                }
            }

            if ($sort_type_this == 'ASC') {
                //$class .= 'order-next-asc';
                $class .= $this->order_next_asc_class;
            } else {
                //$class .= 'order-next-desc';
                $class .= $this->order_next_desc_class;
            }

            if ($sort == true) {
                $paginator_tmp = clone $paginator;
                $string .= sprintf(
                    $template,
                    $class,
                    $paginator_tmp->appends([$this->sort_by_variable => $name, $this->sort_type_variable => $sort_type_this])->url($paginator_tmp->currentPage()),
                    $title
                );
            } else {
                $string .= sprintf($templateDisabled, 'order-disabled', $title);
            }
        }

        echo $string;
    }

    public function sortBySelect($data, $configForm)
    {
        $headings = $data['headings'];
        $paginator = $data['paginator'];
        $config = (isset($data['config'])) ? $data['config'] : [];

        $sort_by = (isset($config['sort_by'])) ? $config['sort_by'] : Request::get($this->sort_by_variable);

        $dataSelect = [];
        foreach ($headings as $heading) {
            $name = (isset($heading['name']))  ? $heading['name'] : '';
            $title = (isset($heading['title'])) ? $heading['title'] : '';
            $sort = (isset($heading['sort']))  ? $heading['sort'] : true;

            if ($sort == true) {
                $dataSelect[$name] = $title;
            }
        }

        echo \Form::select($this->sort_by_variable, $dataSelect, $sort_by, $configForm);
    }

    public function sortTypeSelect($data, $configForm)
    {
        $headings = $data['headings'];
        $paginator = $data['paginator'];
        $config = (isset($data['config'])) ? $data['config'] : [];

        $sort_type = (isset($config['sort_type'])) ? $config['sort_type'] : Request::get($this->sort_type_variable);

        $dataSelect = ['ASC' => 'ASC', 'DESC' => 'DESC'];

        echo \Form::select($this->sort_by_variable, $dataSelect, $sort_type, $configForm);
    }
}
