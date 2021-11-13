<?php

namespace GuiSaldanha\FormBuilder;

class Form
{

	/**
	 * Método HTTP que o formulário será enviado
	 *
	 * @var string
	 */
	public string $method;

	/**
	 * Arquivo ou URL para onde os dados do formulário será enviados
	 *
	 * @var string
	 */
	public string $action;

	/**
	 * Texto do botão submit do formulário
	 *
	 * @var string
	 */
	public string $actionName;

	/**
	 * Campos do formulário
	 *
	 * @var string
	 */
	private string $fields;

	/**
	 * Identificador usado para mostrar ou não a tag label no formulário
	 *
	 * @var boolean
	 */
	private bool $hideLabel = false;

	/**
	 * Identificar usado para exibir ou não o placeholder
	 *
	 * @var boolean
	 */
	private bool $hidePlaceholder = false;

	/**
	 * Construtor da classe
	 *
	 * @param string $method		Deverá ser passado GET ou POST
	 * @param string $action		Arquivo ou URL para onde o formulário será submetido
	 * @param string $actionName	Nome da ação do botão submit. Ex. "Cadastrar", "Enviar" etc.
	 */
	public function __construct($method,$action,$actionName)
	{
		$this->method     = $method;
		$this->action     = $action;
		$this->actionName = $actionName;
		$this->fields     = '';
		$this->options    = [];
	}

	/**
	 * Método responsável por construir o formulário
	 *
	 * @return string
	 */
	public function create()
	{
		$form = self::getBeginForm($this->method,$this->action);

		$form .= $this->fields;

		$form .= self::getEndForm($this->actionName);

		return $form;
	}

	/**
	 * Adiciona campos ao formulário
	 *
	 * @param string $name		Parâmetro name do campo
	 * @param string $txt		Texto identificador do campo
	 * @param string $type		Tipo do campo, tipos suportados: select, radio, checkbox, textarea, text, file
	 * @param array $options	Opções para os campos do tipo select e radio
	 */
	public function addField($name,$txt,$type='text',$options=[])
	{
		$required = strpos($name,'*')!==false ? ' required' : '';
		$name = str_replace('*','',$name);
		switch ($type) {
			case 'select':
				$form = $this->getSelect($name,$txt,$options,$required);
				break;
			case 'radio':
				$form = $this->getRadio($name,$txt,$options,$required);
				break;
			case 'checkbox':
				$form = $this->getCheckbox($name,$txt,$required);
				break;
			case 'textarea':
				$form = $this->getTextarea($name,$txt,$required);
				break;
			
			default:
				$form = $this->getInput($name,$txt,$type,$required);
				break;
		}

		$this->fields .= $form;
		
	}

	/**
	 * Método responsável por montar o HTML do select
	 *
	 * @param string $name
	 * @param string $txt
	 * @param array $options
	 * @return string
	 */
	private function getSelect($name,$txt,$options,$required)
	{
		$form = '<div>';
		$form .= $this->getHideLabel() ? '' : '<label for="'.$name.'">'.$txt.'</label>';
		$form .= '<select name="'.$name.'" id="'.$name.'" '.$required.'>';
		$form .= $this->getHidePlaceholder() ? '' : '<option value="" disabled selected hidden>'.$txt.'</option>';
			foreach ($options as $key => $value) {
				$form .= '<option value="';
				$form .= is_numeric($key) ? $value : $key;
				$form .= '">'.$value.'</option>';
			}
		$form .= '</select>';
		$form .= '</div>';
		return $form;
	}
	
	/**
	 * Método responsável por montar o HTML do radio option
	 *
	 * @param string $name
	 * @param string $txt
	 * @param array $options
	 * @return string
	 */
	private function getRadio($name,$txt,$options,$required)
	{
		$form = '<div>';
		$form .= $this->getHideLabel() ? '' : '<p>'.$txt.'</p>';
		foreach ($options as $key => $value) {
			$form .= '<input type="radio" name="'.$name.'" value="';
			$form .= is_numeric($key) ? $value : $key;
			$form .= '" id="'.$key.'"/>';
			$form .= '<label for="'.$key.'">'.$value.'</label>';
		}
		$form .= '</div>';
		return $form;
	}

	/**
	 * Método responsável por montar o HTML do checkbox
	 *
	 * @param string $name
	 * @param string $txt
	 * @return string
	 */
	private function getCheckbox($name,$txt,$required)
	{
		$form = '<div>';
		$form .= '<input type="checkbox" name="'.$name.'" id="'.$name.'" value="'.$txt.'" '.$required.'/>';
		$form .= '<label for="'.$name.'">'.$txt.'</label>';
		$form .= '</div>';
		return $form;
	}
	
	/**
	 * Método responsável por montar o HTML do textarea
	 *
	 * @param string $name
	 * @param string $txt
	 * @return string
	 */
	private function getTextarea($name,$txt,$required)
	{
		$form = '<div>';
		$form .= $this->getHideLabel() ? '' : '<label for="'.$name.'">'.$txt.'</label>';
		$form .= '<textarea name="'.$name.'" id="'.$name.'"';
		$form .= $this->getHidePlaceholder() ? '' : ' placeholder="'.$txt.'"';
		$form .= $required.' cols="50" rows="10"></textarea>';
		$form .= '</div>';
		return $form;
	}

	/**
	 * Método responsável por montar o HTML do input
	 *
	 * @param string $name
	 * @param string $txt
	 * @param string $type
	 * @return string
	 */
	private function getInput($name,$txt,$type,$required)
	{
		$form = '<div>';
		$form .= $this->getHideLabel() ? '' : '<label for="'.$name.'">'.$txt.'</label>';
		$form .= '<input type="'.$type.'" name="'.$name.'" id="'.$name.'"';
		$form .= $this->getHidePlaceholder() ? '' : ' placeholder="'.$txt.'"';
		$form .= $required.' />';
		$form .= '</div>';
		return $form;
	}

	/**
	 * Método responsável pelo início do formulário
	 *
	 * @param string $method
	 * @param string $action
	 * @return string
	 */
	private static function getBeginForm($method,$action)
	{
		$id = trim(str_replace(['/','.php','.html','.'],'-',$action),'-');
		$id = 'form'.ucwords($id);
		return '<form id="'.$id.'" method="'.$method.'" action="'.$action.'" enctype="multipart/form-data">';
	}

	/**
	 * Método responsável pelo final do formulário
	 *
	 * @param string $actionName
	 * @return string
	 */
	private static function getEndForm($actionName)
	{
		$form = '<button type="submit">'.$actionName.'</button>';
		$form .= '</form>';
		return $form;
	}

	/**
	 * Get identificador usado para mostrar ou não a tag label no formulário
	 *
	 * @return  boolean
	 */ 
	public function getHideLabel()
	{
		return $this->hideLabel;
	}

	/**
	 * Set identificador usado para mostrar ou não a tag label no formulário
	 *
	 * @param  boolean  $hideLabel  Identificador usado para mostrar ou não a tag label no formulário
	 *
	 * @return  self
	 */ 
	public function setHideLabel(bool $hideLabel)
	{
		$this->hideLabel = $hideLabel;

		return $this;
	}

	/**
	 * Get identificar usado para exibir ou não o placeholder
	 *
	 * @return  boolean
	 */ 
	public function getHidePlaceholder()
	{
		return $this->hidePlaceholder;
	}

	/**
	 * Set identificar usado para exibir ou não o placeholder
	 *
	 * @param  boolean  $hidePlaceholder  Identificar usado para exibir ou não o placeholder
	 *
	 * @return  self
	 */ 
	public function setHidePlaceholder(bool $hidePlaceholder)
	{
		$this->hidePlaceholder = $hidePlaceholder;

		return $this;
	}
}

?>