<?php
/**
 * Plugin element to render mootools slider
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.element.slider
 * @copyright   Copyright (C) 2005-2013 fabrikar.com - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

require_once JPATH_SITE . '/components/com_fabrik/models/element.php';

//$document = JFactory::getDocument();
// $document->addScript(JURI::base() .'plugins/fabrik_element/handsontable/handsontable.js');
// $document->addScript(JURI::base() .'../plugins/fabrik_element/handsontable/handsontable.js');
/**
 * Plugin element to render mootools slider
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.element.slider
 * @since       3.0
 */

class PlgFabrik_ElementJstree extends PlgFabrik_Element
{
	/**
	 * If the element 'Include in search all' option is set to 'default' then this states if the
	 * element should be ignored from search all.
	 * @var bool  True, ignore in extended search all.
	 */
	protected $ignoreSearchAllDefault = true;

	/**
	 * Db table field type
	 *
	 * @var string
	 */
	protected $fieldDesc = 'TEXT';

	/**
	 * Db table field size
	 *
	 * @var string
	 */
	//protected $fieldSize = '6';

	/**
	 * Draws the html form element
	 *
	 * @param   array  $data           To pre-populate element with
	 * @param   int    $repeatCounter  Repeat group counter
	 *
	 * @return  string	elements html
	 */

	public function render($data, $repeatCounter = 0)
	{
			FabrikHelperHTML::stylesheet(COM_FABRIK_LIVESITE . 'plugins/fabrik_element/jstree/themes/default/style.min.css');
			//FabrikHelperHTML::script(COM_FABRIK_LIVESITE . 'plugins/fabrik_element/jstree/jstree.js');
			//FabrikHelperHTML::addScriptDeclaration('requirejs(["' . COM_FABRIK_LIVESITE . 'plugins/fabrik_element/jstree/jstree.js"], function () {});');
			//FabrikHelperHTML::addScriptDeclaration('require(["jquery"], function( $ ) { console.log( jQuery ) // OK});');
			//$srcs = FabrikHelperHTML::framework();
			//$srcs[]	= 'plugins/fabrik_element/handsontable/handsontable.js';
			//$js .= $model->getPluginJsObjects();
			//$js .= $model->getFilterJs();
			//FabrikHelperHTML::script($srcs, $js);
			
			
		
		$name = $this->getHTMLName($repeatCounter);
		$id = $this->getHTMLId($repeatCounter);
		$params = $this->getParams();
		//$default = (string) $params->get('default');
		$element = $this->getElement();
		$val = $this->getValue($data, $repeatCounter);
		$options = $this->getElementJSOptions($repeatCounter);
		$default = $options->defaultVal;
		$noteditable=0;
		
		if (!$this->isEditable())
		{
			//return $val;
			$noteditable= 1;
			
		}
		
		$str = array();
		//$str[] = '<script src="' . COM_FABRIK_LIVESITE  .'media/com_fabrik/js/element.js"></script>';
		$str[] = '<script src="' . COM_FABRIK_LIVESITE  .'plugins/fabrik_element/jstree/jstree.js"></script>';
		if($noteditable != 1){$str[] = '<div class="btn-group"><button type="button" class="btn btn-default btn-small" onclick="jstree_create();"><i class="icon-file-plus"></i> File</button>
						<button type="button" class="btn btn-default btn-small" onclick="jstree_create_folder();"><i class="icon-folder-plus"></i> Folder</button>
						<button type="button" class="btn btn-default btn-small" onclick="jstree_rename();"><i class="icon-pencil"></i> Rename</button></div>
						<div class="btn-group"><button type="button" class="btn btn-danger btn-small" onclick="jstree_delete();"><i class="icon-remove"></i> Delete</button>
						<button type="button" class="btn btn-success btn-small" onclick="jstree_get();"><i class="icon-save"></i> Save</button></div>';
					$dnd = ", 'dnd' , 'contextmenu'";
					}
				else{
				$dnd = "";
				}
		//if(($colsort == "true")|| ($colmove == "true")||($colresize == "true")){$str[] = '<a class="reset-state btn btn-small" href="javascript:none;"> <span class="icon-refresh"></span> Reset</a>';}
		$str[] = '<div class="fabrikSubElementContainer"><br />';
		$str[] = '<div id="' . $id . '" ></div>';
		//FabrikHelperHTML::addPath(COM_FABRIK_BASE . 'plugins/fabrik_element/slider/images/', 'image', 'form', false);

		
		if(!$val){
		
				if($default){ 
				
				$val = $default;
				
				}
				
				else{
				
				$val =" ['Project']";
		
				 }
			}
		
		elseif ($val) { $val = print_r($val, TRUE); }
		
		//if(!$columns){ $columns = "["; for($k=1;$k<$hcols;$k++)  { $columns .= "&#123; &#125;,"; } $columns .= "&#123; &#125;]"; $columns = html_entity_decode($columns);}
		//if(($colhead == "true") && ($colheaddata)){ $colhead = $colheaddata;}
		//$str[] = '<pre>'.print_r($options).'</pre>';
		$valueprinted = $val;
		$str[] = '<script>';
		$str[] = 'require(["jquery"], function( $ ) {';
		$str[] = "$(function () {
							$('#". $id . "')
								.jstree({
									'core' : {
										'animation' : 250,
										'check_callback' : true,
										'themes' : { 'stripes' : true },
										        'data' : " . $valueprinted . "
									},
									'types' : {
								
										'folder' : { 'icon' : 'icon-folder' , 'valid_children' : ['folder','file'] },
										'file' : { 'icon' : 'icon-file', 'valid_children' : [] }
									},
									'contextmenu' : {
									
									'items' : {
									
													'folder' : {
														'separator_before'	: false,
														'separator_after'	: true,
														'icon'				: 'icon-folder-plus',
														'_disabled'			: false, //(this.check('create_node', data.reference, {}, 'last')),
														'label'				: 'Folder',
														'action'			: function () {
															jstree_create_folder();
														}
													},
													'file' : {
														'separator_before'	: false,
														'separator_after'	: true,
														'icon'				: 'icon-file-plus',
														'_disabled'			: false, //(this.check('create_node', data.reference, {}, 'last')),
														'label'				: 'File',
														'action'			: function () {
															jstree_create();
														}
													},
													'rename' : {
														'separator_before'	: false,
														'icon'				: 'icon-pencil',
														'separator_after'	: false,
														'_disabled'			: false, //(this.check('rename_node', data.reference, this.get_parent(data.reference), '')),
														'label'				: 'Rename',
														/*
														'shortcut'			: 113,
														'shortcut_label'	: 'F2',
														'icon'				: 'glyphicon glyphicon-leaf',
														*/
														'action'			: function (data) {
															var inst = $.jstree.reference(data.reference),
																obj = inst.get_node(data.reference);
															inst.edit(obj);
														}
													},
													'remove' : {
														'separator_before'	: false,
														'icon'				: 'icon-remove',
														'separator_after'	: false,
														'_disabled'			: false, //(this.check('delete_node', data.reference, this.get_parent(data.reference), '')),
														'label'				: 'Delete',
														'action'			: function () {
															jstree_delete();
														}
													},
													'ccp' : {
														'separator_before'	: true,
														'icon'				: false,
														'separator_after'	: false,
														'label'				: 'Edit',
														'action'			: false,
														'submenu' : {
															'cut' : {
																'separator_before'	: false,
																'icon'				: 'icon-scissors',
																'separator_after'	: false,
																'label'				: 'Cut',
																'action'			: function (data) {
																	var inst = $.jstree.reference(data.reference),
																		obj = inst.get_node(data.reference);
																	if(inst.is_selected(obj)) {
																		inst.cut(inst.get_selected());
																	}
																	else {
																		inst.cut(obj);
																	}
																}
															},
															'copy' : {
																'separator_before'	: false,
																'icon'				: 'icon-save-copy',
																'separator_after'	: false,
																'label'				: 'Copy',
																'action'			: function (data) {
																	var inst = $.jstree.reference(data.reference),
																		obj = inst.get_node(data.reference);
																	if(inst.is_selected(obj)) {
																		inst.copy(inst.get_selected());
																	}
																	else {
																		inst.copy(obj);
																	}
																}
															},
															'paste' : {
																'separator_before'	: false,
																'icon'				: 'icon-file',
																'_disabled'			: function (data) {
																	return !$.jstree.reference(data.reference).can_paste();
																},
																'separator_after'	: false,
																'label'				: 'Paste',
																'action'			: function (data) {
																	var inst = $.jstree.reference(data.reference),
																		obj = inst.get_node(data.reference);
																	inst.paste(obj);
																}
															}
														}
													}
				
												}
									
									},
									'plugins' : [ 'unique' , 'search', 'state', 'types' " . $dnd . " ]
								});
						});			
						});	";
		$str[] = "function jstree_get() {
							var ref = $('#". $id . "').jstree(true),
								jsel = ref.get_json();
								jseltmp = JSON.stringify(jsel);
								$('#tree" . $id . "').val(jseltmp);
							
						};
						function jstree_create() {
							 var ref = $('#". $id . "').jstree(true),
								sel = ref.get_selected();
							if(!sel.length) { return false; }
							sel = sel[0];
							sel = ref.create_node(sel, {'type':'file'});
							if(sel) {
								ref.edit(sel);
							}
						};
						function jstree_create_folder() {
							var ref = $('#". $id . "').jstree(true),
								sel = ref.get_selected();
							if(!sel.length) { return false; }
							sel = sel[0];
							sel = ref.create_node(sel, {'type':'folder'});
							if(sel) {
								ref.edit(sel);
							}
						};
						function jstree_rename() {
							var ref = $('#". $id . "').jstree(true),
								sel = ref.get_selected();
							if(!sel.length) { return false; }
							sel = sel[0];
							ref.edit(sel);
						};
						function jstree_delete() {
							var ref = $('#". $id . "').jstree(true),
								sel = ref.get_selected();
								refl = ref.get_parent(sel);
							if(!sel.length || refl == '#') {return false; }
							ref.delete_node(sel);
							//console.log(refl.length);
						};";
		$str[] = '</script>';
		//$val2 = str_replace('\'','\\\\\'',$val);
		//$str[] = '<input type="hidden" id="save' .$id. '" class="fabrikinput" name="' . $name . '" value=\'' . str_replace("&quot;", "`",$val) . '\' />';
		$str[] = '<textarea style="display:none;" rows="10" cols="10" id="tree' .$id. '" name="' . $name . '">' . $valueprinted . '</textarea>';
		$str[] = '</div>';

		return implode("\n", $str);
	}
	
	/**
	 * Shows the data formatted for the list view
	 *
	 * @param   string    $data      elements data
	 * @param   stdClass  &$thisRow  all the data in the lists current row
	 *
	 * @return  string	formatted value
	 */

	public function renderListData($data, stdClass &$thisRow)
	{
		unset($this->default);
		$value = $this->getValue(JArrayHelper::fromObject($thisRow));
		return parent::renderListData(JText::_('PLG_ELEMENT_JSTREE_DETAIL_MESSG'), $thisRow);
	}


	/**
	 * Manipulates posted form data for insertion into database
	 *
	 * @param   mixed  $val   This elements posted form data
	 * @param   array  $data  Posted form data
	 *
	 * @return  mixed
	 */

	public function storeDatabaseFormat($val, $data)
	{
		// If clear button pressed then store as null.
		if ($val == '')
		{
			$val = null;
		}

		return $val;
	}

	/**
	 * Returns javascript which creates an instance of the class defined in formJavascriptClass()
	 *
	 * @param   int  $repeatCounter  Repeat group counter
	 *
	 * @return  array
	 */

	 public function elementJavascript($repeatCounter)
	{
		$params = $this->getParams();
		$id = $this->getHTMLId($repeatCounter);
		$opts = $this->getElementJSOptions($repeatCounter);
		//$opts->steps = (int) $params->get('slider-steps', 100);
		$data = $this->getFormModel()->data;
		$opts->value = $this->getValue($data, $repeatCounter);

		return array('FbJstree', $id, $opts);
	} 
}
