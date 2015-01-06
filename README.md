mini-startcraft-school
======================

School Project



###### Gameplay #######

--- Challenges ---

Each Character has certain Properties.
$health;
$stamina;
$speed;
$strength;

Each one of the 3 different Characters, Terrans, Protoss and Zerg have different values
for each property.

For example:

Protoss has the following values:

$health; = 100
$stamina; = 40
$speed; = 30
$strength; 50

(parent::__construct('Protoss',100,40,30,50);)

We also have different Items (Potions) that are used to INCREASE the Properties of the Characters.

	For example, if a Character receives the Stamina Potion, that Potion will increase the $stamina property of its owner.
	We can use the Protoss Character again as an example:

	The Character has a $stamina = 40 and it receives a Stamina Potion, which has a property of $stamina = 10.
	The two $stamina values will be added and now the Protoss has a $stamina value of 50.
	
The Challenges have also same properties, but here the values represent the Challenge.

	Let's continue on same example so we choose a Challenge that has $stamina = 200 as a property.
	The Player that Nulls that will win the Challenge.
	
	- Player 1 (Protoss) $stamina = 50
	- Player 2 (Terrans) $stamina = 30 
	- Player 3 (Zerg) $stamina = 25 
	
	- Challenge 1 $stamina = 200
	
	
	1. Player 1 undertakes the Challenge
	200 - 50 = 150
	The Challenges $stamina property has been reduced to 150.
	Challenge continues
	
	2. Player 2 undertakes the Challenge
	150 - 30 = 120
	The Challenges $stamina property has been reduced to 120.
	Challenge continues.
	
	3. Player 3 undertakes the Challenge
	120 - 25 = 95
	The Challenges $stamina property has been reduced to 120.
	Challenge continues.
	
	* Since we have no winner, the Challenge continues and Player 1 has an another chance *
	
	4. Player 1 undertakes the Challenge
	95 - 50 = 45
	The Challenges $stamina property has been reduced to 45.
	Challenge continues.
	
	5. Player 2 undertakes the Challenge
	45 - 30 = 15
	The Challenges $stamina property has been reduced to 15.
	Challenge continues.
	
	6. Player 3 undertakes the Challenge
	15 - 25 = -10
	The Challenges $stamina property has been reduced to -10.
	Challenge ENDS.
	
	PLAYER 3 is the WINNER
	
	


