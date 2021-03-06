PHP User Interface Class
========================

The UI class makes outputting large amounts of HTML from PHP a breeze.
You won't have to break in and out of the PHP tags ever again and end up with cluttered unreadable code.
The dynamic behaviour of the class makes it possible to create any HTML element with any number of given attributes,
children, inner texts and so on.

A tutorial explaining the process of making the class can be found here: http://xdevelopers.net/2012/09/how-to-use-phps-magic-methods/

Usage
-----

Simply make a static function call to UI where the function name represents the HTML element you want to create.

    $div = UI::div();
    print $div;

In HTML this translates to:

    <div></div>

To add attributes simply make a function call to the element where the function name represents the attribute
and the parameter represents the value.

  	$div = UI::div();
  	$div->id("myDiv");
  	$div->class("someClass");
  	print $div;

In HTML this translates to:

  	<div id="myDiv" class="someClass"></div>

By calling to inner (text as parameter) or children (array as parameter) you can add items as children of an element.
It's also possible to nest all these calls so having to create an object is not necessary.

  	print UI::div()->id("myDiv")->children([
      	    UI::p()->inner("This text is inside the p, as a children of #myDiv")
    	]);

In HTML this translates to:

  	<div id="myDiv"><p>This text is inside the p, as a children of #myDiv</p></div>

When working with attributes with a dash symbol like data-validation, just call the method as usual, but exchange the dash for a underscore; data_validation()
