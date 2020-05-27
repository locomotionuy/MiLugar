// JavaScript Document
$(window).load(function(){
$(function() {

    /*
    Gets the n previous elements
    The last element is considered previous to the first element
    If "me" is true, include this element in the list as well
    */
    
    $.fn.prevLoop = function(n, me) {
        var $cur = this,
            results = [];
        if (me) results.unshift($cur[0]);
        while (n-- > 0) {
            $cur = $cur.prev();
            if (!$cur.length) { //We were at the first element
                $cur = this.parent().children().last(); //Go to the last element
            }
            results.unshift($cur[0]);
        }
        return $(results);
    };

    /*
    Gets the n next elements
    The first element is considered next after the first element
    If "me" is true, include this element in the list as well
    */

    
    $.fn.nextLoop = function(n, me) {
        var $cur = this,
            results = [];
        if (me) results.push($cur[0]);
        while (n-- > 0) {
            $cur = $cur.next();
            if (!$cur.length) { //We were at the last element
                $cur = this.parent().children().first(); //Go to the first element
            }
            results.push($cur[0]);
        }
        return $(results);
    };


    // User specified properties
    var numSlide = 2;
    var rowSize = 6; // # of elements to display at a time
    var marginRight = 20; // Amount of margin between elements
    var rowScroll = false; // Bool which adds 1 element at a time, or a whole row (rowSize)
    var infinite = true;

    // Container properties
    var container = $('#carousel_container');
    container.find('ul').wrap('<div id="carousel_inner" />'); // Wraps our hidden container. Order matters
    var containerInner = $('#carousel_inner');
    var ul = container.find('ul');
    var li = container.find('li');
    var numElements = li.size(); // Total # of elements
    var thumbWidth = li.innerWidth(); // Width of thumbnails
    var thumbHeight = li.outerWidth(); // Height of thumbnails
    var panelWidth = ((rowSize * thumbWidth) + (marginRight * (rowSize - 1))); // Size up our container
    var leftArrow = $('<div class="arrow_left"><a id="left" href="#"><img src="imagenes/transparent.png" width="41" height="41" /></a></div>');
    var rightArrow = $('<div class="arrow_right"><a id="right" href="#"><img src="imagenes/transparent.png" width="41" height="41" /></a></div>');

    // Initial resizing
    container.show(); // It's initially set to display:none in case user has js disabled
    containerInner.width(panelWidth); // Set ul width
    containerInner.height(thumbHeight); // Set ul height
    container.prepend(leftArrow.css('padding-right', 0));
    container.append(rightArrow.css('padding-left', 0));

    li.css('margin-right', marginRight); // Set user specified margin
    li.css('height', thumbHeight).css('width', thumbWidth); // Set width and height of li elements (based off of thumbnail sizes)
    containerInner.hide().fadeIn();

    function rightClick() {
        var cfirst = container.find('li').first(), //the current first element
            tomove = cfirst.nextLoop(numSlide - 1, true), //the elements that need to move
            nfirst = tomove.last().nextLoop(1, false); //the new first element

        /*
           Pretend we currently have [A, B, C, D, E, F, G, H, I] and numSlide is 3
           cfirst === [A]
           tomove === [A, B, C]
           nfirst === [D]
        */

        var indent = cfirst.offset().left - nfirst.offset().left;

        if (infinite) {
        ul.not(':animated').animate({ // not:animated makes sure we only get one @ a time
            'left': indent
        }, 'fast', function() {
            tomove.appendTo(ul); //Move them to the end of the UL
            ul.css({ // left indent of ul
                'left': 0
            });
        });
    } else {
        alert('infinite is turned off');
    }
}

    function leftClick() {
        var cfirst = container.find('li').first(), //the current first element
            tomove = cfirst.prevLoop(numSlide, false), //the elements that need to move
            nfirst = tomove.first(); //the new first element

        /*
           Pretend we currently have [A, B, C, D, E, F, G, H, I] and numSlide is 3
           cfirst === [A]
           tomove === [G, H, I]
           nfirst === [G]
        */
        
        tomove.insertBefore(cfirst); //Move them to the front of the UL

        var indent = cfirst.offset().left - nfirst.offset().left;

        ul.not(':animated').css('left', -indent).animate({
            'left': 0
        }, 'fast', function() {
            ul.css({
                'left': 0
            });
        });
    }

    $('#right').click(function() {
        rightClick();
        return false;
    });

    $('#left').click(function() {
        leftClick();
        return false;
    });

});
});//]]>  