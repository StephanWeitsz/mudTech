<?php

namespace Mudtec\Ezimeeting\Database\Seeders\Meeting;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Carbon\Carbon;

use Mudtec\Ezimeeting\Models\Corporation;
use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\User;
use Mudtec\Ezimeeting\Models\DelegateRole;
use Mudtec\Ezimeeting\Models\MeetingDelegate;
use Mudtec\Ezimeeting\Models\MeetingMinute;
use Mudtec\Ezimeeting\Models\MeetingMinuteItem;
use Mudtec\Ezimeeting\Models\MeetingMinuteNote;
use Mudtec\Ezimeeting\Models\MeetingMinuteAction;
use Mudtec\Ezimeeting\Models\MeetingMinuteActionStatus;
use Mudtec\Ezimeeting\Models\MeetingMinuteActionFeedback;

class EzimeetingMeetingSeeder extends Seeder
{

    public $delegateRoleAttendee;
    public $delegateRoleScribe;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->delegateRoleAttendee = DelegateRole::where('description', 'Attendee')->pluck('id')->first();
        $this->delegateRoleScribe = DelegateRole::where('description', 'Scribe')->pluck('id')->first();

        $corporation = Corporation::find(1);
        $corporation->users()->sync([1,2,3,4]);
        

        $userList = ['1'=>"A",'2'=>"A",'3'=>"A",'4'=>"A"];
        $meetingDate = "2025-04-10";
        //Create a Meeting
        $meeting_main = Meeting::create([
            'description' => "Project Developmnent Catchup and Testing",
            'text' => "Testing Meeting Process",
            'purpose' => "To test the meeting system",
            'department_id' => 1,
            'scheduled_at' => $meetingDate,
            'duration' => 30,
            'meeting_interval_id' => 2,
            'meeting_location_id' => 1,
            'meeting_status_id' => 1,
            'external_url' => "",
            'created_by_user_id' => 1,
        ]);
        $this->setupMeetingMinutes($meeting_main, $userList, $meetingDate);
        
        for($i = 0; $i < 10; $i++) {
            $meetingDate = Carbon::now()->subDays(rand(1, 365))->format('Y-m-d');
            $meeting = Meeting::create([
                'description' => "Test Meeting $i",
                'text' => fake()->text(50),
                'purpose' => fake()->text(200),
                'department_id' => rand(1, 5),
                'scheduled_at' => $meetingDate,
                'duration' => rand(15, 60),
                'meeting_interval_id' => rand(1, 6),
                'meeting_location_id' => rand(1, 3),
                'meeting_status_id' => 1,
                'external_url' => "",
                'created_by_user_id' => rand(1, 4),
            ]);
            $this->setupMeetingMinutes($meeting, $userList, $meetingDate);
        }
    }

    public function setupMeetingMinutes(Meeting $meeting, $userList, $meetingDate) {
        $states = ["New", "Active", "In-Progress", "Onhold", "Canceled", "Closed"];

        $randomKey = array_rand($userList);
        $userList[$randomKey] = "S";

        foreach($userList as $userId => $delegate) {
            if($delegate == "A") {
                $delegateRoleAttendee = $this->delegateRoleAttendee;
            } else {
                $delegateRoleAttendee = $this->delegateRoleScribe;
            }
            MeetingDelegate::create([
                'meeting_id' => $meeting->id,
                'delegate_name' => User::find($userId)->name,
                'delegate_email' => User::find($userId)->email,
                'delegate_role_id' => $delegateRoleAttendee,
                'is_active' => true,
            ]);
        } 
       
        //Create first meeting minutes
        $Data['meeting_id'] = $meeting->id;
        $Data['date'] = $meetingDate;
        $Data['state'] = $states[rand(0, count($states) - 1)];
        $meetingMinute = MeetingMinute::create($Data);

        //Add Item 1 to meeting minutes
        $itemData = [
            'description' => fake()->text(50),
            'text' => fake()->text(200),
            'date_logged' => $meetingDate,
        ];
        $newItem = MeetingMinuteItem::create($itemData);
        $meetingMinute->meetingMinuteItems()->attach($newItem->id);
            
        //create a note on meeting item
        $newNote = MeetingMinuteNote::create([
            'description' => fake()->text(60),
            'text' => fake()->text(200),
            'date_logged' => $meetingDate,
            'meeting_minute_item_id' => $newItem->id,
        ]);
         
        $initStatus = MeetingMinuteActionStatus::where('description','New')->first();
        $owner = MeetingDelegate::findorfail(rand(1, 4));

        $newAction = MeetingMinuteAction::create([
            'description' => fake()->text(100),
            'text' => fake()->text(150),
            'date_logged' => $meetingDate,
            'meeting_minute_note_id' => $newNote->id,
            'meeting_minute_action_status_id' => $initStatus->id,
            'date_due' => date("Y-m-t", strtotime($meetingDate)),
        ]);
        $newAction->delegates()->attach($owner);
                
        $newFeedback = MeetingMinuteActionFeedback::create([
            'text' => fake()->text(80),
            'date_logged' => $meetingDate,
            'meeting_minute_action_id' => $newAction->id,
        ]);
    }
}
