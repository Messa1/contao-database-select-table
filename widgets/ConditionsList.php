<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Matthias Gmeiner
 *
 * @license LGPL-3.0+
 */

namespace MatthiasGmeiner; 

/**
 * Provide methods to handle list items.
 *
 * @property integer $maxlength
 *
 */
class ConditionsList extends \Widget
{

	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget';
	
	/**
	 * Add specific attributes
	 *
	 * @param string $strKey
	 * @param mixed  $varValue
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'maxlength':
				if ($varValue > 0)
				{
					$this->arrAttributes['maxlength'] = $varValue;
				}
				break;
				
			case 'options':
				$this->arrUnits = deserialize($varValue);
				break;
			
			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}
	
	/**
	 * Validate the input and set the value
	 */
	public function validate()
	{
		$mandatory = $this->mandatory;
		$options = $this->getPost($this->strName);
		$options = array_values($options);
		$varInput = $this->validator($options);

		if (!$this->hasErrors())
		{
			$this->varValue = $varInput;
		}

		// Reset the property
		if ($mandatory)
		{
			$this->mandatory = true;
		}
	}
	
	
	/**
	 * Generate the widget and return it as string
	 *
	 * @return string
	 */
	public function generate()
	{
		$arrButtons = array('copy', 'drag', 'up', 'down', 'delete');
		$strCommand = 'cmd_' . $this->strField;

		// Change the order
		if (\Input::get($strCommand) && is_numeric(\Input::get('cid')) && \Input::get('id') == $this->currentRecord)
		{
			$this->import('Database');

			switch (\Input::get($strCommand))
			{
				case 'copy':
					array_insert($this->varValue, \Input::get('cid'), array($this->varValue[\Input::get('cid')]));
					break;

				case 'up':
					$this->varValue = array_move_up($this->varValue, \Input::get('cid'));
					break;

				case 'down':
					$this->varValue = array_move_down($this->varValue, \Input::get('cid'));
					break;

				case 'delete':
					$this->varValue = array_delete($this->varValue, \Input::get('cid'));
					break;
			}

			$this->Database->prepare("UPDATE " . $this->strTable . " SET " . $this->strField . "=? WHERE id=?")
						   ->execute(serialize($this->varValue), $this->currentRecord);

			$this->redirect(preg_replace('/&(amp;)?cid=[^&]*/i', '', preg_replace('/&(amp;)?' . preg_quote($strCommand, '/') . '=[^&]*/i', '', \Environment::get('request'))));
		}
		
		// Make sure there is at least an empty array
		if (!is_array($this->varValue) || empty($this->varValue))
		{
			$this->varValue = array('');
		}
		
		// Initialize the tab index
		if (!\Cache::has('tabindex'))
		{
			\Cache::set('tabindex', 1);
		}

		$tabindex = \Cache::get('tabindex');
		
		$this->import('Database');
		$table = $this->objDca->activeRecord->db_select_datenbank;
						
		// Begin the table
		$return = '<table class="tl_optionwizard" id="ctrl_'.$this->strId.'">
  <thead>
    <tr>
      <th>'.$GLOBALS['TL_LANG']['MSC']['db_field'].'</th>
	  <th>'.$GLOBALS['TL_LANG']['MSC']['db_value'].'</th>
	  <th>'.$GLOBALS['TL_LANG']['MSC']['db_operator'].'</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody class="sortable" data-tabindex="'.$tabindex.'">';

		// Add fields
		for ($i=0, $c=count($this->varValue); $i<$c; $i++)
		{
						
			$return .= '
    <tr>
       <td><select type="select" name="'.$this->strId.'['.$i.'][key]" id="'.$this->strId.'_key_'.$i.'" class="tl_text_2" tabindex="'.$tabindex++.' onfocus="Backend.getScrollOffset()"">';
	  
	  		$return .=
			
			$table_field = $this->Database->getFieldNames($table);
						
			if (!empty($table_field)) {
			
				foreach ($table_field as $arrUnit)
				{
				
				if (isset($this->varValue[$i]['key'])) {	
					if($arrUnit === $this->varValue[$i]['key']) 
					{
						$return .= '<option value="'.specialchars($arrUnit).'" selected="selected">'.$arrUnit.'</option>';
						$activeField = $arrUnit;
					}
					else 
					{
						$return .= '<option value="'.specialchars($arrUnit).'">'.$arrUnit.'</option>';
					}
				}
				else 
					{
						$return .= '<option value="'.specialchars($arrUnit).'">'.$arrUnit.'</option>';
					}
					
				}
			
			}	
			
			$return .= '</td>
	  
	  <td><select type="select" name="'.$this->strId.'['.$i.'][key_2]" id="'.$this->strId.'_key_2'.$i.'" class="tl_text_2" tabindex="'.$tabindex++.' onfocus="Backend.getScrollOffset()"">';
	  
	  		$return .=

			$this->import('Database'); 
			
			if(!empty($activeField)){
			
				$availableFields = $this->Database->prepare("SELECT ".$activeField." FROM ".$table." ")->execute();
							
				$table_field = array();
				
				while($availableFields->next())
				{
				  $table_field[] = $availableFields->$activeField;
				}
				
				if (!empty($table_field)) {
						
				foreach ($table_field as $arrUnit)
				{
				
				if (isset($this->varValue[$i]['key_2'])) {		
					if($arrUnit === $this->varValue[$i]['key_2']) 
					{
						$return .= '<option value="'.specialchars($arrUnit).'" selected="selected">'.$arrUnit.'</option>';
					}
					else 
					{
						$return .= '<option value="'.specialchars($arrUnit).'">'.$arrUnit.'</option>';
					}
				}
				else 
					{
						$return .= '<option value="'.specialchars($arrUnit).'">'.$arrUnit.'</option>';
					}
					
				}
				
				}
			
			}
			
			$return .= '</td>
	  
      <td><select type="select" name="'.$this->strId.'['.$i.'][operator]" id="'.$this->strId.'_operator_'.$i.'" class="tl_text_2" tabindex="'.$tabindex++.' onfocus="Backend.getScrollOffset()"">';
	  
	  		$return .=
			
			$arrUnits = array();

			foreach ($this->arrUnits as $arrUnit)
			{
			
			if (isset($this->varValue[$i]['operator'])) {
				if($arrUnit['value'] === $this->varValue[$i]['operator']) 
					{
						$return .= '<option value="'.specialchars($arrUnit['value']).'" selected="selected">'.$arrUnit['label'].'</option>';
					}
				else 
					{
						$return .= '<option value="'.specialchars($arrUnit['value']).'">'.$arrUnit['label'].'</option>';
					}
			}
			else 
				{
					$return .= '<option value="'.specialchars($arrUnit['value']).'">'.$arrUnit['label'].'</option>';
				}
				
			}
			
			$return .= '</select></td>';

			// Add row buttons
			$return .= '
      <td style="white-space:nowrap;padding-left:3px">';

			foreach ($arrButtons as $button)
			{
				$class = ($button == 'up' || $button == 'down') ? ' class="button-move"' : '';

				if ($button == 'drag')
				{
					$return .= \Image::getHtml('drag.gif', '', 'class="drag-handle" title="' . sprintf($GLOBALS['TL_LANG']['MSC']['move']) . '"');
				}
				else
				{
					$return .= ' <a href="'.$this->addToUrl('&amp;'.$strCommand.'='.$button.'&amp;cid='.$i.'&amp;id='.$this->currentRecord).'"' . $class . ' title="'.specialchars($GLOBALS['TL_LANG']['MSC']['mw_'.$button]).'" onclick="Backend.moduleWizard(this,\''.$button.'\',\'ctrl_'.$this->strId.'\');return false">'.\Image::getHtml($button.'.gif', $GLOBALS['TL_LANG']['MSC']['mw_'.$button], 'class="tl_listwizard_img"').'</a>';
				}
			}

			$return .= '</td>
    </tr>';
		}

		// Store the tab index
		\Cache::set('tabindex', $tabindex);

		return $return.'
  </tbody>
  </table>';
	}
}
