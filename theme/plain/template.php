<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="<?php echo $basePath ?>/prettify.css" rel="stylesheet" />
    <title><?php echo escape($title) ?></title>
</head>
<body>

<script type="text/javascript" src="<?php echo $basePath ?>/jquery-1.4.2.js"></script>
<script type="text/javascript" src="<?php echo $basePath ?>/prettify.js"></script>
<script type="text/javascript"><!--


$(function() {
    prettyPrint();
});

// -->
</script>

<?php foreach ($slides as $i => $slide): ?>
<div class="slide"><?php echo $slide->getHtml() ?></div>
<?php if ($i + 1 !== count($slides)): ?><hr /><?php endif ?>
<?php endforeach ?>

</body>
</html>
