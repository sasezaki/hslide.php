<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="prettify.css" rel="stylesheet" />
    <link type="text/css" href="basis.css" rel="stylesheet" />
    <title>スライドのタイトル</title>
</head>
<body>

<script type="text/javascript" src="jquery-1.4.2.js"></script>
<script type="text/javascript" src="prettify.js"></script>
<script type="text/javascript"><!--

var Slide = {

    current : 0,
    slides : null,

    init : function() {
        this.slides = $(".slide_wrapper").toArray();
        if (location.hash.match(/^#\d+$/)) {
            this.change(parseInt(location.hash.substring(1)) - 1);
        } else {
            this.first();
        }
    },

    change : function(index) {
        index = this.normalizeIndex(index);
        var direction = this.current <= index ? 1 : -1;
        var duration = 400;

        $(this.slides[this.current])
            .css({left : 0})
            .hide();
            //.show()
            //.animate({left : -direction * ($(document.body).width() + 50)}, duration);

        //$(this.slides).hide();
        this.current = index;


        $(this.slides[index])
            //.css({left : direction * $(this.slides[index]).width()})
            .css({left : 0})
            .show();
            //.animate({left : 0}, duration);

        $("#page").text("[" + (index + 1) + "/" + this.slides.length + "]");

        location.hash = index + 1;
    },

    normalizeIndex : function(index) {
        if (index >= 0) {
            return index % this.slides.length;
        }

        return (this.slides.length - Math.abs(index % this.slides.length)) % this.slides.length;
    },

    next : function() {
        this.change(this.current + 1);
    },

    prev : function() {
        this.change(this.current - 1);
    },

    first : function() {
        this.change(0);
    },

    last : function() {
        this.change(-1);
    },

    unfocus : function() {
        $("#controller").blur();
    },

    executeKeyCommand : function(command) {
        var method_name = this.keyMap[command];
        if (method_name) { 
            this[method_name]();
            return true;
        }
        return false;
    },

    keyMap : {
        "j" : "next",
        "n" : "next",
        "k" : "prev",
        "p" : "prev",
        "[" : "unfocus"
    },

    executeCommand : function(command) {
        var args = command.split(/ /);
        var name = args.shift();
        var method_name = this.commandMap[name];
        if (method_name) {
            this[method_name](args.join(" "));
            return true;
        }
        return false;
    },

    commandMap : {
        "goto" : "goto"
    },

    "goto" : function(num) {
        this.change(parseInt(num, 10) - 1);
    }
}

function justify() {
    var height = $(document.body).height() || window.innerHeight;
    /*$(".slide_wrapper").map(function() {
        $(this).css("top", (height - $(this).height() - $("#controller_menu").height()) / 2);
    });*/
}

$(function() {
    prettyPrint();
    Slide.init();
    
    justify();
    $(window).bind("resize", function() {
        justify();
    });

    $("input#controller").val("").focus().keyup(function() {
        var command = $(this).val();
        if (command.substr(0,1) !== ":") {
            Slide.executeKeyCommand($(this).val().substr(0, 1));
            $(this).val("");
        }
    });
    $("#controller_menu").submit(function() {
        var command = $("input", this).val().substr(1);
        Slide.executeCommand(command);
        $("input", this).val("");
        return false;
    });

    var clock = $("#clock");
    setInterval(function() {
        var current = new Date();
        clock.text("" + current.getHours() + ":" + current.getMinutes());
    }, 1000);
});

// -->
</script>

<div id="content">

<form id="controller_menu">

<div id="status">
<span id="clock"></span>
<span id="page"></span>
</div>

&nbsp;&gt;<input type="text" id="controller" />
</form>

<?php foreach ($slides as $i => $slide): ?>

<div class="slide_wrapper"><div class="slide">
<?php echo $slide ?>
</div></div>

<?php endforeach ?>

</div>

</body>
</html>
