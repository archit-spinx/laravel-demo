<?php
function getUsername($userId) {
 if (\DB::table('users')->where('id', $userId)->exists()){
    return \DB::table('users')->where('id', $userId)->first()->name;
 } else {
    return "User not exists";
 }
}
 

function getRole($role){
    if($role == 0){
        return "Admin";
    } else {
        return "Subscriber";
    }
}