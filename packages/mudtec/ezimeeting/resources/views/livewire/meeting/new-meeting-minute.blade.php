<div class="flex flex-col items-center justify-center py-5 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.ezi-full-heading')

        @include('ezimeeting::livewire.includes.warnings.success')
        @include('ezimeeting::livewire.includes.warnings.error')         
        
        <div class="container mx-auto py-3">
            <div class="flex flex-wrap justify-between">

                @if(empty($minutesId))
                    <form wire:submit.prevent="createMeetingMinute">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label for="meetingMinuteDate"
                                       class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" 
                                >
                                    Meeting Date
                                </label>
                                <input wire:model="meetingMinuteDate" 
                                       type="date" 
                                       id="meetingMinuteDate"
                                       name="meetingMinuteDate"
                                       class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                       required>
                                @error('meetingMinuteDate') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="meetingMinuteTranscript">
                                    Transcript
                                </label>
                                <input wire:model="meetingMinuteTranscript"
                                       type="file"
                                       id="meetingMinuteTranscript"  
                                       name="meetingMinuteTranscript"
                                       accept=".txt,.pdf,.doc,.docx"      
                                       class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                @error('meetingMinuteTranscript') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="w-full border border-gray-300 rounded-lg overflow-hidden">
                        {{--
                        <!-- Table Header -->
                        <div class="grid grid-cols-10 bg-gray-200 text-gray-700 font-bold border-b border-gray-300">
                            <div class="col-span-1 px-4 py-2 border-r">A</div>
                            <div class="col-span-1 px-4 py-2 border-r">B</div>
                            <div class="col-span-4 px-4 py-2 border-r">C</div>
                            <div class="col-span-2 px-4 py-2 border-r">D</div>
                            <div class="col-span-2 px-4 py-2">E</div>
                        </div>
                        --}}

                        {{--@dump($meetingMinuteState)--}}

                        <!-- Action Button -->
                        @if($meetingMinuteState == 'started')
                            <div class="flex justify-end p-4 bg-white">
                                <button wire:click="showAddItem"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                                    New
                                </button>
                            </div>
                        @endif

                        <!-- Table Rows -->
                        @if($meetingMinuteItems)
                            @foreach($meetingMinuteItems as $item)
                                <div class="grid grid-cols-10 border-b border-gray-300">
                                    @if($meetingMinuteState == 'started')
                                        <div class="col-span-6 px-4 py-2 border-r"><h3>{{$item->description}}</h3><br><pre>{{$item->text}}</pre></div>
                                    @else
                                        <div class="col-span-8 px-4 py-2 border-r"><h3>{{$item->description}}</h3><br><pre>{{$item->text}}</pre></div>
                                    @endif    
                                    <div class="col-span-2 px-4 py-2 border-r">
                                        {{ \Carbon\Carbon::parse($item->date_logged)->format('Y-m-d') }}
                                        @if($item->date_closed)
                                            <br> to <br>
                                            {{ \Carbon\Carbon::parse($item->date_closed)->format('Y-m-d') }}
                                        @endif
                                    </div>
                                    @if($meetingMinuteState == 'started')
                                        <div class="col-span-2 px-4 py-2">
                                            <div class="flex flex-wrap">
                                                <div class="w-1/2 px-2 mb-2">
                                                    <button wire:click="showAddNote({{$item->id}})"
                                                            class="bg-{{$itemButtonColor}}-500 hover:bg-{{$itemButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                        <i class="fas fa-sticky-note" title="New Note {{$item->id}}"></i>
                                                    </button>
                                                </div>
                                                @if(strtotime($item->date_logged) == strtotime($meetingMinuteDate))
                                                    <div class="w-1/2 px-2 mb-2">
                                                        <button wire:click="editItem({{$item->id}})"
                                                                class="bg-{{$itemButtonColor}}-500 hover:bg-{{$itemButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                            <i class="fas fa-edit"  title="Edit Item"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                                @if(strtotime($item->date_logged) == strtotime($meetingMinuteDate))
                                                    <div class="w-1/2 px-2">
                                                        <button wire:click="removeItem({{$item->id}})"
                                                                class="bg-{{$itemButtonColor}}-500 hover:bg-{{$itemButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                            <i class="fas fa-trash" title="Remove Item"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                                @if(strtotime($item->date_logged) != strtotime($meetingMinuteDate))
                                                    <div class="w-1/2 px-2">
                                                        <button wire:click="closeItem({{$item->id}})"
                                                                class="bg-{{$itemButtonColor}}-500 hover:bg-{{$itemButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                            <i class="fas fa-times"  title="Close Item"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif    
                                </div>

                                @if($item->meetingMinuteNotes) 
                                    @foreach($item->meetingMinuteNotes as $note)
                                        <div class="grid grid-cols-10 border-b border-gray-300 bg-gray-50">
                                            <div class="col-span-1 px-4 py-2 border-r">*</div>
                                            @if($meetingMinuteState == 'started')
                                                <div class="col-span-5 px-4 py-2 border-r"><h3>{{$note->description}}</h3><br><pre>{{$note->text}}</pre></div>
                                            @else
                                                <div class="col-span-7 px-4 py-2 border-r"><h3>{{$note->description}}</h3><br><pre>{{$note->text}}</pre></div>
                                            @endif
                                            <div class="col-span-2 px-4 py-2 border-r">{{ \Carbon\Carbon::parse($note->date_logged)->format('Y-m-d')}}</div>
                                            @if($meetingMinuteState == 'started')
                                                <div class="col-span-2 px-4 py-2">
                                                    <div class="flex flex-wrap">
                                                        <div class="w-1/2 px-2 mb-2">
                                                            <button wire:click="showAddAction({{$note->id}})"
                                                                    class="bg-{{$noteButtonColor}}-500 hover:bg-{{$noteButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                <i class="fas fa-sticky-note" title="New Note"></i>
                                                            </button>
                                                        </div>
                                                        @if(strtotime($note->date_logged) == strtotime($meetingMinuteDate))
                                                            <div class="w-1/2 px-2 mb-2">
                                                                <button wire:click="editNote({{$note->id}})"
                                                                        class="bg-{{$noteButtonColor}}-500 hover:bg-{{$noteButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                    <i class="fas fa-edit"  title="Edit Note"></i>
                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if(strtotime($note->date_logged) == strtotime($meetingMinuteDate))
                                                            <div class="w-1/2 px-2">
                                                                <button wire:click="removeNote({{$note->id}})"
                                                                        class="bg-{{$noteButtonColor}}-500 hover:bg-{{$noteButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                    <i class="fas fa-trash" title="Remove Note"></i>
                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if(strtotime($note->date_logged) != strtotime($meetingMinuteDate))
                                                            <div class="w-1/2 px-2">
                                                                <button wire:click="closeNote({{$note->id}})"
                                                                        class="bg-{{$noteButtonColor}}-500 hover:bg-{{$noteButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                    <i class="fas fa-times"  title="Close Note"></i>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        @if($note->meetingMinuteActions->isNotEmpty()) 
                                            @foreach($note->meetingMinuteActions as $action)
                                                <div class="grid grid-cols-10 border-b border-gray-300">
                                                    <div class="col-span-1 px-4 py-2 border-r">
                                                        <span class="inline-block w-10 h-10 rounded-full" 
                                                            style="background-color: {{ $action->meetingMinuteActionStatus->color }};">
                                                        </span>
                                                        {{$action->meetingMinuteActionStatus->description}}
                                                    </div>
                                                  
                                                    @if($meetingMinuteState == 'started')
                                                        <div class="col-span-5 px-4 py-3 border-r">
                                                            <h3>{{$action->description}}</h3>
                                                            <br>
                                                            <pre>{{$action->text}}</pre>
                                                        
                                                            @if($action->delegates->isNotEmpty())
                                                                <div class="mt-5 p-2 border border-red-200 bg-gray-300"> 
                                                                    <strong>OWNER</strong>
                                                                    @foreach ($action->delegates as $delegate)
                                                                        <br>
                                                                        {{ $delegate->delegate_name }} ({{$delegate->delegate_email}})
                                                                        <br>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <div class="mt-5 p-2 border border-red-200 bg-gray-300"> 
                                                                    <strong>TO BE DONE BY ALL</strong>
                                                                </div>    
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div class="col-span-7 px-4 py-3 border-r"><h3>{{$action->description}}</h3><br><pre>{{$action->text}}</pre></div>
                                                    @endif
                                                    <div class="col-span-2 px-4 py-2 border-r">{{ \Carbon\Carbon::parse($action->date_logged)->format('Y-m-d')}}</div>
                                                    @if($meetingMinuteState == 'started')
                                                        <div class="col-span-2 px-4 py-2">
                                                            <div class="flex flex-wrap">
                                                                <div class="w-1/2 px-2 mb-2">
                                                                    <button wire:click="showAddFeedback({{$action->id}})"
                                                                            class="bg-{{$actionButtonColor}}-500 hover:bg-{{$actionButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                        <i class="fas fa-sticky-note" title="New Feedback"></i>
                                                                    </button>
                                                                </div>
                                                                @if(strtotime($action->date_logged) == strtotime($meetingMinuteDate))
                                                                    <div class="w-1/2 px-2 mb-2">
                                                                        <button wire:click="editAction({{$action->id}})"
                                                                                class="bg-{{$actionButtonColor}}-500 hover:bg-{{$actionButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                            <i class="fas fa-edit"  title="Edit Action"></i>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                                @if(strtotime($action->date_logged) == strtotime($meetingMinuteDate))    
                                                                    <div class="w-1/2 px-2">
                                                                        <button wire:click="removeAction({{$action->id}})"
                                                                                class="bg-{{$actionButtonColor}}-500 hover:bg-{{$actionButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                            <i class="fas fa-trash" title="Remove Action"></i>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                                @if(strtotime($action->date_logged) == strtotime($meetingMinuteDate))    
                                                                    <div class="w-1/2 px-2">
                                                                        <button wire:click="rescheduleAction({{$action->id}})"
                                                                                class="bg-{{$actionButtonColor}}-500 hover:bg-{{$actionButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                            <i class="fas fa-trash" title="Reschedule Due Date on Action"></i>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                                @if(strtotime($action->date_logged) != strtotime($meetingMinuteDate))
                                                                    <div class="w-1/2 px-2">
                                                                        <button wire:click="closeAction({{$action->id}})"
                                                                                class="bg-{{$actionButtonColor}}-500 hover:bg-{{$actionButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                            <i class="fas fa-times"  title="Close Action"></i>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                @if($action->meetingMinuteActionFeedbacks)
                                                    @foreach($action->meetingMinuteActionFeedbacks as $feedback)
                                                        <div class="grid grid-cols-10 border-b bg-blue-100 border-gray-300 bg-gray-50">
                                                            <div class="col-span-1 px-4 py-2 border-r"></div>
                                                            @if($meetingMinuteState == 'started')
                                                                <div class="col-span-5 px-4 py-2 border-r"><pre>{{$feedback->text}}</pre></div>
                                                            @else
                                                                <div class="col-span-7 px-4 py-2 border-r"><pre>{{$feedback->text}}</pre></div>
                                                            @endif    
                                                            <div class="col-span-2 px-4 py-2 border-r">{{ \Carbon\Carbon::parse($feedback->date_logged)->format('Y-m-d')}}</div>
                                                            @if($meetingMinuteState == 'started')
                                                                <div class="col-span-2 px-4 py-2">
                                                                    <div class="flex flex-wrap">
                                                                        @if(strtotime($feedback->date_logged) == strtotime($meetingMinuteDate))
                                                                            <div class="w-1/3 px-2 mb-2">
                                                                                <button wire:click="editFeedback({{$feedback->id}})"
                                                                                        class="bg-{{$feedbackButtonColor}}-500 hover:bg-{{$feedbackButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                                    <i class="fas fa-edit"  title="Edit Feedback"></i>
                                                                                </button>
                                                                            </div>
                                                                        @endif    
                                                                        @if(strtotime($feedback->date_logged) == strtotime($meetingMinuteDate))
                                                                            <div class="w-1/3 px-2">
                                                                                <button wire:click="removeFeedback({{$feedback->id}})"
                                                                                        class="bg-{{$feedbackButtonColor}}-500 hover:bg-{{$feedbackButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                                    <i class="fas fa-trash" title="Remove Feedback"></i>
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                        {{--
                                                                        @if(strtotime($feedback->date_logged) != strtotime($meetingMinuteDate))
                                                                            <div class="w-1/3 px-2">
                                                                                <button wire:click="closeFeedback({{$feedback->id}})"
                                                                                        class="bg-{{$feedbackButtonColor}}-500 hover:bg-{{$feedbackButtonColor}}-700 text-white font-bold py-2 px-4 rounded w-full">
                                                                                    <i class="fas fa-times"  title="Close Feedback"></i>
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                        --}}
                                                                    </div>
                                                                </div>
                                                            @endif    
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach  
                                @endif
                            @endforeach    
                        @endif

                        <!-- Modal Item -->
                        @if($isItemOpen)
                            <div class="fixed z-10 inset-0 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen">
                                    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">

                                                    @if($editingItemId)
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-5" id="modal-title">
                                                            Edit Meeting Item
                                                        </h3>
                                                    @else
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-5" id="modal-title">
                                                            New Meeting Item
                                                        </h3>
                                                    @endif

                                                    <div class="mb-4">
                                                        <label for="itemDescription" class="block text-sm font-medium text-gray-700">Description</label>
                                                        <input wire:model="itemDescription" 
                                                               type="text"
                                                               id="itemDescription"
                                                               class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"
                                                               placeholder="Enter description">
                                                        @error('itemDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4" for="itemText">
                                                            Text
                                                        </label>
                                                        <textarea wire:model="itemText" 
                                                                  class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"
                                                                  placeholder="Enter text">
                                                        </textarea>
                                                        @error('itemText') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                    </div>

                                                    @if($editingItemId))
                                                        <div class="mb-4">
                                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4" for="itemLogged">
                                                                Date Logged
                                                            </label>
                                                            <input type="date"
                                                                id="itemLogged"
                                                                wire:model="itemLogged" 
                                                                class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                                            @error('itemLogged') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            @if($editingItemId)
                                                <button wire:click="saveItem"
                                                        type="button" 
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                    Save
                                                </button>
                                            @else
                                                <button wire:click="submitNewItem"
                                                        type="button" 
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                    Submit
                                                </button>
                                            @endif
                                            <button wire:click="hideAddItem"
                                                    type="button" 
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                                        
                        <!-- Modal Note -->
                        @if($isNoteOpen)
                            <div class="fixed z-10 inset-0 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen">
                                    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">

                                                    @if($editingNoteId)
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-5" id="modal-title">
                                                            Edit Meeting Note
                                                        </h3>
                                                    @else
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-5" id="modal-title">
                                                            New Meeting Note
                                                        </h3>
                                                    @endif

                                                    <div class="mb-4">
                                                        <label for="noteDescription" class="block text-sm font-medium text-gray-700">Description</label>
                                                        <input wire:model="noteDescription"
                                                               type="text"
                                                               id="noteDescription"
                                                               class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"
                                                               placeholder="Enter description">
                                                        @error('noteDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4" for="noteText">
                                                            Text
                                                        </label>
                                                        <textarea wire:model="noteText" 
                                                                  class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"
                                                                  placeholder="Enter text">
                                                        </textarea>
                                                        @error('noteText') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                    </div>

                                                    @if($editingNoteId)
                                                        <div class="mb-4">
                                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4" for="noteLogged">
                                                                Date Logged
                                                            </label>
                                                            <input wire:model="noteLogged"
                                                                   type="date"
                                                                   id="noteLogged"
                                                                   class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                                            @error('noteLogged') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            @if($editingNoteId)
                                                <button wire:click="saveNote"
                                                        type="button" 
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                    Save
                                                </button>
                                            @else
                                                <button wire:click="submitNewNote"
                                                        type="button" 
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                    Submit
                                                </button>
                                            @endif
                                            <button wire:click="hideAddNote"
                                                    type="button" 
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                
                        <!-- Modal Action -->
                        @if($isActionOpen)
                            <div class="fixed z-10 inset-0 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen">
                                    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">

                                                    @if($editingActionId)
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-5" id="modal-title">
                                                            Edit Meeting Action
                                                        </h3>
                                                    @else
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-5" id="modal-title">
                                                            New Meeting Action
                                                        </h3>
                                                    @endif

                                                    <div class="mb-4">
                                                        <label for="actionDescription" class="block text-sm font-medium text-gray-700">Description</label>
                                                        <input wire:model="actionDescription"
                                                               type="text"
                                                               id="actionDescription"
                                                               class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"
                                                               placeholder="Enter description">
                                                        @error('actionDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="actionText" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4">Text</label>
                                                        <textarea wire:model="actionText" 
                                                                  class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"
                                                                  placeholder="Enter text">
                                                        </textarea>
                                                        @error('actionText') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <label for="selectedDelegate" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4">Action Owner</label>
                                                        <select wire:change="onDelegateSelected($event.target.value)" 
                                                                id="selectedDelegate"
                                                                class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                                            <option value="">-- Select Responsibe Person --</option>
                                                            <option value="">All</option>
                                                            @foreach($meetingDelegates as $delegate)
                                                                <option value="{{ $delegate->id }}">{{ $delegate->delegate_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    @if($editingActionId)
                                                        <div class="mb-4">
                                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4" for="actionLogged">
                                                                Date Logged
                                                            </label>
                                                            <input type="date"
                                                                id="actionLogged"
                                                                wire:model="actionLogged" 
                                                                class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                                            @error('actionLogged') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                        </div>
                                                    @endif

                                                    <div class="mb-4">
                                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4" for="actionDue">
                                                            Due Date
                                                        </label>
                                                        <input type="date"
                                                               id="actionDue"
                                                               wire:model="actionDue" 
                                                               class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                                        @error('actionDue') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                    </div>

                                                    @if($actionDue and strtotime($actionLogged) != strtotime($meetingMinuteDate))
                                                        <div class="mb-4">
                                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4" for="actionRevised">
                                                                New Due Date
                                                            </label>
                                                            <input type="date"
                                                                   id="actionRevised"
                                                                   wire:model="actionRevised" 
                                                                   class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                                            @error('actionRevised') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            @if($editingActionId)
                                                <button wire:click="saveAction"
                                                        type="button" 
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                    Save
                                                </button>
                                            @else
                                                <button wire:click="submitNewAction"
                                                        type="button" 
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                    Submit
                                                </button>
                                            @endif
                                            <button wire:click="hideAddAction"
                                                    type="button" 
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    
                        @if($isFeedbackOpen)
                            <div class="fixed z-10 inset-0 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen">
                                    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">

                                                    @if($editingFeedbackId)
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-5" id="modal-title">
                                                            Edit Meeting Action Feedback
                                                        </h3>
                                                    @else
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-5" id="modal-title">
                                                            New Meeting Action Feedback
                                                        </h3>
                                                    @endif

                                                    <div class="mb-4">
                                                        <label for="feedbackDescription" class="block text-sm font-medium text-gray-700">Description</label>
                                                        <input wire:model="feedbackDescription"
                                                               type="text"
                                                               id="feedbackDescription"
                                                               class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"
                                                               placeholder="Enter description">
                                                        @error('feedbackDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="feedbackText" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4">Text</label>
                                                        <textarea wire:model="feedbackText" 
                                                                  class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"
                                                                  placeholder="Enter text">
                                                        </textarea>
                                                        @error('feedbackText') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                    </div>

                                                    @if($editingFeedbackId)
                                                        <div class="mb-4">
                                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-4" for="feedbackLogged">
                                                                Date Logged
                                                            </label>
                                                            <input type="date"
                                                                id="feedbackLogged"
                                                                wire:model="feedbackLogged"
                                                                class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                                            @error('feedbackLogged') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            @if($editingFeedbackId)
                                                <button wire:click="saveFeedback"
                                                        type="button" 
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                    Save
                                                </button>
                                            @else
                                                <button wire:click="submitNewFeedback"
                                                        type="button" 
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                    Submit
                                                </button>
                                            @endif
                                            <button wire:click="hideAddFeedback"
                                                    type="button" 
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6 p-5">
                        <div class="w-full px-3">
                            <button wire:click="back"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                                ← back
                            </button>
                            @if($meetingMinuteState == "started")
                                <button wire:click="showEndMeeting"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                                    End Meeting
                                </button>
                            @endif
                        </div>
                    </div>

                    @if($isEndMeetingOpen)
                        <div class="fixed z-10 inset-0 overflow-y-auto">
                            <div class="flex items-center justify-center min-h-screen">
                                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:items-start">
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <form wire:submit.prevent="signoffMeetingMinute">
                                                    <div class="flex flex-wrap -mx-3 mb-6">
                                                        <div class="w-full px-3 mb-6 md:mb-0">
                                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="meetingMinuteDate">
                                                                Meeting Date
                                                            </label>
                                                            <input wire:model="meetingMinuteDate" 
                                                                type="date" 
                                                                id="meetingMinuteDate"
                                                                name="meetingMinuteDate"
                                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                                display>
                                                            @error('meetingMinuteDate') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-wrap -mx-3 mb-6">
                                                        <div class="w-full px-3">
                                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="meetingMinuteTranscript">
                                                                Transcript
                                                            </label>
                                                            <input wire:model="meetingMinuteTranscript"
                                                                type="file"
                                                                id="meetingMinuteTranscript"  
                                                                name="meetingMinuteTranscript"
                                                                accept=".txt,.pdf,.doc,.docx"      
                                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                                            @error('meetingMinuteTranscript') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-wrap -mx-3 mb-6">
                                                        <div class="w-full px-3">
                                                            <button type="submit"
                                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                                                                Signoff Meeting 
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                @endif  
            </div>
        </div>        
    </div>
</div>