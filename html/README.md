WORK IN PROGRESS


REQUIREMENTS	

PC, VPS, VM, or CT with a standard LEMP stack (Linux/NginX/MariaDB/PHP).


PROGRAM FUNCTIONS

recipes

	browse, create, update, and delete recipes

		recipe name: text in brackets doesn't print, it's used to identify recipe variations (e.g. "Chocolate chip cookies", "Chocolate chip cookies [2]").

		The selected recipe is used for ananlysis and printing.

ingredients

	browse, create, update, and delete ingredients.

	Enter the "Nutrition Facts" panel from your pantry items to use in recipes. Fresh ingredients don't usually have Nutrition Facts panels, it's up to you to research the appropriate figures. 

nutrients

	Interactive Nutrition Facts panel

	Click on any nutrient (such as "Saturated Fat") to see which of the recipe's ingredients contributes to the total for that nutrient per recipe, and per serving.

PDA
	
	Principal Display Area. 

	The complete package label for the recipe, including Statement of Identity, Ingredients, Allergens, Production Date, Producer, Disclaimers, Net Weight and Nutrition Facts.

	Requires 2-up half-sheet labels (8.5 x 5.5) for printing.

About

	Title, Copyright, License, and Link to Github.





STATISTICAL TYPESETTING IN COMPUTED HTML

Computed HTML is a method of web development in which the tags describing complex layouts are compiled in RAM and submitted to the browser's HTML interpreter as a batch. 

The cycle time between compilation and rendering is so short, the entire layout can be recalculated when any of its inputs (such as the contents of a database or the dimensions of the browser window) changes. 


nutricalc/

	html/

		a/	assets

			f/	fonts

			k/	icons

		i/	includes

		j/	javascript

		s/	css

		index.php

	src/
		sources

	install/

		sql/

		nginx/









