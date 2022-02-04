<?php
function getUsername($userId) {
 return \DB::table('users')->where('id', $userId)->first()->name;
}
 

function getRole($role){
    if($role == 0){
        return "Admin";
    } else {
        return "Subscriber";
    }
}