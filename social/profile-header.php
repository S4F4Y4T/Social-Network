<?php
 userprofile::profile();
?>

<!-- Begin page content -->
   <div class="row">
   <div class="col-md-8 col-md-offset-2">
     <div class="row">
       <div class="col-md-12">
         <div class="cover profile">
           <div class="wrapper">
             <div class="image">
               <img src="images/cover/<?= userprofile::profile()[0]['cover']; ?>" class="show-in-modal" alt="people">
             </div>

           </div>
           <div class="cover-info">
             <div class="avatar">
               <div class='profile-img'>
                 <img src="images/profile/<?= userprofile::profile()[0]['image']; ?>" alt="people">
               </div>
               <?php
                 $avatar =  timeline::isUser();
                 if( $avatar ){
               ?>

               <a href='edit_profile.php'>
                 <div class='change-profile'>
                     <i class='fa fa-camera center'></i>
                 </div>
               </a>

             <?php } ?>
             </div>
             <div class="name"><a href="#">

               <?php
                 echo userprofile::profile()[0]['name'];

                 if(userprofile::profile()[0]['verified'] != 0){
                   echo '<i class="fa verified fa-check" aria-hidden="true"></i>';
                 }
               ?>

             </a></div>
             <div class="name follow">
               <div class='pull-right'>

               <form action='' method='post'>

                 <?php
                   echo userprofile::isfollowing();
                 ?>

               </form>

             </div>
             </div>
             <ul class="cover-nav">
               <li ><a href='profile.php<?php if(isset($_GET['username'])){echo'?username='.$_GET['username']; }?>'><i class="fa fa-fw fa-bars"></i>Timeline</a></li>
               <li><a href='about.php<?php if(isset($_GET['username'])){echo'?username='.$_GET['username']; }?>'><i class="fa fa-fw fa-user"></i> About</a></li>
               <li><a href="followers.php<?php if(isset($_GET['username'])){echo'?username='.$_GET['username']; }?>"><i class="fa fa-fw fa-users"></i>Followers</a></li>
               <li><a href="photos.php<?php if(isset($_GET['username'])){echo'?username='.$_GET['username']; }?>"><i class="fa fa-fw fa-image"></i> Photos</a></li>
             </ul>
           </div>
         </div>
       </div>
     </div>
