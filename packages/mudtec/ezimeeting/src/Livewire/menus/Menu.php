<?php

namespace Mudtec\Ezimeeting\Livewire\Menus;

use Livewire\Component;

class Menu extends Component
{
    public $menuItems = [
        [
            'label' => 'Meetings',
            'route' => '#',
            'auth' => 'SuperUser|Admin|Organizer|Attendee',
            'submenus' => [
                ['label' => 'Create Meeting', 'route' => 'newMeeting', 'auth' => 'SuperUser|Admin|Organizer'],
                ['label' => 'My Meetings', 'route' => 'myMeetingList','auth' => 'SuperUser|Admin|Organizer'],
                ['label' => 'All Meetings', 'route' => 'meetingList','auth' => 'SuperUser|Admin|CorpAdmin|Organizer|Attendee'],
                ['label' => 'Meeting Schedule', 'route' => 'underDevelopment','auth' => true],
                ['label' => 'Meeting Report', 'route' => 'underDevelopment','auth' => true],
            ],
        ],
        [
            'label' => 'Admin',
            'route' => '#',
            'auth' => 'SuperUser|Admin',
            'submenus' => [
                ['label' => 'Corporations', 'route' => 'corporations','auth' => true],
                ['label' => 'Corporate Users', 'route' => 'corporationsUser', 'auth' => true], 
                ['label' => 'Departments', 'route' => 'corpDepartments','auth' => true],
                ['label' => 'Managers', 'route' => 'departmentManagers','auth' => true],
                ['label' => 'Roles', 'route' => 'roles','auth' => 'Super User'],     
                ['label' => 'Users', 'route' => 'corpUsers','auth' => true],
                
                ['label' => 'Meeting Status', 'route' => 'meetingStatus','auth' => 'SuperUser'],
                ['label' => 'Meeting Interval', 'route' => 'meetingInterval','auth' => 'SuperUser'],
                ['label' => 'Meeting Locations', 'route' => 'meetingLocation','auth' => true],

                ['label' => 'Meeting Delegate Roles', 'route' => 'meetingDelegateRole','auth' => 'SuperUser'],
                ['label' => 'Meeting Attendee Status', 'route' => 'meetingAttendeeStatus','auth' => 'SuperUser'],
                ['label' => 'Meeting Action Status', 'route' => 'meetingMinuteActionStatus','auth' => 'SuperUser'],
            ],
        ],
        [
            'label' => 'About Us',
            'route' => 'about',
            'auth' => true,
            'submenus' => [],
        ],
        [
            'label' => 'Contact Us',
            'route' => 'contact',
            'auth' => true,
            'submenus' => [],
        ],
        [
            'label' => 'Terms',
            'route' => 'terms',
            'auth' => true,
            'submenus' => [],
        ],
    ];

    public function render()
    {
        return view('ezimeeting::livewire.menus.menu');
    }
}