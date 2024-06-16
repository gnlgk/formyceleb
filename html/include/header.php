<header id="header" role="banner">
    <div class="container">
        <div class="header__inner">
            <h1 id="header__title"><a href="../index.php">FORMYCELEB</a></h1>
            
            <div class="homebtn">
            <a href="../index.php" class="custom-button-menu" aria-label="Home">
            </a>
    
<?php if (isset($_SESSION['memberID'])) { ?>
    <button class="unbutton button-menu" aria-label="Logout">
        <span><a href="../signup/signOut.php" id="logout__Button">Logout</a></span>
    </button>
<?php } else { ?>
    <button class="unbutton button-menu" aria-label="Open the menu">
        <span><a href="#" id="login__Button">Login</a></span>
    </button>
<?php } ?>
    <div id="login_modal" class="login_modal">
                <div class="modal_content">
<?php include '../signup/login.php';?>
                </div>
            </div>
           
            </div>
        </div>
    </div>
</header>