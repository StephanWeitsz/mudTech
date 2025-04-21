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
use Mudtec\Ezimeeting\Models\MeetingMinuteDescriptor;

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
        $meetingDate = "2025-04-01";
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
        
        /*
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
        */    
    }

    public function setupMeetingMinutes(Meeting $meeting, $userList, $meetingDate) {
        $states = ["Started", "Active", "In-Progress", "Completed", "Canceled"];

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
       
        // 1. Create Meeting Minute
        $Data = [
            'meeting_id' => $meeting->id,
            'meeting_date' => $meetingDate,
            'meeting_state' => "Started",
        ];
        $meetingMinute = MeetingMinute::create($Data);
        
        // 2. Add Item to Meeting Minute
        $item = MeetingMinuteItem::create([
            'description' => "Discussion Point 1",
            'text' => "Test Item for meeting",
            'date_logged' => $meetingDate,
        ]);
        $meetingMinute->items()->attach($item->id);
        
        // 3. Create First Note
        $note1 = MeetingMinuteNote::create([
            'description' => "Initial Note",
            'text' => fake()->text(200),
        ]);
        
        $descriptor1 = new MeetingMinuteDescriptor([
            'meeting_minute_id' => $meetingMinute->id,
            'meeting_minute_item_id' => $item->id,
            'date_logged' => $meetingDate,
        ]);
        $note1->descriptors()->save($descriptor1);
        
        // 4. Create Action
        $initStatus = MeetingMinuteActionStatus::where('description', 'New')->first();
        //$owner = MeetingDelegate::findorfail(rand(1, 4));
        
        $action = MeetingMinuteAction::create([
            'description' => "Initial Action for Item 1",
            'text' => fake()->text(100),
            'meeting_minute_action_status_id' => $initStatus->id,
        ]);
        
        $descriptor2 = new MeetingMinuteDescriptor([
            'meeting_minute_id' => $meetingMinute->id,
            'meeting_minute_item_id' => $item->id,
            'date_logged' => now(),
        ]);
        $action->descriptors()->save($descriptor2);
        
        // 5. Create Second Note
        $note2 = MeetingMinuteNote::create([
            'description' => "Second Note on Item 1",
            'text' => fake()->text(200),
        ]);
        
        $descriptor3 = new MeetingMinuteDescriptor([
            'meeting_minute_id' => $meetingMinute->id,
            'meeting_minute_item_id' => $item->id,
            'date_logged' => $meetingDate,
        ]);
        $note2->descriptors()->save($descriptor3);
        
        // 6. Create Action Linked to Second Note (nested)
        $subAction = MeetingMinuteAction::create([
            'description' => "Follow-up Action for 2nd Note",
            'text' => fake()->text(100),
            'meeting_minute_action_status_id' => $initStatus->id,
        ]);
        
        $descriptor4 = new MeetingMinuteDescriptor([
            'meeting_minute_id' => $meetingMinute->id,
            'meeting_minute_item_id' => $item->id,
            'date_logged' => now(),
            'parent_descriptor_id' => $descriptor3->id, // Links this action to the second note
        ]);
        $subAction->descriptors()->save($descriptor4);

        $newFeedback = MeetingMinuteActionFeedback::create([
            'text' => fake()->text(80),
            'date_logged' => $meetingDate,
            'meeting_minute_action_id' => $subAction->id,
        ]);        
    }
}
