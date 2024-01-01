<?php
$root = $_SERVER['DOCUMENT_ROOT'];

echo "
<nav class='navbar navbar-expand-lg navbar-dark bg-dark '>
  <a class='navbar-brand' href='/home.php'>StrangeChat</a>
  <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
    <span class='navbar-toggler-icon'></span>
  </button>

  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item active'>
        <a class='nav-link' href='/home.php'>Home <span class='sr-only'>(current)</span></a>
      </li>";

if ( session_status() == PHP_SESSION_NONE ) {
    echo "
      <li class='nav-item'>
        <a class='nav-link' href='/login_system/signup.php'>Sign Up</a>
    </li>";
}
elseif ( session_status() == PHP_SESSION_ACTIVE ){
    echo "
      <li class='nav-item'>
        <a class='nav-link' href='/login_system/logout.php'>Log out</a>
      </li>
    ";
}

echo "
    </ul>
  </div>
</nav>
";
