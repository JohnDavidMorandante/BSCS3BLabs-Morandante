 <html>
    <head>
        <title>
            <?php
                $title = "Gallery - My Portfolio";
                echo $title;
            ?>
        </title>
    </head>
    <body>
        <?php
            $header = "My Gallery";
            echo "<h1>" . $header . "</h1>";
        ?>

        <p>
            This is the gallery page of my portfolio website. (images are placeholders)
        </p>

        <img src="phrolova.png" alt="Gallery Image" width="300">
        <img src="carlotta1.png" alt="Gallery Image" width="300">
        <img src="carlotta2.png" alt="Gallery Image" width="300">
        <img src="carlotta3.png" alt="Gallery Image" width="300">

        <br><br>
        <a href="homepage.php">Home</a> |
        <a href="aboutme.php">About Me</a> |
        <a href="gallery.php">Gallery</a>
    </body>
</html>