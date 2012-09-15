<?php
/*
* PHP User Interface Class
*/
?>

<?php
	class UI {
		public static function __callStatic($function, $vars) {
			return new HTMLElement($function);
		}
	}

	class HTMLElement {
		public function __construct($tag) {
			$this->tag = $tag;
			$this->inner = "";
			$this->children = [];
			$this->attributes = [];

			return $this;
		}

		public function __call($name, $arguments) {
			$name = strtolower($name);
			$reserved = array("tag", "inner", "children");

			if (in_array($name, $reserved)) {
				$this->$name = $arguments[0];
			} else {
				if (trim($arguments[0])) {
					$this->attributes[$name] = $arguments[0];
				}
			}

			return $this;
		}

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