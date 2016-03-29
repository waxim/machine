# Machine
A simple fruit machine written in PHP.

```php
/*
 * Add our reels, how many slots the reels have
 *
 * int reelSlots
 * bool canHold
 * bool canNudge
 */
$reels = [
    new Machine\Reel(200, 1, 0),
    new Machine\Reel(200, 1, 0),
    new Machine\Reel(200, 1, 0)
];

/*
 * Add a trail, set the function to run when trail is active.
 *
 * int trailLength
 * int award
 * int runs
 * function callbackFunction
*/
$trail = new Machine\Trail(12, 100, 5, function(){

    /*
     * A simple higher or lower function to run when the trail
     * is active. We need two buttons, a reel from 1 - 24
     * storage for previous number and conditions to test.
     *
     * if this callback returns false the trail ends.
    */
    $entry = new Machine\Button\Group(
        new Machine\Button("High", 1),
        new Machine\Button("Low", 2)
    );

    $n = new Machine\Reel\Number(24);
    $number = $number->spin();
    
    $previous = new Machine\Registry("previous-high-low", $number);
    
    if ($entry == 1 && $number > $previous){
        return true
    } else if ($entry == 2 && $number < $previous) {
        return true;
    } else {
        return false;
    }
});

/*
 * Add buttons to our machine, this will hold or nudge our reel.
*/
$button = new Machine\Button("Hold/Nudge", function($machine){
    $nudges = $machine->nudges();
    
    if ($nudges) {
        $machine->reel(1)->down(1);
    } else {
        $machine->reel(1)->toggleHold();
    }

    return true;
});

$button2 = new Machine\Button("Hold/Nudge", function($machine){
    $nudges = $machine->nudges();
    
    if ($nudges) {
        $machine->reel(2)->down(1);
    } else {
        $machine->reel(2)->toggleHold();
    }

    return true;
});

$button3 = new Machine\Button("Hold/Nudge", function($machine){
    $nudges = $machine->nudges();
    
    if ($nudges) {
        $machine->reel(3)->down(1);
    } else {
        $machine->reel(3)->toggleHold();
    }

    return true;
});

$collect = new Machine\Button("Collect", function(){
    return $machine->collect();
});

$buttons = new Machine\Button\Group([
    $button,
    $button2,
    $button3,
    $collect
]);

/*
 * Set some symbols for our machine to spin on its reels.
*/
$t = new Machine\Reel\Symbol;
$t->setName("tomato");

$x = new Machine\Reel\Symbol;
$x->setName("x");
$x->setPrize(10);

$o = new Machine\Reel\Symbol;
$o->setName("o");
$o->setPrize(20);

$bar = new Machine\Reel\Symbol;
$bar->setName("bar");
$bar->setPrize(50);

/*
 * Put our machine together.
*/
$machine = new Machine;

$machine->addReels($reels);

$machine->addSymbol($x);
$machine->addSymbol($o);
$machine->addSymbol($bar);
$machine->addSymbol($t);

$machine->addTrail($trail);

/*
 * how much does a spin cost.
*/
$machine->setSpin(5);

$machine->addButtons($buttons);

/*
 * Now add some credit it and spin.
*/
$machine->addCredit(100);
$machine->spin();
```
