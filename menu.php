<?php
$menu = array(
    'instructor-home.php' => 'View All Results'
);
?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Pre-Post</a>
        </div>
        <ul class="nav navbar-nav">
            <?php
            if($USER->instructor){
            ?>
                <?php foreach( $menu as $menupage => $menulabel ) : ?>
                    <li<?php if($menupage == basename($_SERVER['PHP_SELF'])){echo ' class="active"';} ?>>
                        <a href="<?php echo $menupage ; ?>">
                            <?php echo $menulabel ; ?>
                        </a>
                    </li>
                <?php endforeach ?>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>
