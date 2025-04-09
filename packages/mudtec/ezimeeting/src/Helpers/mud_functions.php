<?php

use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Department;
use Mudtec\Ezimeeting\Models\MeetingInterval;
use Mudtec\Ezimeeting\Models\MeetingStatus;
use Mudtec\Ezimeeting\Models\MeetingLocation;

if(!function_exists('verify_user')) {  
    function verify_user($list) {
        if(auth()->check()) {
            $user = User::find(auth()->id());
            $roles  = explode('|', $list);
            foreach($roles as $role) {
                if ($user && $user->hasRole($role)) {
                    return true;
                } //if ($user && $user->hasRole($role)) {
            } //foreach($roles as $role) {              
            return false;
        } //if(auth()->check()) {
        return view('home');
    } //function verify_user($list) {
} //if(!function_exists('verify_user')) {

if(!function_exists('hasCorp')) { 
    function hasCorp() {
        if(auth()->check()) {
            $user = User::find(auth()->id());
            if($user->corporations()->exists())
                return true;
            else
                return false;
        }
        return false;
    }
} //if(!function_exists('hasCorp')) { 

if(!function_exists('verify_corp')) { 
    function verify_corp($id) {
        $user = User::find(auth()->id());
        if($user->corporations()->exists() && $user->corporations()->first()->id == $id)
            return true;
        else
            return false;
    }
} //if(!function_exists('verify_corp')) { 

if(!function_exists('systemPasscode')) {
    function systemPassCode() {
        $sysPassCode = "";
        $sysDate = date("Ymd");
        $sysIncrement = date("m");
        $sysOffset = date("Y");
        $sysPassCode = $sysDate * $sysIncrement + $sysOffset;
        $sysPassCode = abs($sysPassCode % 1000000);
        $sysPassCode = substr($sysPassCode, -6);
        return $sysPassCode;
    }
} //if(!function_exists('systemPasscode')) {

if(!function_exists('get_user_corporation')) {
    function get_user_corporation() {
        $user = User::with('corporations')->find(auth()->id());
        return $user->corporations;
    }
} //if(!function_exists('get_user_corporation')) {

if(!function_exists('get_user_department')) {
    function get_user_department() {
        $user = User::find(auth()->id());
        return $user->corporation->department;
    }
} //if(!function_exists('get_user_department')) {

if(!function_exists('get_corporation_name')) {
    function get_corporation_name($id) {
        $corp = Department::where('id', $id)->first()->corporation()->first();
        return $corp->name;
    }
} //if(!function_exists('get_user_corporation_name')) {

if(!function_exists('get_corporation_logo')) {
    function get_corporation_logo($id) {
        $corp = Department::where('id', $id)->first()->corporation()->first();
        return $corp->logo;
    }
} //if(!function_exists('get_user_corporation_name')) {

if(!function_exists('get_department_name')) {
    function get_department_name($id) {
        $dep = Department::find($id);
        return $dep->name;
    }
} //if(!function_exists('get_user_department_name')) {

if(!function_exists('get_meeting_interval')) {
    function get_meeting_interval($id) {
        $meetingInterval = MeetingInterval::find($id);
        return $meetingInterval->description;
    }
} //if(!function_exists('get_meeting_interval')) {

if(!function_exists('get_meeting_status')) {
    function get_meeting_status($id) {
        $meetingStatus = MeetingStatus::find($id);
        return $meetingStatus->description;
    }
} //if(!function_exists('get_meeting_status')) {

if(!function_exists('get_meeting_color')) {
    function get_meeting_color($id) {
        $meetingStatus = MeetingStatus::find($id);
        return $meetingStatus->color;
    }
} //if(!function_exists('get_meeting_color')) {


if(!function_exists('get_meeting_location')) {
    function get_meeting_location($id) {
        $meetingLocation = MeetingLocation::find($id);
        return $meetingLocation->description;
    }
} //if(!function_exists('get_meeting_location')) {

if(!function_exists('get_user_name')) {
    function get_user_name($id) {
        $user = User::find($id);
        return $user->name;
    }
} //if(!function_exists('get_meeting_location')) {