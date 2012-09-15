<?php
/*
* PHP User Interface Class
*
* @author 		Stig Rune
* @version		1.0
* 
*/
?>

<?php
	/*
		This class is used only as a HTMLElement factory,
		the name is short to make our code less bloat.
	 */
	class UI {
		public static function __callStatic($function, $vars) {
			return new HTMLElement($function);
		}
	}

	/*
		HTMLElement represents a single html element.
	 */
	class HTMLElement {
		public function __construct($tag) {
			$this->tag = $tag;
			$this->inner = "";
			$this->children = [];
			$this->attributes = [];

			return $this;
		}

		// Overloaded __call to make dynamic handling of attributes.
		public function __call($name, $arguments) {
			$name = strtolower($name);
			$reserved = array("tag", "inner", "children");

			if (in_array($name, $reserved)) {
				// Handle local properties.
				$this->$name = $arguments[0];
			} else {
				// Handle attributes on the element.
				if (trim($arguments[0])) {
					$this->attributes[$name] = $arguments[0];
				}
			}

			return $this;
		}

		// Overloaded __toString to make the representation 
		// of the class HTML text.
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