<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting;

use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\MeetingInterval;
use Mudtec\Ezimeeting\Models\MeetingMinute;
use Mudtec\Ezimeeting\Models\MeetingDelegate;
use Mudtec\Ezimeeting\Models\MeetingMinuteItem;
use Mudtec\Ezimeeting\Models\MeetingMinuteNote;
use Mudtec\Ezimeeting\Models\MeetingMinuteAction;
use Mudtec\Ezimeeting\Models\MeetingMinuteActionStatus;
use Mudtec\Ezimeeting\Models\MeetingMinuteActionFeedback;

use Mudtec\Ezimeeting\Models\ActionResponsibilitie;
use Mudtec\Ezimeeting\Models\MeetingStatus;
use Mudtec\Ezimeeting\Models\Meeting;

class MeetingMinuteDetail extends Component
{
    use WithFileUploads;

    public $meetingDelegates;
    public $selectedDelegate = "";

    public $meetingId;
    public $minutesId;

    public $isEndMeetingOpen;
    public $meetingMinuteDate;
    public $meetingMinuteTranscript;
    public $meetingMinuteState;

    public $meetingMinute;
    public $meetingMinuteItems = [];
    public $meetingMinuteNotes = [];
    public $meetingMinuteActions = [];
    public $meetingMinuteActionFeedbacks = [];

    public $NewButtonColor = 'blue';

    public $itemDescription;
    public $itemText;
    public $itemLogged;
    public $itemClosed;
    public $selectedItemId;
    public $editingItemId;
    public $isItemOpen = false;
    public $itemButtonColor = 'green';

    public $noteDescription;
    public $noteText;
    public $noteClosed;
    public $selectedNoteId;
    public $editingNoteId;
    public $isNoteOpen;
    public $noteButtonColor = 'yellow';

    public $actionDescription;
    public $actionText;
    public $actionLogged;
    public $actionDue;
    public $actionRevised;
    public $actionClosed;
    public $selectedActionId; 
    public $editingActionId;
    public $isActionOpen;
    public $actionButtonColor = 'purple';
    
    public $feedbackText;
    public $editingFeedbackId;
    public $isFeedbackOpen;
    public $feedbackButtonColor = 'blue';

    public $page_heading = 'Meeting Minutes';
    public $page_sub_heading = 'Capture First Sitting'; 


    public function mount($meetingId, $minutesId) 
    {
        $this->meetingId = $meetingId;
        $this->minutesId = $minutesId;
        //dd($this->meetingMinuteItems);
        
    }

    public function createMeetingMinute()
    {
        $validatedData = $this->validate([
            'meetingMinuteDate' => ['required', 'date'],
            'meetingMinuteTranscript' => ['nullable', 'file', 'mimes:txt,pdf,doc,docx', 'max:10240'], // max 10MB
        ]);

        $meetingStatusId = MeetingStatus::where('description','In Progress')->first();
        Meeting::where('id', $this->meetingId)->update(['meeting_status_id' => $meetingStatusId->id]); 
                 
        $Data['date'] = $this->meetingMinuteDate;
        $Data['meeting_id'] = $this->meetingId;
        $Data['state'] = "started";
        
        try {
            // Handle transcript upload if provided
            if ($this->meetingMinuteTranscript) {
                $uploadPath = $this->meetingMinuteTranscript->store('transcripts');
        
                if ($uploadPath) {
                    Log::info('Transcript uploaded to: ' . $uploadPath);
                    $Data['transcript'] = $uploadPath;
                } else {
                    throw new \Exception('Failed to store transcript.');
                }
            }
        
            // Retrieve the latest meeting minute based on the meeting_id
            $previouse_meetingMinute = MeetingMinute::where('meeting_id', $this->meetingId)->latest()->first();
            if ($previouse_meetingMinute) {
                
                // Create the new meeting minute record
                $this->meetingMinute = MeetingMinute::create($Data);
                session()->flash('success', 'Meeting minute created successfully');
                $this->page_sub_heading = 'Meeting Minutes for ' . \Carbon\Carbon::parse($this->meetingMinuteDate)->format('Y-m-d');
                $this->minutesId = $this->meetingMinute->id;
        
                // Fetch meeting minute items that are not closed
                // Loop through each meeting minute item and create a new item
                $this->meetingMinuteItems = $previouse_meetingMinute->meetingMinuteItems()
                    ->whereNull('date_closed')
                    ->get();
                foreach ($this->meetingMinuteItems as $item) {
                    $itemData = [
                        'description' => $item->description,
                        'text' => $item->text,
                        'date_logged' => $item->date_logged,
                    ];
        
                    // Create a new meeting minute item
                    $newItem = MeetingMinuteItem::create($itemData);
                    $this->meetingMinute->meetingMinuteItems()->attach($newItem->id);
                    
                    //->whereNull('date_closed')
                    foreach ($item->meetingMinuteNotes()->get() as $note) {
                        $newNote = MeetingMinuteNote::create([
                            'description' => $note->description,
                            'text' => $note->text,
                            'date_logged' => $note->date_logged,
                            'meeting_minute_item_id' => $newItem->id,
                        ]);
                        
                        //->whereNull('date_closed')
                        foreach($note->MeetingMinuteActions()->get() as $action) {
                            $newAction = MeetingMinuteAction::create([
                                'description' => $action->description,
                                'text' => $action->text,
                                'date_logged' => $action->date_logged,
                                'meeting_minute_note_id' => $newNote->id,
                                'meeting_minute_action_status_id' => $action->meeting_minute_action_status_id,
                                'date_due' => $action->date_due,
                            ]);

                            $owners= $action->delegets;
                            if($owners) {
                                foreach($owners as $owner) {
                                    $newAction->delegates()->attach($owner);
                                }
                            }

                            foreach ($action->meetingMinuteActionFeedbacks()->get() as $feedback) {
                                $newFeedback = MeetingMinuteActionFeedback::create([
                                    'text' => $feedback->text,
                                    'date_logged' => $feedback->date_logged,
                                    'meeting_minute_action_id' => $newAction->id,
                                ]);

                            } //foreach ($action->meetingMinuteActionFeedbacks()->get() as $feedback) {
                        } //foreach($note->MeetingMinuteAction()->get() as $action) {
                    } //foreach ($item->meetingMinuteNotes()->get() as $note) {
                } //foreach ($this->meetingMinuteItems as $item) {
            } //if ($previouse_meetingMinute) {
            else {
                // Create the new meeting minute record
                $this->meetingMinute = MeetingMinute::create($Data);
                session()->flash('success', 'Meeting minute created successfully');
                $this->page_sub_heading = 'Meeting Minutes for ' . \Carbon\Carbon::parse($this->meetingMinuteDate)->format('Y-m-d');
                $this->minutesId = $this->meetingMinute->id; 
            }
        } catch (\Exception $e) {
            Log::error('Error creating meeting minute: ' . $e->getMessage());
            session()->flash('error', 'Error: creating meeting minute : ' . $e->getMessage()); 
        } //catch (\Exception $e) {
    } 

    ////////////////////////////////////////////////////
    //Items
    ////////////////////////////////////////////////////
    public function showAddItem()
    {
        Log::debug("clicked showAddItem");
        $this->itemDescription = '';
        $this->itemText = '';
        $this->isItemOpen = true;
    }
    
    public function hideAddItem()
    {
        $this->isItemOpen = false;
    }

    public function submitNewItem() 
    {
        $this->isItemOpen = false;
        $validatedData = $this->validate([
            'itemDescription' => ['required'],
            'itemText' => ['required','max:255'],
        ]);

        $Data['description'] = $this->itemDescription;
        $Data['text'] = $this->itemText;
        $Data['date_logged'] = date("Y-m-d");
        //$Data['date_closed'] = null;
      
        $newItem = MeetingMinuteItem::create($Data);
        $this->meetingMinute->meetingMinuteItems()->attach($newItem->id);
        session()->flash('success', 'Meeting minute item created successfully');
    }

    public function removeItem($itemId)
    {
        try {
            $item = MeetingMinuteItem::findOrFail($itemId);
            $this->meetingMinute->meetingMinuteItems()->detach($itemId);
            $item->delete();
            session()->flash('success', 'Meeting minute item removed successfully');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: removing meeting minute item. ' . $e->getMessage());
        }
    }

    public function editItem($itemId)
    {
        $item = MeetingMinuteItem::findOrFail($itemId);
        $this->itemDescription = $item->description;
        $this->itemText = $item->text;
        $this->itemLogged = \Carbon\Carbon::parse($item->date_logged)->format('Y-m-d');
        $this->itemClosed = \Carbon\Carbon::parse($item->closed)->format('Y-m-d');
        $this->isItemOpen = true;
        $this->editingItemId = $itemId;
    }

    public function saveItem()
    {
        $validatedData = $this->validate([
            'itemDescription' => ['required'],
            'itemText' => ['required', 'max:255'],
            'itemLogged' => ['required', 'date'],
        ]);

        $item = MeetingMinuteItem::findOrFail($this->editingItemId);
        $item->description = $this->itemDescription;
        $item->text = $this->itemText;
        $item->date_logged = $this->itemLogged;
        $item->save();

        $this->isItemOpen = false;
        $this->editingItemId = null;
        session()->flash('success', 'Meeting minute item updated successfully');
    }

    public function closeItem($itemId) {
        $item = MeetingMinuteItem::findOrFail($itemId);
        $itemNote = $item->meetingMinuteNotes()->whereNull('date_closed')->count();
        if(empty($itemNote)) {
            $item->date_closed = date("Y-m-d");
            $item->save();
            session()->flash('success', 'Meeting minute item closed successfully');
        } //if(empty($noteAction)) {
        else {
            session()->flash('error', 'Error: Cannot close item with open notes. Please close all notes first.');
        } //else
    }

    /////////////////////////////////////////////////////
    //Notes
    ////////////////////////////////////////////////////
    public function showAddNote($itemId) 
    {
        Log::debug("clicked showAddNote");
        $this->selectedItemId = $itemId;
        $this->noteDescription = "";
        $this->noteText = "";
        $this->isNoteOpen = true;
    }

    public function hideAddNote()
    {
        Log::info("clicked hideAddNote");
        $this->isNoteOpen = false;
    }

    public function submitNewNote() 
    {
        Log::debug("clicked submitNewNote");
        $validatedData = $this->validate([
            'noteDescription' => ['required'],
            'noteText' => ['required','max:255'],
        ]);
        Log::debug("validated Data : $this->selectedItemId");

        $Data['meeting_minute_item_id'] = $this->selectedItemId;
        $Data['description'] = $this->noteDescription;
        $Data['text'] = $this->noteText;
        $Data['date_logged'] = date("Y-m-d");

        try {
            Log::debug("try create");
            MeetingMinuteNote::create($Data);
            session()->flash('success', 'Meeting minute Note created successfully');
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: creating meeting minute note.' . $e->getMessage());      
        }
        Log::info("close popup");
        $this->isNoteOpen = false;   
    }

    public function removeNote($noteId)
    {
        try {
            $note = MeetingMinuteNote::findOrFail($noteId);
            $this->meetingMinuteItem->meetingMinuteItems()->meetingMinuteNotes()->detach($noteId);
            $note->delete();
            session()->flash('success', 'Meeting minute Note removed successfully');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: removing meeting minute note. ' . $e->getMessage());
        }
    }

    public function editNote($noteId)
    {
        $note = MeetingMinuteNote::findOrFail($noteId);
        $this->noteDescription = $note->description;
        $this->noteText = $note->text;
        $this->isNoteOpen = true;
        $this->editingNoteId = $noteId;
    }

    public function saveNote()
    {
        $validatedData = $this->validate([
            'noteDescription' => ['required'],
            'noteText' => ['required', 'max:255'],
        ]);

        $note = MeetingMinuteNote::findOrFail($this->editingNoteId);
        $note->description = $this->noteDescription;
        $note->text = $this->noteText;
        $note->save();

        $this->isNoteOpen = false;
        session()->flash('success', 'Meeting minute note updated successfully');
    }

    public function closeNote($noteId) {
        $note = MeetingMinuteNote::findOrFail($noteId);
        $noteAction = $note->meetingMinuteActions()->whereNull('date_closed')->count();
        if(empty($noteAction)) {
            $note->date_closed = date("Y-m-d");
            $note->save();
            session()->flash('success', 'Meeting minute note closed successfully');
        } //if(empty($noteAction)) {
        else {
            session()->flash('error', 'Error: Cannot close note with open actions. Please close all actions first.');
        } //else
    }

    /////////////////////////////////////////////////////
    //Actions
    ////////////////////////////////////////////////////

    public function showAddAction($noteId) 
    {
        $this->selectedDelegate = "";
        $this->meetingDelegates = MeetingDelegate::where('meeting_id', $this->meetingId)->get();
        $this->selectedNoteId = $noteId;
        $this->actionDescription = "";
        $this->actionText = "";
        $this->actionLogged = "";
        $this->actionDue = "";
        $this->actionRevised = "";

        $this->isActionOpen = true;
    }

    public function hideAddAction()
    {
        $this->isActionOpen = false;
    }

    public function submitNewAction() 
    {
        $this->isActionOpen = false;
        $validatedData = $this->validate([
            'actionDescription' => ['required'],
            'actionText' => ['required','max:255'],
        ]);

        $initStatus = MeetingMinuteActionStatus::where('description','New')->first();

        $Data['meeting_minute_note_id'] = $this->selectedNoteId;
        $Data['description'] = $this->actionDescription;
        $Data['text'] = $this->actionText;
        $Data['meeting_minute_action_status_id'] = $initStatus->id;
        $Data['date_logged'] = date("Y-m-d");
        $Data['date_due'] = $this->actionDue;

        $newAction = MeetingMinuteAction::create($Data);
       
        if ($this->selectedDelegate and $this->selectedDelegate != "ALL") {
            $newAction->delegates()->attach($this->selectedDelegate);
        }

        $this->isActionOpen = false;

        session()->flash('success', 'Meeting minute Action created successfully');
    }


    public function removeAction($actionId)
    {
        try {
            $action = MeetingMinuteAction::findOrFail($actionId);
            $this->meetingMinuteItem->meetingMinuteItems()->meetingMinuteNotes()->meetingMinuteActions()->detach($actionId);
            $action->delete();
            session()->flash('success', 'Meeting minute Action removed successfully');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: removing meeting minute Action. ' . $e->getMessage());
        }
    }

    public function rescheduleAction($actionId)
    {
        $action = MeetingMinuteAction::findOrFail($actionId);
        $this->actionDescription = $action->description;
        $this->actionText = $action->text;
        $this->actionDue = $action->date_due;
        if($action->date_dueRevised)
            $this->actionRevised = $action->date_dueRevised;
        else
            $this->actionRevised = date('Y-m-d');
        $this->isActionOpen = true;
        $this->editingActionId = $actionId;
    }

    public function editAction($actionId)
    {
        $action = MeetingMinuteAction::findOrFail($actionId);
        $this->actionDescription = $action->description;
        $this->actionText = $action->text;
        $this->actionLogged = $action->date_logged;
        $this->actionDue = $action->date_due;
        if($action->date_dueRevised)
            $this->actionRevised = $action->date_dueRevised;
        else
            $this->actionRevised = "";
        $this->isActionOpen = true;
        $this->editingActionId = $actionId;
    }

    public function saveAction()
    {
        $validatedData = $this->validate([
            'actionDescription' => ['required'],
            'actionText' => ['required', 'max:255'],
            'actionRevised' => ['nullable', 'date'],
        ]);

        $action = MeetingMinuteAction::findOrFail($this->editingActionId);
        $action->description = $this->actionDescription;
        $action->text = $this->actionText;
        $action->date_revised = $this->actionRevised;
        $action->save();

        $this->isActionOpen = false;
        $this->editingActionId = null;
        session()->flash('success', 'Meeting minute action updated successfully');
    }

    public function closeAction($actionId) {
        $action = MeetingMinuteAction::findOrFail($actionId);
        $actionFeedback = $action->meetingMinuteActionFeedbacks()->whereNull('date_closed')->count();
        if(empty($actionFeedback)) {
            $action->date_closed = date("Y-m-d");
            $action->save();
            session()->flash('success', 'Meeting minute action closed successfully');
            $this->isFeedbackOpen = true;
        } //if(empty($actionFeedback)) {
        else {
            session()->flash('error', 'Error: Cannot close action with open feedback. Please close all feedback first.');
        } //else
    }

    
    public function onDelegateSelected($selected_id) {
        $this->selectedDelegate = $selected_id;
    } //public function onDelegateSelected($selected_id) {

    /////////////////////////////////////////////////////
    //Feedback
    ////////////////////////////////////////////////////

    public function showAddFeedback($actionId) 
    {
        $this->selectedActionId = $actionId;
        $this->feedbackText = "";
        $this->isFeedbackOpen = true;
    }

    public function hideAddFeedback()
    {
        $this->isFeedbackOpen = false;
    }

    public function submitNewFeedback() 
    {
        $this->isFeedbackOpen = false;
        $validatedData = $this->validate([
            'feedbackText' => ['required','max:255'],
        ]);

        $Data['text'] = $this->feedbackText;
        $Data['date_logged'] = date("Y-m-d");
        $Data['meeting_minute_action_id'] = $this->selectedActionId;
      
        $newFeedback = MeetingMinuteActionFeedback::create($Data);
        session()->flash('success', 'Meeting minute Feedback created successfully');
    }

    public function removeFeedback($feedbackId)
    {
        try {
            $feedback = MeetingMinuteActionFeedback::findOrFail($feedbackId);
            $feedback->delete();
            session()->flash('success', 'Meeting minute feedback removed successfully');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: removing meeting minute Feedback. ' . $e->getMessage());
        }
    }

    public function editFeedback($feedbackId)
    {
        $feedback = MeetingMinuteActionFeedback::findOrFail($feedbackId);
        $this->actionDescription = $feedback->description;
        $this->actionText = $feedback->text;
        $this->actionRevised = $feedback->date_revised;
        $this->isFeedbackOpen = true;
        $this->editingFeedbackId = $feedbackId;
    }

    public function saveFeedback()
    {
        $validatedData = $this->validate([
            'feedbackText' => ['required', 'max:255'],
        ]);

        $feedback = MeetingMinuteActionFeedback::findOrFail($this->editingFeedbackId);
        $feedback->text = $this->feedbackText;
        $feedback->date_logged = date("Y-m-d");
        $feedback->save();

        $this->isFeedbackOpen = false;
        $this->editingFeedbackId = null;
        session()->flash('success', 'Meeting minute feedback updated successfully');
    }


/*    public function closeFeedback($feedbackId) {
        $feedback = MeetingMinuteActionFeedback::findOrFail($feedbackId);
        $feedback->date_closed = date("Y-m-d");
        $feedback->save();
        session()->flash('success', 'Meeting minute feedback closed successfully');
    }*/


    public function showEndMeeting() {
        $this->isEndMeetingOpen = true;
        $this->meetingMinuteDate = \Carbon\Carbon::parse($this->meetingMinuteDate)->format('Y-m-d');
    }

    public function signoffMeetingMinute() {
        $this->isEndMeetingOpen = false;

        $validatedData = $this->validate([
            'meetingMinuteDate' => ['required', 'date'],
            'meetingMinuteTranscript' => ['nullable', 'file', 'mimes:txt,pdf,doc,docx', 'max:10240'], // max 10MB
        ]);

        $meeting_interval_id = Meeting::where('id', $this->meetingId)->first()->meeting_interval_id;
        $meeting_interval = MeetingInterval::find($meeting_interval_id);
        $interval_formula = $meeting_interval->formula;
        if (strpos($interval_formula, '+') !== false) {
            preg_match('/(\d+)([a-z]+)/', $interval_formula, $matches);
            $interval_value = (int) $matches[1];
            $interval_unit = $matches[2];

            $new_scheduled_at = \Carbon\Carbon::parse($this->meetingMinuteDate);

            switch ($interval_unit) {
                case 'd':
                    $new_scheduled_at->addDays($interval_value);
                    break;
                case 'm':
                    $new_scheduled_at->addMonths($interval_value);
                    break;
                case 'y':
                    $new_scheduled_at->addYears($interval_value);
                    break;
            }
            $new_scheduled_at = $new_scheduled_at->format('Y-m-d');
        }
        else {
            $new_scheduled_at = \Carbon\Carbon::parse($this->meetingMinuteDate)->format('Y-m-d');
        }    
    
        $meetingStatusId = MeetingStatus::where('description','Active')->first();
        Meeting::where('id', $this->meetingId)->update([
            'meeting_status_id' => $meetingStatusId->id,
            'scheduled_at' => $new_scheduled_at,
        ]);

        $Data['date'] = $this->meetingMinuteDate;
        $Data['meeting_id'] = $this->meetingId;
        $Data['state'] = "completed";
        
        try {
            if ($this->meetingMinuteTranscript) {
                $uploadPath = $this->meetingMinuteTranscript->store('transcripts');
        
                if ($uploadPath) {
                    Log::info('Transcript uploaded to: ' . $uploadPath);
                    $Data['transcript'] = $uploadPath;
                } else {
                    throw new \Exception('Failed to store transcript.');
                }
            }
        
            // Retrieve the existing meeting minute
            $this->meetingMinute = MeetingMinute::where('meeting_id', $this->meetingId)->first();
        
            if ($this->meetingMinute) {
                $this->meetingMinute->update($Data);
                session()->flash('success', 'Meeting minute updated successfully.');



            } else {
                session()->flash('error', 'Meeting minute not found.');
            }
        
            return redirect()->route('meetingView', ['meeting' => $this->meetingId]);
        
        } catch (\Exception $e) {
            Log::error('Error updating meeting minute: ' . $e->getMessage());
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function back() {
        return redirect()->route('meetingView', ['meeting' => $this->meetingId]);
    }
    
    ////////////////////////////////////////////////////
    public function render() {
        
        if (empty($this->minutesId)) {
            $this->meetingMinute = "";
        } else {
            $this->meetingMinute = MeetingMinute::find($this->minutesId);
            $this->meetingMinuteDate = $this->meetingMinute->date;
            $this->meetingMinuteState = $this->meetingMinute->state; 
            
            $this->meetingMinuteItems = $this->meetingMinute->meetingMinuteItems()->get();
            
        } 

        Log::info("render new-meeting-minute");
        return view('ezimeeting::livewire.meeting.new-meeting-minute', ['meetingId' => $this->meetingId]);
    }

}