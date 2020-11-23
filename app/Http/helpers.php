<?php 

function makeImageForname($name)
{
    $userImage = "";
    $shortName = "";

    $names = explode(" ",$name);

    foreach($names as $w)
    {
        $shortName =$shortName. $w[0];
        // dd($shortName);
    }

    $userImage = '<div class="name-image bg-primary">' .$shortName. '</div>';  

    return $userImage;
}

?>