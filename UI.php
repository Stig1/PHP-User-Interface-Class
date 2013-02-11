<?php
/**
* UI/HTMLElement - makes HTML outputting using PHP a breeze.
*
* @author 		Stig Rune Grønnestad
* @copyright	Stig Rune Grønnestad @ 2013
* @version		1.1
*
*/

	/**
	* This class is used only as a HTMLElement factory,
	* the name is short to make our code less bloat.
	 */
	class UI {
		/**
		 * HTMLElement fabrication. This class makes it possible to initialize
		 * objects using UI::div(), UI::table() and so forth.
		 * @param  [string] $function "Function" or name of the element to fabricate
		 * @param  [type] $vars     not used
		 * @return [HTMLElement]
		 */
		public static function __callStatic($function, $vars) {
			return new HTMLElement($function);
		}
	}

	/**
	 * HTMLElement represents a single html element.
	 */
	class HTMLElement {
		/**
		 * Constructor for the base HTMLElement
		 * @param [string] $tag tag name
		 */
		public function __construct($tag) {
			$this->tag = $tag;
			$this->inner = "";
			$this->children = [];
			$this->attributes = [];

			return $this;
		}

		/**
		 * Override call function to have it set attributes on the element instead
		 * @param  [string] $name      attribute name
		 * @param  [mixed] $arguments attribute value
		 * @return [HTMLElement]	 self
		 */
		public function __call($name, $arguments) {
			$name = strtolower($name);
			$reserved = array("tag", "inner", "children");

			if (in_array($name, $reserved)) {
				// Handle local properties.
				$this->$name = $arguments[0];
			} else {
				// Handle attributes on the element.
				if (trim($arguments[0])) {
					$name = str_replace("_", "-", $name);
					$this->attributes[$name] = $arguments[0];
				}
			}

			return $this;
		}

		/**
		 * Print out the HTML for the element when used as string
		 * @return string HTML of element
		 */
		public function __toString() {
			$html = "<{$this->tag}";

			// Add all the attributes
			foreach ($this->attributes as $key => $value) {
				$html .= " {$key}=\"{$value}\"";
			}
			$html .= ">";

			// Add the inner html
			$html .= $this->inner;

			// Add children
			foreach ($this->children as $element) {
				$html .= $element;
			}

			// Close the tag
			$html .= "</{$this->tag}>";

			return $html;
		}
	}
?>