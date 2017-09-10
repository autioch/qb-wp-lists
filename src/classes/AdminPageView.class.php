<?php

class qbWpListsAdminPageView
{
    protected $edit;
    protected $collection;
    protected $listColumns;

    public function __construct($collection, $messages)
    {
        $this->$collection = $collection;
        $this->$messages = $messages;
        $this->listColumns = $collection['listColumns'];
        $this->page = QBWPLISTS_ID . $collection['id'];
    }

    public function renderForm($form, $mode = 'edit')
    {
        $modeTitle =  $mode == 'edit' ? 'Edycja' : 'Dodawanie';
        echo '<h3>' ,$this->collection['title'] , ' - ', $modeTitle  ,'</h3>' , $this->messages->show();

        $form->render();
    }

    public function renderList($itemList){
        echo '<h3>' ,$this->collection['title'] , ' (', count($itemList), ')' ,'</h3>' , $this->messages->show();

        include qbWpListsFindTemplate('adminPage');
    }
}
