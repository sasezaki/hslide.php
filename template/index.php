<?php if (!debug_backtrace()) { return; } ?>
<html>
<head>
<title>hslide.php - はてな記法プレゼンツール</title>
<style type="text/css">
body {
    margin : 0;
    padding : 0;
}
#control {
    position : absolute;
    left : 0;
    top : 0;
    width : 100%;
    text-align : center;
}
#theme_control {
    background-color : #333;
    padding : 5px 10px;
    border-radius : 0px 0px 5px 5px;
    display : inline-block;
    font-size : 12px;
    color : #fff;
}
iframe {
    border : 0px;
}
</style>
<script type="text/javascript">
window.addEventListener("load", function() {
    var theme = document.getElementById("theme_select");
    var presentation = document.getElementById("presentation");
    var go = document.getElementById("go");
    var themeName = "default";
    theme.addEventListener("change", function() {
        if (themeName != theme.value) {
            themeName = theme.value;
            presentation.src = "./hslide.php?theme=" + themeName;
         }
    }, false);
    go.addEventListener("click", function() {
        location.href = "./hslide.php?theme=" + themeName;
    }, false);
}, false);
</script>
</head>
<body>

<div id="control"><div id="theme_control">
theme: <select id="theme_select">
<?php foreach ($themes as $theme): ?>
<option value="<?php echo escape($theme) ?>"><?php echo escape($theme) ?></option> 
<?php endforeach ?>
</select> <button id="go">go</button>
</div></div>

<iframe id="presentation" src="./hslide.php?theme=<?php echo escape($themes[0]) ?>" width="100%" height="100%"></iframe>

</body>
</html>
