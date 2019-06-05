<?php 

    if ( session_status() == 1 ) {
        session_start();
    }
    if (  isset($_SESSION["username"]) ) {
        header("Location:dashboard.php");
    }
    
?>

<?php
    if ( isset($_POST["firstname"]) &&  isset($_POST["lastname"]) &&  isset($_POST["username"]) &&  isset($_POST["email"]) &&  isset($_POST["age"]) &&  isset($_POST["gender"]) &&  isset($_POST["bloodgroup"]) &&  isset($_POST["education"]) &&  isset($_POST["currentcity"]) &&   isset($_POST["fromcity"]) &&  isset($_POST["password"])) {
        // include mysql connection file
        include("connect_to_db.php");
        $user_fullname = $_POST["firstname"] ." ".$_POST["lastname"];
        $user_username = $_POST["username"];
        $user_email = $_POST["email"];
        $user_age = $_POST["age"];
        $user_gender = $_POST["gender"];
        $user_bloodgroup = $_POST["bloodgroup"];
        $user_education = $_POST["education"];
        $user_currentcity = $_POST["currentcity"];
        $user_fromcity = $_POST["fromcity"];
        $user_phone = $_POST["phone"];
        $user_password = $_POST["password"];
        $user_profile_picture_link = $_FILES["avatarimage"]["name"];
        
        $user_id = $conn->query("SELECT COUNT(user_id) FROM users user_id")->fetch_assoc()["COUNT(user_id)"];
        
        // sql for entering new user into the batadase
        $sql = "INSERT INTO `users`(`user_id`, `user_username`, `user_password`, `user_email`, `user_phone`, `user_fullname`, `user_age`, `user_gender`, `user_bloodgroup`, `user_education`, `user_current_city`, `user_from`, `user_post_count`, `user_comment_count`,`user_profile_picture_link`) VALUES ($user_id,'$user_username','$user_password','$user_email',$user_phone,'$user_fullname',$user_age,'$user_gender','$user_bloodgroup','$user_education','$user_currentcity','$user_fromcity',0,0,'$user_profile_picture_link')";
        echo $sql;
        $r = $conn->query( $sql );
        // if registration done then set the session variable and redirect to dashboard.php
        if($r){

            move_uploaded_file($_FILES["avatarimage"]["tmp_name"],$_FILES["avatarimage"]["name"]);

            if ( session_status() == 1 ) {
                session_start();
                $_SESSION["username"] = $user_username;
                header("Location:dashboard.php");
            }
        }
        echo "<script>alert('Something Went Worng!!!')</script>";

    }
    
?>
<?php include("header.php"); ?>


        <div id="container">
            <div id="signupbox">
                <h2>Signup form</h2>
                <form action="signup.php" method="post"  enctype="multipart/form-data">
                    <label for="firstname">Enter Your name</label>
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" >
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" >
                    <label for="username">Choose Username</label>
                    <input type="text" name="username" id="username" placeholder="Username">
                    <label for="email">Enter Your Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Valid Email Address">
                    <label for="age">Enter Your Age </label> <label for="gender">Enter Your Gender</label>
                    <input type="text" name="age" id="age" placeholder="Age">
                    <input type="text" name="gender" id="gender" placeholder="Gender">
                    <label for="bloodgroup">Choose Your Blood Group</label>
                    <select name="bloodgroup" id="bloodgroup" placeholder="Blood group">
                        <option value="">  Choose Your Blood Group</option>
                        <option value="a+">A+</option>
                        <option value="a-">A-</option>
                        <option value="b+">B+</option>
                        <option value="b-">B-</option>
                        <option value="o+">O+</option>
                        <option value="o-">O-</option>
                        <option value="ab+">AB+</option>
                        <option value="ab-">AB-</option>
                    </select>
                    <label for="education">Enter Your Education</label>
                    <input type="text" name="education" id="education" placeholder="Education">
                    <label for="currentcity">Enter Your Current City</label>
                    <input type="text" name="currentcity" id="currentcity" placeholder="Current City">
                    <label for="from">Enter Your Birth City</label>
                    <input type="text" name="fromcity" id="fromcity" placeholder="Birth City">
                    <label for="phone">Enter Your Phone Number</label>
                    <input type="number" name="phone" id="phone" placeholder="Phone Number">
                    <label for="password">Choose A Password</label>
                    <input type="password" name="password" id="password" placeholder="Password">
                    <label for="repassword">Re Enter Password</label>
                    <input type="password" name="repassword" id="repassword" placeholder="Password" onkeyup="repasswordcheck(this)">
                    <label for="passwordalert" id="unmatchalert"></label>
                    <label for="image">Choose a profile picture</label>
                    <input type="file" name="avatarimage" id="image">
                    <input type="submit" value="Register" id="register">
                </form>
                <input type="button" value="Register"  onclick="register()" >
            </div>
        </div>



    <script type="text/javascript">
        
        function register() {        
            var input = document.querySelectorAll("input");
            // check if any field is empty or not 
            var flag = 1;
            for (let i=0;i<input.length;i++) {
                console.log(input[i]);  
                // if empty then make the border red and shake it
                if(!input[i].value.length){
                    input[i].style.border="1.5px solid red";
                    input[i].classList.add("fieldempty");
                    window.scrollBy(0,input[i].offsetTop - window.pageYOffset-200 );
                    setTimeout(() => {                        
                        input[i].classList.remove("fieldempty");
                    }, 1000);
                    input[i].addEventListener("keypress",()=>{
                        input[i].style.border="1.5px solid black";
                    });
                    flag = 0;
                    break;
                }
            }
            var select = document.querySelector("select");
            if (select.value && flag) {
                document.querySelector("#register").click(); 
            } else if(!select.value && flag) {
                select.style.border="1.5px solid #c20a0a";
                select.classList.add("fieldempty");
                setTimeout(() => {                        
                    select.classList.remove("fieldempty");
                }, 1000);
            }   
        }

        function repasswordcheck(node) {
            var pass = node.previousElementSibling.previousElementSibling.value;
            var repass = node.value;
            // password and re-password doesn't match it will show an alert massger
            if( pass != repass ){ 
                node.nextElementSibling.style.color="red";
                node.nextElementSibling.innerText = "***Password Doesn't match";
            } else {
                node.nextElementSibling.style.color="green";
                node.nextElementSibling.innerText = "  Matched ";
                setTimeout(() => {         
                    node.nextElementSibling.style.color="white";
                    node.nextElementSibling.innerText = "";      
                }, 1000);
            }
        }

    </script>
    <script src="js/bblibrary.js"></script>
</body>
</html>