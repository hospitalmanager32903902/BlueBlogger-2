<?php
    $conn = new PDO("mysql:host=localhost;dbname=blueblogger","root","");

    // $postid = 0;
    // foreach($users as $user){
    //     $user_username = $user["user_username"];
    //     $user_id = $user["user_id"];
    //     for( $i=0;$i<7;$i++ ){
    //         $posts = $conn->prepare("update posts set `post_author_username`='$user_username', `post_author_id`=$user_id Where `post_id`=$postid");
    //         $posts->execute();
    //         $postid++;
    //     }
    // }

    
    function randBloodGroup() {
        $bg = ["AB+","AB-","A+","A-","B+","B-","O+","O-"];
        return $bg[ rand(0,count($bg)-1) ];
    }

    function randProfession() {
        $bg = ["Web Developer","Film Maker","Accountant","Banker","Businessman","Photographer","Pianter","Engineer"];
        return $bg[ rand(0,count($bg)-1) ];
    }

    function randCity() {
        $bg = ["London","Paris","New York","Dhaka","Mumbai","Delhi","Baquwar","Bangaluro"];
        return $bg[ rand(0,count($bg)-1) ];
    }

    function randEducation(){
        $bg = ["Bsc in CS","BSc in Chemistry","BSc in Physics","BCom","Hounars in Accounting","Bachelors in Arts","MSc in Biology","Phd"];
        return $bg[ rand(0,count($bg)-1) ];
    }

    for( $i=0;$i<30;$i++ ){
        $user_bloodgroup = randBloodGroup();
        $user_education = randEducation();
        $user_current_city = randCity();
        $user_profession = randProfession();
        $user_from = randCity();
        $postid = $i;
        $posts = $conn->prepare("update users set `user_bloodgroup`='$user_bloodgroup',`user_from`='$user_from', `user_education`='$user_education', `user_current_city`='$user_current_city', `user_education`='$user_profession' Where `user_id`=$postid");
        $posts->execute();
        // echo "update users set `user_bloodgroup`='$user_bloodgroup', `user_education`='$user_education', `user_current_city`='$user_current_city', `user_education`='$user_profession' Where `post_id`=$postid";
    }


?>