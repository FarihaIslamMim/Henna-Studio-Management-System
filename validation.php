<?php


function validateName($name){


    return preg_match("/^[A-Za-z ]{3,}$/", $name);


}



function validatePhone($phone){


    return preg_match("/^[0-9]{11}$/", $phone);


}



function validateEmail($email){


    return filter_var($email, FILTER_VALIDATE_EMAIL);


}



function validatePassword($password){


    if(strlen($password) < 8){

        return false;

    }


    if(!preg_match('/[A-Z]/', $password)){

        return false;

    }


    if(!preg_match('/[a-z]/', $password)){

        return false;

    }


    if(!preg_match('/[0-9]/', $password)){

        return false;

    }


    if(!preg_match('/[\W]/', $password)){

        return false;

    }


    return true;

}



function validateID($id){


    return ctype_digit($id) && $id > 0;


}



function validateExperience($experience){


    return is_numeric($experience) && $experience >= 0;


}



function validateDate($date){


    return $date <= date('Y-m-d');


}



function validateAmount($amount){


    return is_numeric($amount) && $amount > 0;


}

function validateStrongPassword($password){

    return preg_match(
        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/",
        $password
    );

}


?>