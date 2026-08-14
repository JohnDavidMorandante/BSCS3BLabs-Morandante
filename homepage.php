<html>
    <head>
        <title>
            <?php
                $title = "Home - My Portfolio";
                echo $title;
            ?>
        </title>
    </head>
    <body>
        <?php
            $header = "JD's Portfolio";
            echo "<h1>" . $header . "</h1>";
        ?>

        <p>
            This is the home page of my portfolio website. 
            Here you can find information about me and view some of my gallery section.
        </p>

        <img src="banner.jpg" alt="Home Image" width="600" height="300">

        <br><br>
        <a href="homepage.php">Home</a> |
        <a href="aboutme.php">About Me</a> |
        <a href="gallery.php">Gallery</a>
    </body>
</html>