<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_battle/tables');

class BattleViewWard extends JViewLegacy
{	
	function display($tpl = null)
	{
	//	$id = (int) JRequest::getVar('id', 0);
	
		
		$model = &$this->getModel();
		$model->enter_ward();
		
	//	echo '<pre>';
	//	print_r($model);
	//	echo '</pre>';

		parent::display($tpl);
	}
}
