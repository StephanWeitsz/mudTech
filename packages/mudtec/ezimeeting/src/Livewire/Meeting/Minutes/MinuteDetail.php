<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting\Minutes;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Log;

use Mudtec\Ezimeeting\Models\Meeting;
use Mudtec\Ezimeeting\Models\MeetingStatus;
use Mudtec\Ezimeeting\Models\MeetingInterval;

use Mudtec\Ezimeeting\Models\MeetingDelegate;
use Mudtec\Ezimeeting\Models\MeetingMinute;
use Mudtec\Ezimeeting\Models\MeetingMinuteItem;
use Mudtec\Ezimeeting\Models\MeetingMinuteNote;
use Mudtec\Ezimeeting\Models\MeetingMinuteAction;
use Mudtec\Ezimeeting\Models\MeetingMinuteActionStatus;
use Mudtec\Ezimeeting\Models\MeetingMinuteDescriptor;
use Mudtec\Ezimeeting\Models\MeetingMinuteDescriptorFeedback;
use Mudtec\Ezimeeting\Models\ActionResponsibility;

class MinuteDetail extends Component
{
    use WithFileUploads;

    public $meetingDelegates;
    public $selectedDelegate = "";

    public $meetingId;
    public $minuteId;

    public $isEndMeetingOpen;
    #[Rule('required', 'date')]
    public $meetingDate;
    #[Rule('nullable', 'file', 'mimes:txt,pdf,doc,docx', 'max:10240')] // max 10MB
    public $meetingTranscript;
    public $meetingState;

    public $meetingMinute;
    public $meetingMinuteItems = [];
    public $meetingMinuteNotes = [];
    public $meetingMinuteActions = [];
    public $meetingMinuteFeedbacks = [];

    public $NewButtonColor = 'blue';
    public $itemButtonColor = 'green';
    public $noteButtonColor = 'yellow';
    public $actionButtonColor = 'purple';
    public $feedbackButtonColor = 'blue';

    #[Rule('required', 'max:255')]
    public $itemDescription;
    #[Rule('required', 'max:255')]
    public $itemText;
    #[Rule('required', 'date')]
    public $itemLogged;
    #[Rule('nullable', 'date')]
    public $itemClosed;
    public $selectedItemId;
    public $editingItemId;
    public $isItemOpen = false;
    
    #[Rule('required', 'min:2', 'max:255')]
    public $noteDescription;
    #[Rule('required', 'min:10', 'max:255')]
    public $noteText;
    public $selectedNoteId;
    public $editingNoteId;
    public $isNoteOpen;
    
    #[Rule('required', 'min:2', 'max:255')]
    public $actionDescription;
    #[Rule('required', 'min:10', 'max:255')]
    public $actionText;
    public $selectedActionId; 
    public $editingActionId;
    public $isActionOpen;
    
    #[Rule('required', 'min:2', 'max:255')]
    public $feedbackText;
    public $editingFeedbackId;
    public $selectedDescriptorId;
    public $isFeedbackOpen;
    
    public $page_heading = 'Meeting Minutes';
    public $page_sub_heading = ''; 

    public function mount($meetingId, $minuteId) 
    {
        $this->meetingId = $meetingId;
        $this->minuteId = $minuteId;
    }

    public function createMeetingMinute()
    {
        $this->validate();

        //Set meeting Status to in-Progress
        $meetingStatusId = MeetingStatus::where('description','In-Progress')->first();
        Meeting::where('id', $this->meetingId)->update(['meeting_status_id' => $meetingStatusId->id]); 
        
        $Data['meeting_id'] = $this->meetingId;
        $Data['meeting_date'] = $this->meetingDate;
        $Data['meeting_state'] = "Started";
        
        try {
            // Retrieve the latest meeting minute based on the meeting_id
            $previouse_meetingMinute = MeetingMinute::where('meeting_id', $this->meetingId)->latest()->first();
            if ($previouse_meetingMinute) {
                
                // Create the new meeting minute record
                $this->meetingMinute = MeetingMinute::create($Data);
                session()->flash('success', 'Meeting minute created successfully');
                $this->page_sub_heading = 'Meeting Minutes for ' . \Carbon\Carbon::parse($this->meetingDate)->format('Y-m-d');
                $this->minuteId = $this->meetingMinute->id;
        
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
                            $asId = $action->meeting_minute_action_status_id;
                            $actionStatus = MeetingActionStatus::where('id', $asId)->first();
                            if($actionStatus->description == "New")
                                $newActionStatus = MeetingActionStatus::where('description', 'In Progress')->first();

                            $newAction = MeetingMinuteAction::create([
                                'description' => $action->description,
                                'text' => $action->text,
                                'date_logged' => $action->date_logged,
                                'meeting_minute_note_id' => $newNote->id,
                                'meeting_minute_action_status_id' => $newActionStatus->id,
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
                $this->page_sub_heading = 'Meeting Minutes for ' . \Carbon\Carbon::parse($this->meetingDate)->format('Y-m-d');
                $this->minuteId = $this->meetingMinute->id; 
            }
        } //try 
        catch (\Exception $e) {
            Log::error('Error creating meeting minute: ' . $e->getMessage());
            session()->flash('error', 'Error: creating meeting minute : ' . $e->getMessage()); 
        } //catch (\Exception $e) {
    } //public function createMeetingMinute() 

    ////////////////////////////////////////////////////
    //Items
    ////////////////////////////////////////////////////
    public function showAddItem()
    {
        Log::debug("clicked showAddItem");
        $this->itemDescription = '';
        $this->itemText = '';
        $this->isItemOpen = true;
    } //public function showAddItem()
    
    public function hideAddItem()
    {
        $this->isItemOpen = false;
    } //public function hideAddItem()

    public function submitNewItem() 
    {
        $this->isItemOpen = false;
        $this->validate();
        
        try {
            $item = MeetingMinuteItem::create([
                'description' => $this->itemDescription,
                'text' => $this->itemText,
                'date_logged' => date("Y-m-d"),
            ]);
            $meetingMinute->items()->attach($item->id);
            session()->flash('success', 'Meeting minute item created successfully');
        } //try {}
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: creating meeting minute item.');      
        } //catch (\Exception $e) {
    } //public function submitNewItem() 

    public function removeItem($itemId)
    {
        try {
            $item = MeetingMinuteItem::findOrFail($itemId);
            $this->meetingMinute->meetingMinuteItems()->detach($itemId);
            $item->delete();
            session()->flash('success', 'Meeting minute item removed successfully');
        } //try {
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: removing meeting minute item. ');
        } //catch (\Exception $e) {
    } //public function removeItem($itemId)

    public function editItem($itemId)
    {
        $item = MeetingMinuteItem::findOrFail($itemId);
        $this->itemDescription = $item->description;
        $this->itemText = $item->text;
        $this->itemLogged = \Carbon\Carbon::parse($item->date_logged)->format('Y-m-d');
        $this->itemClosed = \Carbon\Carbon::parse($item->closed)->format('Y-m-d');
        $this->isItemOpen = true;
        $this->editingItemId = $itemId;
    } //public function editItem($itemId)

    public function saveItem()
    {
        $this->validate();

        try {
            $item = MeetingMinuteItem::findOrFail($this->editingItemId);
            $item->description = $this->itemDescription;
            $item->text = $this->itemText;
            $item->date_logged = $this->itemLogged;
            $item->save();

            $this->isItemOpen = false;
            $this->editingItemId = null;
            session()->flash('success', 'Meeting minute item updated successfully');
        } //try {} 
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: updating meeting minute item. ' . $e->getMessage());
        } //} catch (\Exception $e) {
    } //public function saveItem()

    public function closeItem($itemId) {
        try {
            $item = MeetingMinuteItem::findOrFail($itemId);
    
            $openDescriptors = MeetingMinuteDescriptor::where('meeting_minute_item_id', $itemId)
                ->whereNull('date_closed')
                ->exists();
    
            if ($openDescriptors) {
                session()->flash('error', 'This item cannot be closed because there are still active notes or actions.');
                return;
            } //if ($openDescriptors) {
    
            $item->date_closed = date("Y-m-d");
            $item->save();
    
            session()->flash('success', 'Meeting minute item closed successfully.');
        } //try`{ 
        catch (\Exception $e) {
            Log::error('Error closing item: ' . $e->getMessage());
            session()->flash('error', 'Error: Unable to close the item.');
        } //catch (\Exception $e) {
    } //public function closeItem($itemId) {

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
    } //public function showAddNote($itemId) 

    public function hideAddNote()
    {
        Log::info("clicked hideAddNote");
        $this->isNoteOpen = false;
    } //public function hideAddNote()

    public function submitNewNote() 
    {
        Log::debug("clicked submitNewNote");
        $this->validate();
        
        try {
            $note = MeetingMinuteNote::create([
                'description' => $this->noteDescription,
                'text' => $this->noteText,
            ]);

            $note_descriptor = $note->descriptors()->create([
                'meeting_minute_id' => $this->minuteId,
                'meeting_minute_item_id' => $this->selectedItemId,
                'date_logged' => date("Y-m-d"),
            ]);
            session()->flash('success', 'Meeting minute Note created successfully');
        } //try {
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: creating meeting minute note.');
        } //catch (\Exception $e) {
        $this->isNoteOpen = false;   
    } //public function submitNewNote() 

    public function removeNote($noteId)
    {
        try {
            $note = MeetingMinuteNote::findOrFail($noteId);
            $descriptor = MeetingMinuteDescriptor::where('meeting_minute_note_id', $noteId)->first();

            if ($descriptor) {
                $descriptor->delete();
            } //if ($descriptor) {

            $note->delete();
            session()->flash('success', 'Meeting minute Note removed successfully');
        } //try { 
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: removing meeting minute note. ');
        } //catch (\Exception $e) {
    }

    public function editNote($noteId)
    {
        $note = MeetingMinuteNote::findOrFail($noteId);
        $this->noteDescription = $note->description;
        $this->noteText = $note->text;
        $this->isNoteOpen = true;
        $this->editingNoteId = $noteId;
    } //public function editNote($noteId)

    public function saveNote()
    {
        $validatedData = $this->validate();

        $note = MeetingMinuteNote::findOrFail($this->editingNoteId);
        $note->description = $this->noteDescription;
        $note->text = $this->noteText;
        $note->save();

        $this->isNoteOpen = false;
        session()->flash('success', 'Meeting minute note updated successfully');
    } //public function saveNote()

    public function closeNote($noteId) {
        try {
            $openDescriptors = MeetingMinuteDescriptor::where('meeting_minute_item_id', $itemId)
                ->where('parent_descriptor_id', $noteId) 
                ->whereNull('date_closed')
                ->exists();

            if ($openDescriptors) {
                session()->flash('error', 'This item cannot be closed because there are still active notes or actions.');
                return;
            } //if ($openDescriptors) {

            $noteDescriptors = MeetingMinuteDescriptor::where('meeting_minute_item_id', $itemId)
                ->where('descriptor_id', $noteId)
                ->whereNull('date_closed')
                ->get();

            $note_cnt = 0;
            foreach ($noteDescriptors as $descriptor) {
                if (strpos($descriptor->type, 'note')) {
                    $note_cnt++;
                    $descriptor->date_closed = date("Y-m-d");
                    $descriptor->save();
                } //if (strpos($descriptor->type, 'note')) {
            } //foreach ($noteDescriptors as $descriptor) {

            if($note_cnt > 0) {
                session()->flash('success', 'Meeting minute note closed $note_cnt successfully.');
            } //if($note_cnt > 0) {
            else {
                session()->flash('error', 'Error: No Notes found to be closed.');
            } //else
        } //try {
        catch (\Exception $e) {
            Log::error('Error closing note: ' . $e->getMessage());
            session()->flash('error', 'Error: Unable to close the note.');
        } //catch (\Exception $e) {

        $this->isNoteOpen = false;
    } //public function closeNote($noteId) {

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
        $this->isActionOpen = true;
    } //public function showAddAction($noteId) 

    public function hideAddAction()
    {
        $this->isActionOpen = false;
    } //public function hideAddAction()

    public function submitNewAction() 
    {
        $this->isActionOpen = false;
        $validatedData = $this->validate();

        try {
            $initStatus = MeetingMinuteActionStatus::where('description','New')->first();
        
            $action = MeetingMinuteAction::create([
                'description' => $this->actionDescription,
                'text' => $this->actionText,
                'meeting_minute_action_status_id' => $initStatus->id,
            ]);

            if($this->selectedNoteId) {
                $action_descriptor = $action->descriptors()->create([
                    'meeting_minute_id' => $meetingId,
                    'meeting_minute_item_id' => $this->selectedItemId,
                    'date_logged' => now(),
                    'parent_descriptor_id' => $this->selectedNoteId,
                ]);
            } //if($this->selectedNoteId) {
            else {
                $action_descriptor = $action->descriptors()->create([
                    'meeting_minute_id' => $this->minuteId,
                    'meeting_minute_item_id' => $this->selectedItemId,
                    'date_logged' => now(),
                ]);
            } //else

            $action = MeetingMinuteAction::create($Data);
       
            if ($this->selectedDelegate and $this->selectedDelegate != "ALL") {
                ActionResponsibility::create([
                    'meeting_minute_action_id' => $action->id,
                    'meeting_delegate_id' => $this->selectedDelegate,
                ]);
            } //if ($this->selectedDelegate and $this->selectedDelegate != "ALL") {
        } //try 
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: creating meeting minute action. ');
        } //catch (\Exception $e) {

        $this->isActionOpen = false;
        session()->flash('success', 'Meeting minute Action created successfully');
    } //public function submitNewAction()

    public function removeAction($actionId)
    {
        try {
            $action = MeetingMinuteAction::findOrFail($actionId);
            $this->meetingMinuteItem->meetingMinuteItems()->meetingMinuteNotes()->meetingMinuteActions()->detach($actionId);
            $action->delete();
            session()->flash('success', 'Meeting minute Action removed successfully');
        } //try { 
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: removing meeting minute Action. ');
        } //catch (\Exception $e) {
    } //public function removeAction($actionId) {

    public function rescheduleAction($actionId)
    {
        /*
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
        */
    } //public function rescheduleAction($actionId)

    public function editAction($actionId)
    {
        $action = MeetingMinuteAction::findOrFail($actionId);
        $this->actionDescription = $action->description;
        $this->actionText = $action->text;
        $this->isActionOpen = true;
        $this->editingActionId = $actionId;
    } //public function editAction($actionId)

    public function saveAction()
    {
        $validatedData = $this->validate();

        try {
            $action = MeetingMinuteAction::findOrFail($this->editingActionId);
            $action->description = $this->actionDescription;
            $action->text = $this->actionText;
            $action->save();

            // Update the delegate link
            if ($this->selectedDelegate && $this->selectedDelegate != "ALL") {
                ActionResponsibility::updateOrCreate(
                    [
                        'meeting_minute_action_id' => $action->id,
                    ],
                    [
                        'meeting_delegate_id' => $this->selectedDelegate,
                    ]
                );
            } //if ($this->selectedDelegate && $this->selectedDelegate != "ALL") {
        } //try {
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: updating meeting minute action. ');
        } //catch (\Exception $e) {

        $this->isActionOpen = false;
        $this->editingActionId = null;
        session()->flash('success', 'Meeting minute action updated successfully');
    } //public function saveAction()

    public function closeAction($actionId) {
        try {
            $actionDescriptors = MeetingMinuteDescriptor::where('meeting_minute_item_id', $itemId)
                ->where('descriptor_id', $actionId)
                ->whereNull('date_closed')
                ->get();

            $acton_cnt = 0;
            foreach ($actionDescriptors as $descriptor) {
                if (strpos($descriptor->type, 'action')) {
                    $actionHasFeedback = MeetingMinuteDescriptorFeedback::where('meeting_minute_descriptor_id', $descriptor->id)
                        ->exists();

                    if (!$actionHasFeedback) {
                        session()->flash('error', 'This item cannot be closed because there are still feedback required.');
                        return;
                    } //if ($openDescriptors) {

                    $action_cnt++;
                    $descriptor->date_closed = date("Y-m-d");
                    $descriptor->save();
                } //if (strpos($descriptor->type, 'action')) {
            } //foreach ($noteDescriptors as $descriptor) {

            if($action_cnt > 0) {
                session()->flash('success', 'Meeting minute action closed $action_cnt successfully.');
            } //if($note_cnt > 0) {
            else {
                session()->flash('error', 'Error: No actions found to be closed.');
            } //else
        } //try {
        catch (\Exception $e) {
            Log::error('Error closing action: ' . $e->getMessage());
            session()->flash('error', 'Error: Unable to close the action.');
        } //catch (\Exception $e) {

        $this->isNoteOpen = false;
    } //public function closeAction($actionId) {
    
    public function onDelegateSelected($selected_id) {
        $this->selectedDelegate = $selected_id;
    } //public function onDelegateSelected($selected_id) {

    /////////////////////////////////////////////////////
    //Feedback
    ////////////////////////////////////////////////////

    public function showAddFeedback($descriptorId) 
    {
        $this->selectedDescriptorId = $descriptorId;
        $this->feedbackText = "";
        $this->isFeedbackOpen = true;
    } //public function showAddFeedback($descriptorId) 

    public function hideAddFeedback()
    {
        $this->isFeedbackOpen = false;
    }

    public function submitNewFeedback() 
    {
        $this->isFeedbackOpen = false;
        $validatedData = $this->validate();

        try {
            $feedback = MeetingMinuteDescriptorFeedback::create([
                'text' =>  $this->feedbackText,
                'date_logged' => date("Y-m-d"),
                'meeting_minute_descriptor_id' => $this->selectedDescriptorId,
            ]);
            session()->flash('success', 'Meeting minute Feedback created successfully');
        } //try {
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: creating meeting minute feedback. ');
        } //catch (\Exception $e) {    
    } //public function submitNewFeedback() 

    public function removeFeedback($feedbackId)
    {
        try {
            $feedback = MeetingMinuteDescriptorFeedback::findOrFail($feedbackId);
            $feedback->delete();
            session()->flash('success', 'Meeting minute feedback removed successfully');
        } //try {
        catch (\Exception $e) {
            session()->flash('error', 'Error: removing meeting minute Feedback. ' . $e->getMessage());
        } //catch (\Exception $e) {
    } //public function removeFeedback($feedbackId)

    public function editFeedback($feedbackId)
    {
        $feedback = MeetingMinuteDescriptorFeedback::findOrFail($feedbackId);
        $this->actionText = $feedback->text;
        $this->isFeedbackOpen = true;
        $this->editingFeedbackId = $feedbackId;
    } //public function editFeedback($feedbackId)

    public function saveFeedback()
    {
        $validatedData = $this->validate();
        
        try {
            $feedback = MeetingMinuteDescriptorFeedback::findOrFail($this->editingFeedbackId);
            $feedback->text = $this->feedbackText;
            $feedback->save();
        } //try {
        catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Error: updating meeting minute feedback. ');
        } //catch (\Exception $e) {

        $this->isFeedbackOpen = false;
        $this->editingFeedbackId = null;
        session()->flash('success', 'Meeting minute feedback updated successfully');
    } //public function saveFeedback()


    /////////////////////////////////////////////////////

    public function showEndMeeting() {
        $this->isEndMeetingOpen = true;
        $this->meetingDate = \Carbon\Carbon::parse($this->meetingDate)->format('Y-m-d');
    }

    public function signoffMeetingMinute() {
        $this->isEndMeetingOpen = false;

        $validatedData = $this->validate([
            'meetingDate' => ['required', 'date'],
            'meetingTranscript' => ['nullable', 'file', 'mimes:txt,pdf,doc,docx', 'max:10240'], // max 10MB
        ]);

        $meeting_interval_id = Meeting::where('id', $this->meetingId)->first()->meeting_interval_id;
        $meeting_interval = MeetingInterval::find($meeting_interval_id);
        $interval_formula = $meeting_interval->formula;
        if (strpos($interval_formula, '+') !== false) {
            preg_match('/(\d+)([a-z]+)/', $interval_formula, $matches);
            $interval_value = (int) $matches[1];
            $interval_unit = $matches[2];

            $new_scheduled_at = \Carbon\Carbon::parse($this->meetingDate);

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
            $new_scheduled_at = \Carbon\Carbon::parse($this->meetingDate)->format('Y-m-d');
        }    
    
        $meetingStatusId = MeetingStatus::where('description','Active')->first();
        Meeting::where('id', $this->meetingId)->update([
            'meeting_status_id' => $meetingStatusId->id,
            'scheduled_at' => $new_scheduled_at,
        ]);

        $Data['date'] = $this->meetingDate;
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

        //return redirect()->route('meetingView', ['meeting' => $this->meetingId]);

        return redirect()->route('MeetingMinuteList', ['meetingId' => $this->meetingId]);
    }
    
    ////////////////////////////////////////////////////
    public function render() {
        if (empty($this->minuteId)) {
            $this->meetingMinute = "";
            $this->page_sub_heading = 'Capture meetings minutes'; 

        } else {
            $this->meetingMinute = MeetingMinute::find($this->minuteId);
            $this->meetingDate = $this->meetingMinute->meeting_date;
            $this->meetingState = $this->meetingMinute->meeting_state;
            
            $this->meetingMinuteItems = $this->meetingMinute->items()->get();
         

            //$meetingMinuteNotes = ;
            //$meetingMinuteActions = ;
            //$meetingMinuteFeedbacks = ;

            
/*
            if ($this->meetingMinute->descriptors()->exists()) {
                //dd($this->meetingMinute->descriptors);
            }
*/

/*
            if ($this->meetingMinute->items->isNotEmpty()) {
            if ($this->meetingMinute->items()->exists()) {    
                
                $this->meetingMinuteItems = $this->meetingMinute->Items()->get();
                $meetings = MeetingMinute::with('items')->get();

                MeetingMinuteDescriptor 

            }
  */

            $this->page_sub_heading = 'Meeting Minutes for ' . \Carbon\Carbon::parse($this->meetingDate)->format('Y-m-d');
        } 

        Log::info("render new-meeting-minute");
        return view('ezimeeting::livewire.meeting.minutes.minute-detail', ['meetingId' => $this->meetingId]);
    }

}